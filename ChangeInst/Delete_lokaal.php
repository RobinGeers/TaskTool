<?php
$disabled = "".$_GET["DISABLED"];
$idnummering = "".$_GET["id"];
//CODE DIE ERVOOR ZORGT DAT NAAR DATABASE WORDT VERZET

echo $disabled;
echo $idnummering;


$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
if ($mysqli->connect_error) {
    echo "Geen connectie mogelijk met de database";
    return "<p>failed</p>";
}
echo "test";
//$result = $mysqli->query("SELECT userPrincipalName,ROL FROM EmailsLeerkrachten");
$stmt = $mysqli->prepare('UPDATE klassen SET DISABLED=1 WHERE IDNUMMERING=?');
$stmt->bind_param('s',$idnummering);
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