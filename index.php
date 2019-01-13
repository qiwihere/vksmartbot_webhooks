<?php
include('YandexWeather.php');
include('Wikipedia.php');
include('Giphy.php');
$login = 'test';
$pass = 'kek';

//auth
if($login != $_SERVER['PHP_AUTH_USER'] or $pass != $_SERVER['PHP_AUTH_PW']) die();


$webhook_data = json_decode(file_get_contents('php://input'),true);
$action = $webhook_data['queryResult']['action'];



if($action=='weather')
{
    $city = $webhook_data['queryResult']['parameters']['city'];
    YandexWeather::get_weather(YandexWeather::get_region_id($city));
}

if($action=='wiki')
{
    $query = $webhook_data['queryResult']['parameters']['query'];
    Wikipedia::Search($query);
}

if($action=='gif')
{
    $keywords = $webhook_data['queryResult']['parameters']['keywords'];
    Giphy::get_gif($keywords);
}