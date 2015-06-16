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
  //  header("Location: ../"); // rol is niet juist => hack attempt

    ?>
    <script>
        afmelden("e");
    </script>
<?php
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
}?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Overzicht</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/screen.css"/>
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/semantic.min.js"></script>
</head>
<body>
    <header>
        <button><a onclick="afmelden(this)">Afmelden</a></button>
        <nav>
            <ul>
                <li><a href="../Meld_Defect/index.php">Probleem melden</a></li>
                <li><a href="../Overzicht_Takenlijst/index.php">Overzicht takenlijst</a></li>
                <li><a href="../Statistieken/index.php">Statistieken</a></li>
                <li><a href="../Instellingen_Overzicht/index.php" class="instellingen">Instellingen</a>
                    <ul>
                        <li><a href="../Instellingen_Interne_Werknemers/index.php">Interne werknemers</a></li>
                        <li><a href="../Instellingen_Externe_Werknemers/index.php">Externe werknemers</a></li>
                        <li><a href="../Instellingen_Lokalen/index.php">Lokalen</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <a href="../Overzicht/index.php"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
        <p id="Ingelogd">U bent ingelogd als: <span><?php print $_SESSION["loggedin"] ?></span></p>
        <div class="clearfix"></div>
    </header>

    <main id="Instellingen_Overzicht">
        <h1>Instellingen</h1>
        <div><a id="first" href="../Instellingen_Interne_Werknemers/index.php"><i class="ui users icon"></i><p>Interne werknemers</p></a></div>
        <div><a id="second" href="../Instellingen_Externe_Werknemers/index.php"><i class="ui shipping icon"></i><p>Onderaannemers</p></a></div>
        <div><a id="third" href="../Instellingen_Lokalen/index.php"><i class="ui university icon"></i><p>Lokalen</p></a></div>
        <div class="clearfix"></div>
    </main>
    <div class="clearfix"></div>
    <footer>
        <p>Vragen? Mail naar <a href="mailto:helpdesk@howest.be">helpdesk@howest.be</a> of download <a href="">hier</a> de handleiding</p>
    </footer>
    <div class="clearfix"></div>
</body>
</html>
        <script>
            function afmelden(a){
                console.log("test");

                $.ajax({
                    url: '../logout.php',
                    dataType: 'html',
                    success: function(data){
                        //data returned from php
                        window.open("../","_self");
                    }
                });
            }
        </script>