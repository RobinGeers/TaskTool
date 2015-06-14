<?php
session_start(); // Verplicht als je wilt werken met sessie's

if($_SERVER["HTTPS"] != "on")
{ // zet de site om naar https indien het http is MEOT VOOR SECURE VAN DATA
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if(isset($_SESSION['loggedin'])){  // kijkt of er een sessie is
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
    header("Location: ../"); // rol is niet juist => hack attempt
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
        <?php
        switch($data){ //kijk welke rol  je bent en geeft aan de hand van dat ( via display ) weer welke knoppen ej recht tot hebt
            case 'Basic':

  header("Location: ../Overzicht");

                    break;
                case 'Werkman':
       header("Location: ../Overzicht");
                           break;
                case 'Onthaal':
        ?>
        MD.style.display = "inline-block";
        OT.style.display = "inline-block";
        S.style.display = "inline-block";
        I.style.display = "none";

        <?php
                            break;
                        case 'Admin':
             ?>
        MD.style.display = "inline-block";
        OT.style.display = "inline-block";
        S.style.display = "inline-block";
        I.style.display = "inline-block";

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
    <meta charset="UTF-8">
    <title>TaskTool Howest | Instellingen</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">

</head>
<body>
<header>
    <a href="../Overzicht/index.php"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a onclick="afmelden(this)" ">Afmelden</a></button>
    <nav>
        <ul>
            <li><a id="first" href="../Meld_Defect/index.php">Probleem melden</a></li>
            <li><a id="second" href="#">Overzicht takenlijst</a></li>
            <li><a id="third" href="../Statistieken/index.php">Statistieken</a></li>
            <li><a id="fourth" href="../Instellingen_Overzicht/index.php">Instellingen</a>
                <ul>
                    <li><a href="../Instellingen_Interne_Werknemers/index.php">Interne werknemers</a></li>
                    <li><a href="../Instellingen_Externe_Werknemers/index.php">Externe werknemers</a></li>
                    <li><a href="../Instellingen_Lokalen/index.php">Lokalen</a></li>
                </ul>
        </ul>
    </nav>
    <p id="Ingelogd">U bent ingelogd als: <span><?php print $_SESSION["loggedin"] ?></span></p>
    <div class="clearfix"></div>

</header>
<main id="Overzicht_Takenlijst">
    <h1>Overzicht taken</h1>
    <section class="geenmargintop" id="Tabel">

        <table id="OT" class="opmaaktabel">
            <thead>
            <tr>
                <th>Onderwerp</th>
                <th>Omschrijving</th>
                <th>Prioriteit</th>
                <th>Klas</th>
                <th>Bijlagen</th>
                <th>Bewerk</th>
            </tr>
            </thead>
            <tbody id="OverzichtTaken" class="display" cellspacing="0" width="70%">

            </tbody>
        </table>

    </section>
   </main>
<div class="clearfix"></div>
<footer>
    <p>Vragen? Mail naar <a href="mailto:helpdesk@howest.be">helpdesk@howest.be</a> of download <a href="">hier</a> de handleiding</p>
</footer>
<div class="clearfix"></div>
</body>
</html>
<script>
window.onbeforeunload = confirmExit;
function confirmExit() {
    if (formmodified == 1) {
        return "Je hebt je bewerkte informatie nog niet opgeslaan. Bent u zeker dat u de pagina wilt verlaten?";
    }
}

oTable = null;
ooTable = null;
oooTable = null;

takenlist = "5506dbf5b32e668bde0de1b4";
var APP_KEY = '23128bd41978917ab127f2d9ed741385';
var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
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
var mijnteller = 0;


    //Haal alle kaartjes op van een bepaalde lijst
    Trello.get("/lists/"+takenlist+"?fields=name&cards=open&card_fields=name&token="+application_token, function(cards) {

        //console.log(cards["cards"]);
        var CardId = [];
//overloop alle kaarten die we terug krijgen
console.log(cards["cards"].length);
       var mijnstopsignaal = cards["cards"].length;
        $.each(cards["cards"], function(ix, card) {
            //console.log(card.id);

     var full = [];
     var tempydesc = [];
     var tempyatt = [];


            Trello.get("/cards/"+card.id+"?fields=name,desc&attachments=true&token="+application_token,function(carddesc) {
              //  console.log(carddesc);
                var tempy = [];
                $.each(carddesc, function(ix, card) {
                    //console.log(ix);
                  //  console.log(card);
                    switch(ix){
                        case "id":
                            tempy.push(card);
                            break;
                        case "name":
                            tempy.push(card);
                            break;
                        case "desc":
                            tempy.push(card);
                            break;
                        case "attachments":
                            tempy.push(card);

                            break;
                        default:
                            console.log(ix);
                            break;
                    }

                });
maakitem(tempy[0],tempy[1],tempy[2],tempy[3]);
                mijnteller++;
                if(mijnteller==mijnstopsignaal){
                    console.log("gedaan");
                    $('#OT')
                        .removeClass( 'display' )
                        .addClass('table table-striped table-bordered');

                    ooTable = $('#OT').DataTable({
                        "dom": '<"top">rt<"bottom"lp><"clear">'
                    });
                }
            });
        });
        console.log("ja");
    });

function maakitem(id, name, desc,attach){
    var x = desc.split("/n@");
    var de = x[0];
    var prio = x[1];
    var eml = x[2];
    var klas = x[3];

    var tr =  document.createElement("tr");
    tr.id = id;
    var td1 = document.createElement("td");
    td1.appendChild(document.createTextNode(name));
    var td2 = document.createElement("td");
    td2.appendChild(document.createTextNode(de));
    var td3 = document.createElement("td");
    td3.appendChild(document.createTextNode(prio));
    var td99 = document.createElement("td");
    td99.appendChild(document.createTextNode(klas));


    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td99);

    var doe = 0;
    var td100 = document.createElement("td");
    $.each(attach,function(ix,at){
console.log(at);
        doe = 1;

        var img = document.createElement("img");
        img.src =at["url"];
     img.className = "picturetable";
        td100.appendChild(img);

    });
    if(doe==0){


        td100.appendChild(document.createTextNode("geen foto"));

    }
    tr.appendChild(td100);
//}
    var td4 = document.createElement("td");
    var iWrite = document.createElement("i");

    iWrite.className="write icon";
    iWrite.addEventListener("click",function() {
        dosomething(tr);
        formmodified = 1;
    });

    td4.appendChild(iWrite);
    tr.appendChild(td4);

    if(ooTable!=null) {
        ooTable.row.add(tr).draw();
    }else{
        var table = document.getElementById("OverzichtTaken");
        table.appendChild(tr);
    }
}

     </script>