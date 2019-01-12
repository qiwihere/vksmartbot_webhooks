<?php

function get_weather($city)
{
    $im_p = json_decode(file_get_contents('https://htmlweb.ru/service/api.php?inflect='.$city.'&json'),true);
    $answer='{
        "fulfillmentText": "'.$im_p[0].'",
        "source": "EchoService"
    }';
    echo($answer);
}