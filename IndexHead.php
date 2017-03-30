<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/12/2017
 * Time: 12:46 AM
 */


class IndexHead {
    public function __construct() {
        $head =  <<<HTML

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Underground Art School</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/public/favicon.ico">
    
   
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="http://www.eserv.us/modules/register/js/register.js"></script>
    <script src="http://www.eserv.us/public/js/loaders.js"></script>

    
</head>    
        
HTML;
        $testing = <<< HTML

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Underground Art School</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/public/favicon.ico">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="http://www.eserv.us/public/css/main.css">
    
    <script src="http://www.eserv.us/public/js/main.js"></script>
    <script src="http://www.eserv.us/public/js/loaders.js"></script>
    <script src="http://www.eserv.us/modules/register/js/register.js"></script>
    
    
</head>  

HTML;


        echo $head;
    }
}