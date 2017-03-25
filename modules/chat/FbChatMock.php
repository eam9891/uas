<?php

namespace modules\chat {

    use framework\core\User;
    use framework\database\Database;

    class FbChatMock {


        /**
         * Get the list of messages from the chat
         *
         * @param \framework\core\User $USER
         * @param                      $contactID
         *
         * @return array
         */
        public function getAllMessages(User $USER, $contactID) {
            $userID = $USER->getUserId();
            $messages = array();
            $query = "        
                SELECT * FROM chat WHERE 
                    (messageDeleted = FALSE )
                AND
                    (userID = $userID AND contactID = $contactID)
                UNION SELECT * FROM chat WHERE
                    (userID = $contactID AND contactID = $userID)
                ORDER BY 
                    messageDate
                
            ";
            // Todo: refactor with a WHERE clause, make deleted flag in db

            // Execute the query
            $resultObj = Database::query($query);
            // Fetch all the rows at once.
            while ($row = $resultObj->fetch()) {
                $messages[] = $row;
            }

            return $messages;
        }


        public function getChatUpdates($userID, $contactID, $lastMsgID) {

            //$query = "
            //    SELECT * FROM chat WHERE
            //        id > ? and chattime >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
            //";


            $messages = array();
            $query = "        
                SELECT * FROM chat WHERE 
                    id > :id
                AND
                    (userID = :userID AND contactID = :contactID)
                UNION SELECT * FROM chat WHERE
                    id > :id
                AND
                    (userID = :contactID AND contactID = :userID)
                ORDER BY 
                    messageDate
                
                
            ";
            $query_params = array(
                ":userID" => $userID,
                ":contactID" => $contactID,
                ":id" => $lastMsgID
            );
            $db = Database::connect();
            try {
                $stmt = $db->prepare($query);
                $stmt->execute($query_params);
            }
            catch (\PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            while ($row = $stmt->fetch()) {
                $messages[] = $row;
            }

            return $messages;
        }


        /**
         * Add a new message to the chat table
         *
         * @param \framework\core\User $USER
         * @param String               $message The Actual message
         * @param                      $contactID
         *
         * @return \modules\chat\ChatWriter|String
         */
        public function addMessage(User &$USER, $message, $contactID) {

            $cUserId = (int) $USER->getUserId();
            $author = (string) $USER->getUsername();
            // Escape the message with mysqli real escape
            $cMessage = $message;

            $query = " 
                INSERT INTO chat SET 
                    userID=:userID, message=:message, author=:author, actionUser=:actionUser, 
                        contactID = (
                            SELECT userID FROM users WHERE userID=:contactId
                        )
                 
            ";
            $query_params = array(
                ":userID" => $cUserId,
                ":message" => $cMessage,
                ":author" => $author,
                ":contactId" => $contactID,
                ":actionUser" => $cUserId
            );

            $db = Database::connect();
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);

            $addResult = $db->lastInsertId();

            $query = "SELECT * FROM chat WHERE id = $addResult";
            $addResult = Database::query($query);
            $message = new ChatWriter();
            $message = $message->writeMessages($USER, $contactID, $addResult);

            echo $message;
        }

        // Todo: How to not "delete" for both users???
        public function clearChat(User $USER, $contactID) {
            $userID = (int) $USER->getUserId();
            $query = " 
                UPDATE chat SET messageDeleted = true WHERE 
                    (userID = $userID AND contactID = $contactID)
                UNION SELECT * FROM chat WHERE
                    (userID = $contactID AND contactID = $userID)
                ORDER BY 
                    messageDate
            ";
            $query_params = array(
                ":userID" => $userID,
                ":contactId" => $contactID
            );

            //$result = Database::query($query);
            Database::insert($query, $query_params);
        }

        public function updateMessageRead($userID, $contactID) {
            $query = "
                UPDATE chat SET messageRead = TRUE WHERE 
                    userID = $contactID AND contactID = $userID
            ";
            Database::query($query);
        }
    }
}