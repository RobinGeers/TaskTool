<?php
if(isset($_SESSION['loggedin'])){ // kijkt of er een sessie is

}else {
    header("Location: ./"); // Sessie bestaat niet je ben tniet ingelogd
}

$b = "Uw aanvraag met als onderwerp".$_GET["n"]." is zojuist behandeld geweest";
$b=$b."/br";
$b=$b.$_GET["e"];
$thiss = getcwd();
$a = $thiss . '/PHPMailer-master/class.phpmailer.php';
$target = "";
$isfoto = 0;
$test = "";
require_once($a);
//STUUR MAIL HIER EN REDIRECT NAAR LOGIN WAAR ZE BEVESTIGING GEVEN DAT HET GEBERUD IS
//Houd de data bij in een grote string zodat we deze uit de upload maps kunnen verwijderen wanneer dit klaar is
$targetstrings = "";
//ZEND DE EMAIL
$email = new PHPMailer();
$email->From = "Tasktool@howest.be";
$email->FromName = "Tasktool@howest.be";
$email->Subject = "Uw aanvraag was voltooid";

$email->Body =$b;

$email->AddAddress('wouterdumon@hotmail.com'); //new email

$email->Send();


echo "<p>gelukt</p>";
return;
?>