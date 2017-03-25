<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/2/2017
 * Time: 8:53 PM
 */

namespace framework\libs;
use framework\database\Database;


class Authenticate {
    private $userRole;
    private $dbRole;
    private $returnAuthStatus = false;

    public function __construct(string $userRole) {
        $this->userRole = $userRole;
        $this->checkRole($this->userRole);

    }



    /** Returns the role of a user provided their id
     * @param string $userID
     *
     * @return string
     */
    private function getRole(string $userID) : string {


        $query = "SELECT role FROM users WHERE userID = :x";
        $query_params = array(
            ':x' => $userID
        );

        $stmt = Database::select($query, $query_params);
        $role = $stmt->fetchColumn();

        return $role;
    }

    private function checkRole(string $role) : bool {

        if (isset($_SESSION['id'])) {
            $this->dbRole = $this->getRole($_SESSION['id']);
        } else {
            return $this->returnAuthStatus;
        }


        switch ($role) {

            case "admin":
                if ($this->dbRole == "admin") {
                    $this->returnAuthStatus = true;
                    break;
                } else {
                    header("Location: http://192.168.0.132/mvc/");
                    die("Redirecting to: http://192.168.0.132/mvc/");
                    break;
                }

            case "contributor":
                if ($this->dbRole == "contributor" || $this->dbRole == "admin") {
                    $this->returnAuthStatus = true;
                    break;
                } else {
                    header("Location: http://192.168.0.132/mvc/");
                    die("Redirecting to: http://192.168.0.132/mvc/");
                    break;

                }

            case "user":
                if ($this->dbRole == "user" || $this->dbRole == "contributor" || $this->dbRole == "admin") {
                    $this->returnAuthStatus = true;
                    break;
                } else {
                    session_destroy();
                    header("Location: http://192.168.0.132/mvc/");
                    die("Redirecting to: http://192.168.0.132/mvc/");
                    break;

                }

            default:
                header("Location: http://192.168.0.132/mvc/");
                die("Redirecting to: http://192.168.0.132/mvc/");
                break;
        }
        return $this->returnAuthStatus;
    }


}