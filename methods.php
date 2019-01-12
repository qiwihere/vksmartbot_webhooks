<?php

function get_weather($city)
{
    //город без падежа
    $imp_city = substr($city, 0, -1);
    //код города
    $xml_cities = file_get_contents('https://pogoda.yandex.ru/static/cities.xml');
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml_cities, $vals, $index);
    xml_parser_free($p);

    foreach($vals as $k=>$val)
    {

        if(stristr(strtolower($val['value']),strtolower($imp_city)))
        {

            $city_id = $vals[$k]['attributes']['ID'];

        }
    }
    $answer='{
        "fulfillmentText": "'.$city_id.'",
        "source": "EchoService"
    }';
    echo($answer);
}