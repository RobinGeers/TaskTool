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
//header("Location: ../"); // rol is niet juist => hack attempt
}
$mysqli->close(); //connectie sluiten

?>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { //Voert deze functie uit ( puur javascript )  wanneer de pagina geladen is
        //Haal alle "div's" op in overzicht die een pagina voorstellen
        var MD =  document.getElementById("first").parentElement;
        var OT =  document.getElementById("second").parentElement;
        var S =  document.getElementById("third").parentElement;
        var I =  document.getElementById("fourth").parentElement;
        var W =  document.getElementById("fifth").parentElement;
       // var Afdruklijst =  document.getElementById("afdruklijst").parentElement;

        var MDS =  document.getElementById("firsts").parentElement;
        var OTS =  document.getElementById("seconds").parentElement;
        var SS =  document.getElementById("thirds").parentElement;
        var IS =  document.getElementById("fourths").parentElement;
        var WS =  document.getElementById("fifths").parentElement;
      //  var AfdruklijstS =  document.getElementById("afdruklijsts").parentElement;
    <?php
    switch($data){ //kijk welke rol  je bent en geeft aan de hand van dat ( via display ) weer welke knoppen ej recht tot hebt
        case 'Basic':
?>
        MD.style.display = "inline-block";
      //  Afdruklijst.style.display = "none";
        OT.style.display = "none";
        S.style.display = "none";
        I.style.display = "none";
        W.style.display = "none";
        MDS.style.display = "inline-block";
     //   AfdruklijstS.style.display = "none";
        OTS.style.display = "none";
        SS.style.display = "none";
        IS.style.display = "none";
        WS.style.display = "none";

<?php

            break;
        case 'Werkman':
?>
        MD.style.display = "inline-block";
        W.style.display = "inline-block";
       // Afdruklijst.style.display = "inline-block";
        OT.style.display = "none";
        S.style.display = "none";
        I.style.display = "none";

        MDS.style.display = "inline-block";
        WS.style.display = "inline-block";
       // AfdruklijstS.style.display = "inline-block";
        OTS.style.display = "none";
        SS.style.display = "none";
        IS.style.display = "none";


        <?php
                    break;
                case 'Onthaal':
        ?>
        MD.style.display = "inline-block";
        W.style.display = "none";
       // Afdruklijst.style.display = "none";
        OT.style.display = "inline-block";
        S.style.display = "inline-block";
        I.style.display = "none";

        MDS.style.display = "inline-block";
        WS.style.display = "none";
     //   AfdruklijstS.style.display = "none";
        OTS.style.display = "inline-block";
        SS.style.display = "inline-block";
        IS.style.display = "none";

        <?php
                            break;
                        case 'Admin':
             ?>
        MD.style.display = "inline-block";
        W.style.display = "none";
       // Afdruklijst.style.display = "none";
        OT.style.display = "inline-block";
        S.style.display = "inline-block";
        I.style.display = "inline-block";
        MDS.style.display = "inline-block";
        WS.style.display = "none";
       // AfdruklijstS.style.display = "none";
        OTS.style.display = "inline-block";
        SS.style.display = "inline-block";
        IS.style.display = "inline-block";

        <?php
                                    break;
                            }
                        ?>

    });
</script>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Overzicht</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
</head>
<body>
    <header>
        <a href="#"></a><img src="../images/howestlogo.png" alt="Howest Logo"/>
        <button><a onclick="afmelden(this)">Afmelden</a></button>
        <nav>
            <ul>
                <li><a id="first"  href="../Meld_Defect/index.php">Probleem melden</a></li>
                <li><a id="fifth"  href="../Afdrukpagina.php?Werkman=<?php $a =  $_SESSION["loggedin"];
                    $a = explode("@",$a);
                    $a = $a[0];
                    print $a;?>">Afdruklijst</a></li>
                <li><a id="second" href="../Overzicht_Takenlijst/">Overzicht takenlijst</a>
                    <ul class="gotop">
                        <li><a href="../Overzicht_Takenlijst_Grid/index.php">Tabel weergave</a></li>
                        <li><a href="../Overzicht_Takenlijst/index.php">Kaartjes weergave</a></li>
                    </ul>
                </li>
                <li><a id="third"  href="../Statistieken">Statistieken</a></li>
                <!--<li><a  href="../Instellingen">Instellingen</a></li>
                --> <li><a id="fourth" href="../Instellingen_Overzicht/index.php">Instellingen</a>
                    <ul class="gotop">
                        <li><a href="../Instellingen_Interne_Werknemers/index.php">Interne werknemers</a></li>
                        <li><a href="../Instellingen_Externe_Werknemers/index.php">Onderaannemers</a></li>
                        <li><a href="../Instellingen_Lokalen/index.php">Lokalen</a></li>
                    </ul>
            </ul>
        </nav>
        <p id="Ingelogd">U bent ingelogd als: <span><?php print $_SESSION["loggedin"] ?></span></p>
        <div class="clearfix"></div>
    </header>

    <main id="Overzicht">
        <h1>Overzicht</h1>
        <div><a id="firsts" href="../Meld_Defect/index.php"><i class="fa fa-bell"></i><p>Meld een defect</p></a></div>
        <div ><a id="seconds" href="../Overzicht_Takenlijst/index.php"><i class="fa fa-list-ul"></i><p>Overzicht takenlijst</p></a></div>
        <div><a id="thirds" href="../Statistieken/index.php"><i class="fa fa-line-chart"></i><p>Statistieken</p></a></div>
        <div><a id="fourths" href="../Instellingen_Overzicht/index.php"><i class="fa fa-cogs"></i><p>Instellingen</p></a></div>
        <div><a id="fifths" href="../Afdrukpagina.php?Werkman=<?php $a =  $_SESSION["loggedin"];
           $a = explode("@",$a);
            $a = $a[0];
            print $a;
            ?>"><i class="fa fa-print"></i><p>Afdruklijst</p></a></div>
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