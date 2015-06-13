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
$data = array();
$data = unserialize($_COOKIE['cookie']);
if($data == null){
    $data = array();
}
//print_r($data); echo"<br>";
$waarde =  $_GET["val"];
//print $waarde;
array_push($data,$waarde);
//print_r($data);
echo "<br>";
setcookie('cookie', serialize($data), time()+3600,"/");
//print_r($data);
echo "<p>gelukt</p>";
return;