<?php

class Giphy
{
    public static function get_gif($keywords)
    {
        $api_key = 'dc6zaTOxFJmzC';
        $query = file_get_contents('http://api.giphy.com/v1/gifs/search?q='.urlencode($keywords).'&api_key='.$api_key.'&limit=100');

        $result = json_decode($query,true)['data'];
        if(count($result)>1) {
            $img_id = random_int(0, count($result) - 1);
            $img = $result[$img_id]['images']['original']['url'];
        }else{
            $img = 'Попробуй поискать по другим ключевым словам';
        }
        $answer = '{
        "fulfillmentText": "' . $img . '",
        "source": "EchoService"
        }';
        echo($answer);
    }
}