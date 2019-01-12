<?php

function get_weather($city)
{
    //город в ИП
    $im_p = json_decode(
        file_get_contents('https://htmlweb.ru/service/api.php?inflect='.$city.'&json&partofspeech=С'),
        true
    );
    $imp_city = $im_p[0];

    //код города
    $xml_cities = file_get_contents('https://pogoda.yandex.ru/static/cities.xml');
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml_cities, $vals, $index);
    xml_parser_free($p);

    foreach($vals as $k=>$val)
    {

        if(strtolower($val['value'])==strtolower($imp_city))
        {

            $city_id = $vals[$k]['attributes']['ID'];
            break;
        }
    }
    $answer='{
        "fulfillmentText": "'.$city_id.'",
        "source": "EchoService"
    }';
    echo($answer);
}