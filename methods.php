<?php

function get_weather($city)
{
    $im_p = json_decode(file_get_contents('https://htmlweb.ru/service/api.php?inflect='.$city.'&json&info'),true);
    foreach($im_p as $word_p)
    {
        if ($word_p['partofspeech'] == "C") {
            $word = $word_p['word'];
            break;
        }
    }
    $answer='{
        "fulfillmentText": "'.$word.'",
        "source": "EchoService"
    }';
    echo($answer);
}