<?php

function get_weather($city)
{
    $str_answ = 'Ты внатуре хочешь знать погоду в '.$city;
    $answer='{
        "fulfillmentText": "'.$str_answ.'",
        "source": "EchoService"
    }';
    echo(json_encode($answer));
}