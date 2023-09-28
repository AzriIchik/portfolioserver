<?php

# database connection 
$db_conn = mysqli_connect("localhost", "root", "", "myportfolio");
global $db_conn;

if (!$db_conn) {
    die("Connection failed: " . mysqli_connect_error());
}

# Require Express PHP Framework...
require_once 'Express.php';

# Create an Expess PHP app...
global $app;
$app = new Express();

# Require Configuration file...
require_once "config.php";
require_once "./routes/Apis.php";
require_once "./http/middleware/generalmiddleware.php";

header('Access-Control-Allow-Origin: *');
$app->use('/*', $checkIfLogin);
