<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/3/2017
 * Time: 2:08 PM
 */

namespace modules\home {

    use framework\core\Authorize;
    use framework\core\IUserInterface;
    use framework\core\User;


    class HomeHead extends IUserInterface {

        public function __construct(User &$USER) {
            parent::$auth = Authorize::User($USER);
            self::$htmlString = <<<HTML

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Underground Art School</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" type="image/x-icon" href="http://eserv.us/public/favicon.ico">
    
    <link rel="stylesheet" href="http://www.eserv.us/modules/contacts/css/contacts.css">
    <link rel="stylesheet" href="http://www.eserv.us/modules/chat/css/chatBoxes.css">
    <link rel="stylesheet" href="http://www.eserv.us/modules/home/css/home.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="http://www.eserv.us/modules/home/js/home.js"></script>
    <script src="http://www.eserv.us/modules/contacts/js/contacts.js"></script>
    <script src="http://www.eserv.us/modules/chat/js/chat.js"></script>
    
</head>
<body>
HTML;
            parent::__construct(self::$htmlString);
        }

    }
}