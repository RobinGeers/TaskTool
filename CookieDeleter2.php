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
$data = unserialize($_COOKIE['cookie2']);
if($data == null){
    $data = array();
}
$newdata = array();
//print_r($data); echo"<br>";
$waarde =  $_GET["val"];
foreach ($data as $d) {
    $a =  explode("/",$d);

    if($a[0]==$waarde){}else{
        array_push($newdata,$d);
    }

}
//print $waarde;
//array_push($data,$waarde);
//print_r($data);
echo "<br>";
setcookie('cookie2', serialize($newdata), time()+36000000,"/");
//print_r($data);
echo "<p>gelukt</p>";
return;