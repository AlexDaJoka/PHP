<?php

$login = $_POST["login"];
$pass = $_POST['pass'];
$email = $_POST['email'];
$tel = $_POST['tel'];


$login = htmlspetialchars($login);
$pass = htmlspetialchars($pass);
$email = htmlspetialchars($email);
$tel = htmlspetialchars($tel);

$login = urldecode($login);
$pass = urldecode($pass);
$email = urldecode($email);
$tel = urldecode($tel);

$login = trim($login);
$pass = trim($pass);
$email = trim($email);
$tel = trim($tel);

if (mail("alexivanovvg@yandex.ru",
"New mail from web site",
"login: ".$login."\n".
"Password: ".$pass."\n".
"Email: ".$email."\n".
"Tel: ".$tel,
"From: no-reply@mydomain.ru \r\n")

){
echo ('УСПЕХ');
}
else{
echo('НЕ УСПЕХ');
}
?>