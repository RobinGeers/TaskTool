<?php
session_start();
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if(isset($_SESSION['loggedin'])){ // kijkt of er een sessie is

}else {
    header("Location: ./"); // Sessie bestaat niet je ben tniet ingelogd
}

//print_r($data); echo"<br>";
$waarde =  $_GET["val"];

setcookie('cookie2', serialize($waarde), time()+36000000,"/");
//print_r($data);
echo "<p>gelukt</p>";
return;