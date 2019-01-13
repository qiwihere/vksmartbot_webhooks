<?php

class Wikipedia
{
   public static function Search($query)
   {
       $params = [
           'action=query',
           'list=search',
           'srwhat=text',
           'format=xml',
           'srsearch='.urlencode($query)
       ];
       $api_url = 'http://ru.wikipedia.org/w/api.php?';

       $data = file_get_contents($api_url.(implode('&',$params)));
       $ob = simplexml_load_string($data);
       $json = json_encode($ob);
       $configData = json_decode($json, true);
       $arr_result = $configData['query']['search']['p'];

       $answ='Результаты:
       ';
       foreach($arr_result as $result)
       {
            $part = $result['@attributes'];
            $answ.='
            '.$part['title'].'
            '.strip_tags($part['snippet']).'
            Подробнее: https://ru.wikipedia.org/wiki/'.$part['title'].'
            ';
       }
       $answer = '{
            "fulfillmentText": "' . $answ . '",
            "source": "EchoService"
        }';
       echo($answer);
   }
}