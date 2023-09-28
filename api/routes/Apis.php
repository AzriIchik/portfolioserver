<?php

require_once "routes/api/employment.php";
require_once "routes/api/profile.php";
require_once "routes/api/project.php";
require_once "routes/api/skill.php";
require_once "routes/api/education.php";
require_once "routes/api/login.php";


// CHECK '/'
$app->get('/', function ($request, $response) {

    $response->render('home', array('appName' => "PortfolioS Server", 'title' => 'Portfolio Server'));

});

?>