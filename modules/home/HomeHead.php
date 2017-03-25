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
    
    <link rel="shortcut icon" type="image/x-icon" href="http://192.168.0.132/mvc/public/favicon.ico">
    
    <link rel="stylesheet" href="http://192.168.0.132/mvc/public/css/contacts.css">
    <link rel="stylesheet" href="http://192.168.0.132/mvc/public/css/chatBoxes.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="http://192.168.0.132/mvc/public/js/home.js"></script>
    <script src="http://192.168.0.132/mvc/public/js/contacts.js"></script>
    <script src="http://192.168.0.132/mvc/public/js/chat.js"></script>
    <style>
        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }
        .profileButton {
            border: none;
            cursor: pointer;
        }
        .dropdownImage {
            margin-top: 10px;

        }
        .navbar-login
        {
            width: 305px;
            padding: 10px;
            padding-bottom: 0px;
        }


        .navbar-login-session
        {
            padding: 10px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .icon-size
        {
            font-size: 87px;
        }

        @media screen and (max-width: 1000px) {
            .searchForm {
                width: 200px;
            }
        }
        .navbar-nav {
            margin: 0;
        }
        .profile-button {
            margin: 0;
            padding: 0;
            background-color: black;
            color: green;
        }
        .menuButton {
            
        }
    </style>
</head>
<body>
HTML;
            parent::__construct(self::$htmlString);
        }

    }
}