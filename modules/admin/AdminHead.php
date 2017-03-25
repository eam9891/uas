<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/4/2017
 * Time: 11:28 PM
 */

namespace modules\admin {


    use framework\core\Authorize;
    use framework\core\IUserInterface;
    use framework\core\User;

    class AdminHead extends IUserInterface {
        public function __construct(User &$USER) {
            parent::$auth = Authorize::AdminOnly($USER);

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
    <script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
    
    <script src="http://192.168.0.132/mvc/public/js/home.js"></script>
    <script src="http://192.168.0.132/mvc/public/js/contacts.js"></script>
    <script src="http://192.168.0.132/mvc/public/js/chat.js"></script>
    <script src="http://192.168.0.132/mvc/public/js/blogTools.js"></script>
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
        .menuButton {
            width: 100%;
            text-align: left;
            background-color: transparent;
            height: 40px;
            border: none;
        }
        .menuButton:active {
            border: none;
            background-color: transparent;
        }
        .menuButton:hover {
            background-color: transparent;
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
    </style>
    

</head>
<body>
HTML;
            parent::__construct(self::$htmlString);
        }
    }
}