<?php

function get_region_id($city)
{

    $imp_city = strtolower(substr($city, 0, -2));
    echo($imp_city);
    $xml_cities = file_get_contents('https://pogoda.yandex.ru/static/cities.xml');
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml_cities, $vals, $index);
    xml_parser_free($p);

    foreach($vals as $k=>$val)
    {
        $cur_city = strtolower($val['value']);

        if(stristr($cur_city,$imp_city) or $imp_city==$cur_city)
        {
            if($vals[$k]['attributes']['ID'])
            {
                $region = $vals[$k]['attributes']['REGION'];
            }

        }
    }
    return $region;
}

function get_weather($region)
{
    $path = 'https://export.yandex.ru/bar/reginfo.xml?region='.$region;
    $xmlfile = file_get_contents($path);
    $ob= simplexml_load_string($xmlfile);
    $json  = json_encode($ob);
    $configData = json_decode($json, true);

    $day_frames = ['now','morning','daytime','evening','night'];
    $weather = $configData['weather']['day']['day_part'];

    foreach($day_frames as $k => $frame)
    {
        $weather_now = $weather[$k];
        if($frame=='now') {
            $arr_weather[$frame] = [
                'type' => $weather_now['weather_type'],
                'wind_speed' => $weather_now['wind_speed'],
                'wind_direction' => $weather_now['wind_direction'],
                'temperature' => $weather_now['temperature']
            ];
        }else {
            if(array_key_exists('temperature',$weather_now)) {
                $arr_weather[$frame] = [
                    'temperature'=>$weather_now['temperature']
                ];
            }else {
                $arr_weather[$frame] = [
                    'temperature'=>'от '.$weather_now["temperature_from"].' до '.$weather_now["temperature_to"]
                ];
            }
        }
    }

    $template = '
        &#11036;Сейчас на улице '.$arr_weather['now']['type'].', скорость ветра достигает '.$arr_weather['now']['wind_speed'].' м/c, направление ветра: '.$arr_weather['now']['wind_direction'].', температура воздуха: '.$arr_weather['now']['temperature'].'\n
        &#127763;Утро: '.$arr_weather['morning']['temperature'].',
        &#127765;День: '.$arr_weather['daytime']['temperature'].',
        &#127767;Вечер: '.$arr_weather['evening']['temperature'].',
        &#127761;Утро: '.$arr_weather['night']['temperature'].',
        
        ID региона: '.$region.'
    ';

    $answer='{
        "fulfillmentText": "'.$template.'",
        "source": "EchoService"
    }';
    echo($answer);
}