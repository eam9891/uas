<?php

namespace modules\contacts;
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
use framework\core\User;
use framework\database\Database;

class Relation extends Relationship {

    private $USER;
    private $dbCon;

    /**
     * @param \framework\core\User $USER
     *
     * @internal param \modules\contacts\PDO $db
     * @internal param \framework\core\User $loggedInUser
     */
    public function __construct(User &$USER) {
        $this->USER = $USER;
        $this->dbCon = Database::connect();
    }

    /**
    * Return the friend of the current logged in user in the relationship object
    *
    * @param Relationship $rel
    * @return User $friend
    */
    public function getFriend(Relationship $rel) : User {
        $userID = $this->USER->getUserId();
        $user1 = $rel->getUserOne();
        if ($user1->getUserId() === $userID) {
            $friend = $rel->getUserTwo();
        } else {
            $friend = $rel->getUserOne();
        }
        return $friend;
    }

    public function getNumContacts() {
        $id = (int)$this->USER->getUserId();

        $query = <<<TAG

            SELECT * FROM contacts
            WHERE (
                (userOne = :u1 OR userTwo = :u2)
                AND status = :s
            )
        
TAG;
        $query_params = array(
            ':u1' => $id,
            ':u2' => $id,
            ':s' => 1
        );
        try {
            $stmt = $this->dbCon->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $count = $stmt->rowCount();
        return $count;
    }
  
    /**
    * Get all the friends list for the currently loggedin user
    *
    * @return array Relationship Objects
    */
    public function getFriendsList() {
        $id = (int)$this->USER->getUserId();

        $query = "
            SELECT * FROM contacts
            WHERE 
                (userOne = :u1 OR userTwo = :u2)
                AND status = :s
            
        ";
        $query_params = array(
            ':u1' => $id,
            ':u2' => $id,
            ':s' => 1
        );

        try {
            $stmt = $this->dbCon->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $rels = array();

        foreach ($row as $key => $value) {
            $rel = new Relationship();
            $rel->arrToRelationship($value);
            $rels[] = $rel;
        }

        return $rels;
    }
  
    /**
    * Get the list of friend requests sent by the logged in user
    *
    * @return array Relationship Objects
    */
    public function getSentFriendRequests() {
        $id = (int) $this->USER->getUserId();

        $query = "
            SELECT * FROM contacts
            WHERE (
                (userOne = :uID OR userTwo = :uID)
                AND
                status = :s
                 AND
                actionUserID = :uID
        )
        ";
        $query_params = array(
            ':uID' => $id,
            ':s' => 0
        );

        try {
            $stmt = $this->dbCon->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $rels = array();

        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rel = new Relationship();
            $rel->arrToRelationship($row);
            $rels[] = $rel;
        }

        return $rels;
    }
  
    /**
    * Get the list of friend requests for the logged in user
    *
    * @return array Relationship Objects
    */
    public function getFriendRequests() {
        $id = (int) $this->USER->getUserId();

        $query = "
            SELECT * FROM contacts
            WHERE (
                (userOne = :uID OR userTwo = :uID)
            AND
                status = :s
            AND
                actionUserID != :uID
        )
        ";
        $query_params = array(
            ':uID' => $id,
            ':s' => 0
        );

        try {
            $stmt = $this->dbCon->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $rels = array();

        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
          $rel = new Relationship();
          $rel->arrToRelationship($row);
          $rels[] = $rel;
        }

        return $rels;
    }

    /**
    * Get the list of friends blocked by the current user.
    *
    */
    public function getBlockedFriends() {
        $id = (int) $this->USER->getUserId();

        $query = "
            SELECT * FROM contacts
            WHERE (
                (userOne = :uID OR userTwo = :uID)
            AND
                status = :s
            AND
                actionUserID = :uID
        )
        ";
        $query_params = array(
            ':uID' => $id,
            ':s' => 3
        );

        try {
            $stmt = $this->dbCon->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $rels = array();

        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
          $rel = new Relationship();
          $rel->arrToRelationship($row);
          $rels[] = $rel;
        }

        return $rels;
    }

    /**
     * Get the relatiohship for the friend and user
     *
     * @param User $user
     *
     * @return bool|\modules\contacts\Relationship
     */
    public function getRelationship(User $user) {
        $user_one = (int) $this->USER->getUserId();
        $user_two = (int) $user->getUserId();

        if ($user_one > $user_two) {
            $temp = $user_one;
            $user_one = $user_two;
            $user_two = $temp;
        }


        $query = "
            SELECT * FROM contacts
            WHERE 
                userOne = :u1
            AND
                userTwo = :u2
            
        ";
        $query_params = array(
            ':u1' => $user_one,
            ':u2' => $user_two
        );
        $stmt = Database::select($query, $query_params);

        if ($stmt->rowCount() > 0) {
          $row = $stmt->fetch(\PDO::FETCH_ASSOC);
          $relationship = new Relationship();
          $relationship->arrToRelationship($row);
          return $relationship;
        }

        return false;
    }

    /**
    * Insert a new friends request
    *
    * @param User $user - User to which the friend request must be added with.
    * @return Boolean
    */
    public function addFriendRequest(User $user) {
        $user_one = (int) $this->USER->getUserId();
        $action_user_id = $user_one;
        $user_two = (int) $user->getUserId();

        if ($user_one > $user_two) {
            $temp = $user_one;
            $user_one = $user_two;
            $user_two = $temp;
        }

        $sql = 'INSERT INTO `contacts` '
                . '(`userOne`, `userTwo`, `status`, `actionUserID`) '
                . 'VALUES '
                . '(' . $user_one . ', '. $user_two .', 0, '. $action_user_id .')';

        $stmt = Database::query($sql);

        if ($stmt->rowCount() > 0) {
          return true;
        }

        return false;
    }

    /**
     * Accept a friend request
     *
     * @param User $contact - User to whom the friend request must be accepted with.
     *
     * @return string
     */
    public function acceptFriendRequest(User &$contact) {
        $userOne = $this->USER->getUserId();
        $actionUser = $userOne;
        $userTwo = $contact->getUserId();

        if ($userOne > $userTwo) {
            $temp = $userOne;
            $userOne = $userTwo;
            $userTwo = $temp;
        }


        $query = "
            UPDATE contacts 
            SET status = :s, actionUserID = :aUiD 
            WHERE userOne = :u1 AND userTwo = :u2
        ";
        $query_params = array(
            ":s" => 1,
            ":aUiD" => $actionUser,
            ":u1" => $userOne,
            ":u2" => $userTwo
        );

        try {
            $stmt = $this->dbCon->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        echo $userOne;
        echo $userTwo;
        echo $actionUser;

    }

    /**
     * Decline a friend request for the user
     *
     * @params User $user - The user whose request to be declined
     * @param \framework\core\User $user
     *
     * @return bool
     */
    public function declineFriendRequest(User $user) {
    $user_one = (int) $this->USER->getUserId();
    $action_user_id = $user_one;
    $user_two = $user->getUserId();

    if ($user_one > $user_two) {
      $temp = $user_one;
      $user_one = $user_two;
      $user_two = $temp;
    }

    $sql = 'UPDATE `contacts` '
            . 'SET `status` = 2, `actionUserID` = '. $action_user_id
            .' WHERE `userOne` = '. $user_one
            .' AND `userTwo` = ' . $user_two;

    $stmt = Database::query($sql);

    if ($stmt->affected_rows > 0) {
      return true;
    }

    return false;
    }

    /**
    * Cancel a friend request
    *
    * @param User $user - The friend details
    * @return Boolean
    */
    public function cancelFriendRequest(User $user) {
    $user_one = (int) $this->USER->getUserId();
    $user_two = (int) $user->getUserId();

    if ($user_one > $user_two) {
      $temp = $user_one;
      $user_one = $user_two;
      $user_two = $temp;
    }

    $sql = 'DELETE FROM `contacts` ' .
            'WHERE `userOne` = ' . $user_one .
            ' AND `userTwo` = ' . $user_two .
            ' AND `status` = 0';

    $stmt = Database::query($sql);

    if ($stmt->affected_rows > 0) {
      return true;
    }

    return false;
    }

    /**
    * Remove a friend from the friends list
    *
    * @param User $user - The friend details
    * @return Boolean
    */
    public function unfriend(User $user) {
    $user_one = (int) $this->USER->getUserId();
    $user_two = (int) $user->getUserId();

    if ($user_one > $user_two) {
      $temp = $user_one;
      $user_one = $user_two;
      $user_two = $temp;
    }

    $sql = 'DELETE FROM `contacts` ' .
            'WHERE `userOne` = ' . $user_one .
            ' AND `userTwo` = ' . $user_two .
            ' AND `status` = 1';

    $stmt = Database::query($sql);

    if ($stmt->affected_rows > 0) {
      return true;
    }

    return false;
    }

    /**
    * Block a particular user
    *
    * @param User $user - The user to be blocked
    * @return Boolean
    */
    public function block(User $user) {
    $user_one = (int) $this->USER->getUserId();
    $action_user_id = $user_one;
    $user_two = $user->getUserId();

    if ($user_one > $user_two) {
      $temp = $user_one;
      $user_one = $user_two;
      $user_two = $temp;
    }

    $sql = 'UPDATE `contacts` '
            . 'SET `status` = 3, `actionUserID` = '. $action_user_id
            .' WHERE `userOne` = '. $user_one
            .' AND `userTwo` = ' . $user_two;

    $stmt = Database::query($sql);

    if ($stmt->affected_rows > 0) {
      return true;
    }

    return false;
    }

    /**
    * Unblock a friend who is blocked already.
    *
    * @param User $user
    * @return boolean
    */
    public function unblockFriend(User $user) {
    $user_one = (int) $this->USER->getUserId();
    $user_two = (int) $user->getUserId();

    if ($user_one > $user_two) {
      $temp = $user_one;
      $user_one = $user_two;
      $user_two = $temp;
    }

    $sql = 'DELETE FROM `contacts` ' .
            'WHERE `userOne` = ' . $user_one .
            ' AND `userTwo` = ' . $user_two .
            ' AND `status` = 3';

    $stmt = Database::query($sql);

    if ($stmt->affected_rows > 0) {
      return true;
    }

    return false;
    }
}