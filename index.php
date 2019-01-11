<?php
$login = 'test';
$pass = 'kek';

//auth
if($login != $_SERVER['PHP_AUTH_USER'] or $pass != $_SERVER['PHP_AUTH_PW']) die();


$webhook_data = json_decode(file_get_contents('php://input'),true);
$action = $webhook_data['queryResult']['action'];

$answer=[[
    'speech'=>$action,
    'displayText'=>$action
]];
echo('
 {
"speech": "this text is spoken out loud if the platform supports voice interactions",
"displayText": "this text is displayed visually",
"messages": {
  "type": 1,
  "title": "card title",
  "subtitle": "card text",
  "imageUrl": "https://assistant.google.com/static/images/molecule/Molecule-Formation-stop.png"
},
"data": {
  "google": {
    "expectUserResponse": true,
    "richResponse": {
      "items": [
        {
          "simpleResponse": {
            "textToSpeech": "this is a simple response"
          }
        }
      ]
    }
  },
  "facebook": {
    "text": "Hello, Facebook!"
  },
  "slack": {
    "text": "This is a text response for Slack."
  }
},
"contextOut": [
  {
    "name": "context name",
    "lifespan": 5,
    "parameters": {
      "param": "param value"
    }
  }
],
"source": "example.com",
"followupEvent": {
  "name": "event name",
  "parameters": {
    "param": "param value"
  }
}   
');