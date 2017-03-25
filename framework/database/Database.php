<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/9/2017
 * Time: 2:01 PM
 */

namespace framework\database {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    use PDOException;

    class Database extends Connect {

        // If you need to open a connection directly
        public static function connect() {
            return Connect::openConnection();
        }

        // If you need to close a connection directly
        public static function disconnect() {
            Connect::$connection = null;
            session_destroy();
        }

        public static function select(string $query, array $query_params) {
            try {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt->fetch();

        }

        /**
         * SELECT * FROM $table WHERE $where
         * @param string $table
         * @param string $where
         * @param array $query_params
         * @return mixed
         */
        public static function selectAll(string $table, string $where, array $query_params) {
            $query = "SELECT * FROM $table WHERE $where";
            try {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt;
        }


        /**
         * Returns 1 column from a row with a where clause
         * @param string $table
         * @param string $where
         * @param array $query_params
         * @return mixed
         */
        public static function selectOne(string $table, string $where, array $query_params) {
            $query = "SELECT 1 FROM $table WHERE $where";
            try {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt->fetch();
        }


        public static function query($query) {
            try {
                $stmt = Connect::openConnection()->query($query);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt;
        }

        /**
         * Insert data
         *
         * @param       $query
         * @param array $query_params
         *
         * @return \PDOStatement
         */
        public static function insert($query, array $query_params)
        {
            try
            {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt;
        }


        /**
         * Update and sets values
         * @param string $table
         * @param string $set
         * @param array $query_params
         */
        public static function update(string $table, string $set, array $query_params)
        {
            $query = "UPDATE $table SET $set";
            try
            {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
        }


        /**
         * Deletes from ... where ...
         *
         * @param string $table
         * @param string $where
         * @param array  $query_params
         *
         * @internal param string $delete
         */
        public static function deleteWhere(string $table, string $where, array $query_params)
        {
            $query = "DELETE FROM $table WHERE $where";
            try
            {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
        }

        public static function search($query, array $data = null)
        {
            try
            {
                $stmt = Connect::openConnection()->prepare($query);
                $stmt->execute($data);
            }
            catch (PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt->fetchAll();
        }


    }
}