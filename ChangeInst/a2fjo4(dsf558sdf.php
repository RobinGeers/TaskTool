<?php
$naam = "".$_GET["naam"];
$rol = "".$_GET["rol"];
    //CODE DIE ERVOOR ZORGT DAT NAAR DATABASE WORDT VERZET

echo $naam;
echo $rol;


$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
if ($mysqli->connect_error)
{
    echo "Geen connectie mogelijk met de database";
    echo  "<script type='text/javascript'>";
    echo "window.close();";
    echo "</script>";
}
echo "test";
//$result = $mysqli->query("SELECT userPrincipalName,ROL FROM EmailsLeerkrachten");
$stmt = $mysqli->prepare('UPDATE EmailsLeerkrachten SET ROL=? WHERE userPrincipalName=?');
$stmt->bind_param('ss',$rol,$naam);
//$stmt->bind_param('s', $naam);


$stmt->execute();
echo "hhh";
$result = $stmt->affected_rows;
echo $result;
/*while ($row = $result->fetch_assoc()) {
    // do something with $row
}*/



$mysqli->close();
echo "hallo";
echo  "<script>";
echo "window.close();";
echo "</script>";

   ?>