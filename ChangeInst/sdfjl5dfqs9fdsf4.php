<?php
//var url = mylink+"?naam="+myar[0]+"&bedrijf="+myar[1]+"&adres"+myar[2]+"&tel"+myar[3]+"&email"+myar[4];
$naam = "".$_GET["naam"];
$bedrijf = "".$_GET["bedrijf"];
$adres = "".$_GET["adres"];
$tel = "".$_GET["tel"];
$email = "".$_GET["email"];
$id = "".$_GET["id"];
//CODE DIE ERVOOR ZORGT DAT NAAR DATABASE WORDT VERZET


$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
if ($mysqli->connect_error)
{
    echo "Geen connectie mogelijk met de database";
    return "<p>failed</p>";
}
echo "test";
//$result = $mysqli->query("SELECT userPrincipalName,ROL FROM EmailsLeerkrachten");
$stmt = $mysqli->prepare('UPDATE external SET Naam=?, NaamBedrijf=?, Adres=?, Telefoon=?, Emailadres=? WHERE id=?');
$stmt->bind_param('ssssss',$naam,$bedrijf,$adres,$tel,$email,$id);
//$stmt->bind_param('s', $naam);


$stmt->execute();
echo "hhh";
$result = $stmt->affected_rows;
echo $result;
/*while ($row = $result->fetch_assoc()) {
    // do something with $row
}*/



$mysqli->close();
return "<p>gelukt</p>";

?>