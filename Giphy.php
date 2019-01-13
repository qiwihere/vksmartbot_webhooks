<?php

class Giphy
{
    public static function get_gif($keywords)
    {
        $api_key = 'dc6zaTOxFJmzC';
        $translater_key = 'trnsl.1.1.20190107T005840Z.04ecacdc7bfd25ac.9026ad4fc123511c3b40305fe406323a9a6c9e0e';
        $translater_direction = 'ru-en';
        $translated_keywords = json_decode(file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key='.$translater_key.'&text='.urlencode($keywords).'&lang='.$translater_direction),true)['text'][0];
        $query = file_get_contents('http://api.giphy.com/v1/gifs/search?q='.urlencode($translated_keywords).'&api_key='.$api_key.'&limit=100');

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