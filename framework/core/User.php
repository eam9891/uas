<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/10/2017
 * Time: 11:40 PM
 */


namespace framework\core;


use framework\database\Database;

class User {

    private $userId;
    private $userName;
    private $email;
    private $password;
    private $role;
    private $salt;
    private $activityTime;

    //##################### Accessor and Mutator Methods #########################

    public function getUserId() {
        return $this->userId;
    }

    public function getUsername() {
        return $this->userName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function getActivityTime() {
        return $this->activityTime;
    }

    public function setUsername($userName) {
        $this->userName = $userName;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setActivityTime($active) {
        $this->activityTime = $active;
    }

    //##################### End of Accessor and Mutator Methods ##################

    /**
     * Returns the User Object provided the id of the user.
     *
     * @param $userID
     * @return User
     * @internal param PDO $db
     */
    public function getUser($userID) : User{


        // This query retrieves the user's information from the database using the supplied userID
        $query = "
            SELECT
                userID, username, email, role, activityTime
            FROM users
            WHERE
                userID = :x
        ";

        // The parameter values
        $query_params = array(
            ':x' => $userID
        );

        $stmt = Database::select($query, $query_params);




        $user = new User();
        $user->arrToUser($stmt);
        return $user;
    }

    /**
     * Set's the user details returned from the query into the current object.
     *
     * @param array $userRow
     */
    public function arrToUser($userRow) {
        if (!empty($userRow)) {
            isset($userRow['userID'])         ? $this->setUserId($userRow['userID'])                 : '';
            isset($userRow['username'])       ? $this->setUsername($userRow['username'])             : '';
            isset($userRow['email'])          ? $this->setEmail($userRow['email'])                   : '';
            isset($userRow['role'])           ? $this->setRole($userRow['role'])                     : '';
            isset($userRow['activityTime'])   ? $this->setActivityTime($userRow['activityTime'])     : '';
        }
    }
}