<?php

namespace modules\contacts;
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
use framework\core\User;
use framework\database\Database;

class Relationship {
  
    /**
    * User one in the relationship
    *
    * @var User
    */
    public $userOne;

    /**
    * User two in the relationship
    *
    * @var User
    */
    public $userTwo;

    /**
    * Determines the status of the relationship
    *
    * 0 - Pending
    * 1 - Accepted
    * 2 - Declined
    * 3 - Blocked
    *
    * By default the status is set to 0
    */
    public $status = 0;

    /**
    * This is the user who made the most recent status field update
    */
    public $actionUserId;

    //##################### Accessor and Mutator Methods #########################

    /**
     * @return null|\framework\core\User
     */
    public function getUserOne() {
        return $this->userOne;
    }

    public function setUserOne(User $userOne) {
        $this->userOne = $userOne;
    }

    public function getUserTwo() {
        return $this->userTwo;
    }

    public function setUserTwo(User $userTwo) {
        $this->userTwo = $userTwo;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getActionUserId() {
        return $this->actionUserId;
    }

    public function setActionUserId($actionUserId) {
        $this->actionUserId = $actionUserId;
    }

    //##################### End of Accessor and Mutator Methods ##################

    /**
    * Set's the details of the relationship from the query result into the
    * current relationship object instance.
    *
    * @param array $row

    */
    public function arrToRelationship($row) {
        if (!empty($row)) {
            if (isset($row['userOne']) && isset($row['userTwo'])) {

                //echo $row['userOne'];

                $usersArr = [];

                $db = Database::connect();

                // Fetch the user details and create the user object set.
                $query = "

                    SELECT userID FROM users WHERE userID IN (:u1, :u2)

                    
                ";
                $query_params = array (
                    ':u1' => (int) $row['userOne'],
                    ':u2' => (int) $row['userTwo']
                );
                try {
                    $stmt = $db->prepare($query);
                    $stmt->execute($query_params);
                }
                catch (\PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }


                while ($record = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $usersArr[] = $record;
                }

                $userOne = new User();
                $userTwo = new User();

                // Check which user id is lesser.
                if ($row['userOne'] < $row['userTwo']) {
                    $userOne->arrToUser($usersArr[0]);
                    $userTwo->arrToUser($usersArr[1]);

                } else if($row['userOne'] > $row['userTwo']) {
                    $userOne->arrToUser($usersArr[1]);
                    $userTwo->arrToUser($usersArr[0]);
                }

                $this->setUserOne($userOne);
                $this->setUserTwo($userTwo);
            }

            isset($row['status']) ? $this->setStatus((int)$row['status']) : '';
            isset($row['actionUserID']) ?
            $this->setActionUserId((int)$row['actionUserID']) : '';
        }
    }
}