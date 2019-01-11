<?php
$login = 'test';
$pass = 'kek';

//auth
if($login != $_SERVER['PHP_AUTH_USER'] or $pass != $_SERVER['PHP_AUTH_PW']) die();


function processMessage($update) {
    if($update["result"]["action"] == "weather"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Hello from webhook",
            "displayText" => "Hello from webhook",
            "contextOut" => array()
        ));
    }
}

function sendMessage($parameters) {
    echo json_encode($parameters);
}

$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
if (isset($update["result"]["action"])) {
    processMessage($update);
}