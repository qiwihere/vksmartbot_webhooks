<?php
$login = 'test';
$pass = 'kek';

//auth
if($login != $_SERVER['PHP_AUTH_USER'] or $pass != $_SERVER['PHP_AUTH_PW']) die();

ob_start();
var_dump($_REQUEST);
$data = ob_get_clean();

file_put_contents('log.txt',$data,FILE_APPEND);

echo(file_get_contents('log.txt'));