<?php
session_start(); // Verplicht als je wilt werken met sessie's
if($_SERVER["HTTPS"] != "on")
{ // zet de site om naar https indien het http is MEOT VOOR SECURE VAN DATA
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if(isset($_SESSION['loggedin'])){ // kijkt of er een sessie is
    $ber = $_SESSION['loggedin']; // stop de sessie in een variabele
}else {
    header("Location: ../"); // Sessie bestaat niet je ben tniet ingelogd
}
$rol = $_COOKIE["rol"]; // haal de gehashde rol uit de cookie
$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj'); //connectie tot de database
if ($mysqli->connect_error)
{
    echo "Geen connectie mogelijk met de database";
    return; // error message dat je geen toegang / verbinding hebt met de database ( 500 internal server error )
}
$data = array();
$result = $mysqli->prepare("SELECT ROL FROM EmailsLeerkrachten where userPrincipalName =?"); // prepare je statement waar ? iedere keer een parameter zal zijn die beschermd is tegen SQL injectie
$result->bind_param('s', $ber); //voeg de param $ber toe aan de query
$result->execute(); // voort het prepared sql statement uit
$result->bind_result($data); //steek het resultaat in een parameter
$d = array();
while($result->fetch()){
    array_push($d,$data); //steek de data in een array moest er meer dan 1 zijn ( kan in dit geval niet )
};
$ha =  md5("exteralayersecuresalt".$data); //hash de data uit de db met een secure woord ( voor extra beveiliging )
if($ha==$rol){//roll is gelijk aan wat er in de cookie zit
}else{

    ?>
    <script>
        afmelden("e");
    </script>
    <?php
  //  header("Location: ../"); // rol is niet juist => hack attempt
}
$mysqli->close(); //connectie sluiten


switch($data){ //kijk welke rol  je bent en geeft aan de hand van dat ( via display ) weer welke knoppen ej recht tot hebt
    case 'Basic':
        header("Location: ../");

        break;
    case 'Werkman':
        header("Location: ../");
        break;
    case 'Onthaal':
        header("Location: ../");
        break;
    case 'Admin':

        break;
}
//var url = mylink+"?naam="+myar[0]+"&bedrijf="+myar[1]+"&adres"+myar[2]+"&tel"+myar[3]+"&email"+myar[4];
$n = "".$_GET["n"];
$o = "".$_GET["o"];
$i = "".$_GET["i"];


//CODE DIE ERVOOR ZORGT DAT NAAR DATABASE WORDT VERZET


$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
if ($mysqli->connect_error)
{
    echo "Geen connectie mogelijk met de database";
    return "<p>failed</p>";
}
//echo "test";
//$result = $mysqli->query("SELECT userPrincipalName,ROL FROM EmailsLeerkrachten");
//INSERT INTO table_name (column1,column2,column3,...)
//VALUES (value1,value2,value3,...);("SELECT IDNUMMERING, NAME, DESCRIPTION, USER_TEXT_1, DISABLED FROM klassen");
//print $n;
$stmt = $mysqli->prepare('INSERT INTO klassen(NAME, DESCRIPTION, USER_TEXT_1, DISABLED) VALUES(?,?,?,0)');
//print $o;
$stmt->bind_param('sss',$n,$o,$i);
//print $i;
//$stmt->bind_param('s', $naam);


$stmt->execute();
//echo "hhh";
$result = $stmt->affected_rows;
$data = $stmt->insert_id;
print $data;
//print "h";
//echo $result;$mysqli->insert_id
/*while ($row = $result->fetch_assoc()) {
    // do something with $row
}*/



$mysqli->close();
echo "<p>".$data."</p>";

return;
?>