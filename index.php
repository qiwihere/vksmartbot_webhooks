<?php
$login = 'test';
$pass = 'kek';

//auth
if($login != $_SERVER['PHP_AUTH_USER'] or $pass != $_SERVER['PHP_AUTH_PW']) die();


$webhook_data = json_decode(file_get_contents('php://input'),true);
$action = $webhook_data['queryResult']['action'];

$answer=[
    'method'=>$action
];
echo(json_encode($answer));