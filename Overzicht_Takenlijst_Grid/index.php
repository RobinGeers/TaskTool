<?php
session_start(); // Verplicht als je wilt werken met sessie's

if ($_SERVER["HTTPS"] != "on") { // zet de site om naar https indien het http is MEOT VOOR SECURE VAN DATA
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if (isset($_SESSION['loggedin'])) {  // kijkt of er een sessie is
    $ber = $_SESSION['loggedin']; // stop de sessie in een variabele
} else {
    header("Location: ../"); // Sessie bestaat niet je ben tniet ingelogd
}
$rol = $_COOKIE["rol"]; // haal de gehashde rol uit de cookie
$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj'); //connectie tot de database
if ($mysqli->connect_error) {
    echo "Geen connectie mogelijk met de database";
    return; // error message dat je geen toegang / verbinding hebt met de database ( 500 internal server error )
}
$data = array();
$result = $mysqli->prepare("SELECT ROL FROM EmailsLeerkrachten where userPrincipalName =?"); // prepare je statement waar ? iedere keer een parameter zal zijn die beschermd is tegen SQL injectie
$result->bind_param('s', $ber); //voeg de param $ber toe aan de query
$result->execute(); // voort het prepared sql statement uit
$result->bind_result($data); //steek het resultaat in een parameter
$d = array();
while ($result->fetch()) {
    array_push($d, $data); //steek de data in een array moest er meer dan 1 zijn ( kan in dit geval niet )
}
;
$ha = md5("exteralayersecuresalt" . $data); //hash de data uit de db met een secure woord ( voor extra beveiliging )
if ($ha == $rol) {//roll is gelijk aan wat er in de cookie zit
} else {
    header("Location: ../"); // rol is niet juist => hack attempt
}
$mysqli->close(); //connectie sluiten

?>
    <script>
        document.addEventListener("DOMContentLoaded", function (event) { //Voert deze functie uit ( puur javascript )  wanneer de pagina geladen is
            //Haal alle "div's" op in overzicht die een pagina voorstellen
            var MD = document.getElementById("first").parentElement;
            var OT = document.getElementById("second").parentElement;
            var S = document.getElementById("third").parentElement;
            var I = document.getElementById("fourth").parentElement;
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
        <link rel="stylesheet" type="text/css"
              href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
        <script type="text/javascript" language="javascript"
                src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript"
                src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <link rel="stylesheet" href="../css/screen.css"/>
        <link rel="stylesheet" href="../css/semantic.min.css">
        <!-- laad de jquery in voor autocomplete -->
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

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
        <div id="Filter1" class="ui floating dropdown labeled icon button">
            <i class="filter icon"></i>
            <span class="text">Filter prioriteit</span>

            <div class="menu">
                <div value="Default" class="header">
                    <i class="tags icon"></i>
                    Prioriteit
                </div>
                <div onclick="PriorityChange('Niet Dringend')" class="item">
                    <div class="ui green empty circular label"></div>
                    Niet dringend
                </div>
                <div onclick="PriorityChange('Dringend')" class="item">
                    <div class="ui yellow empty circular label"></div>
                    Dringend
                </div>
                <div onclick="PriorityChange('Zeer Dringend')" class="item">
                    <div class="ui red empty circular label"></div>
                    Zeer Dringend
                </div>

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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <!-- laad de jquery in voor autocomplete -->
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

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
<main id="Overzicht_Takenlijst" class="hidden">
    <h1 class="mijnklasse topp">Overzicht takenlijst</h1>
    <div id="Filter1" class="ui floating dropdown labeled icon button">
        <i class="filter icon"></i>
        <span class="text">Filter prioriteit</span>
        <div class="menu">
            <div value="Default" class="header">
                <i class="tags icon"></i>
                Prioriteit
            </div>
            <div onclick="PriorityChange('Niet Dringend')" class="item">
                <div class="ui green empty circular label"></div>
                Niet dringend
            </div>
            <div onclick="PriorityChange('Dringend')" class="item">
                <div class="ui yellow empty circular label"></div>
                Dringend
            </div>
            <div onclick="PriorityChange('Zeer Dringend')" class="item">
                <div class="ui red empty circular label"></div>
                Zeer Dringend

            </div>
        </div>

        <!-- Filter op Werknemer
        <div id="Filter2" class="ui floating dropdown labeled icon button">
            <i class="filter icon"></i>
            <span class="text">Filter werknemer</span>
            <div class="menu" id="Filter_Worker">
                <div value="Default" class="header">
                    <i class="tags icon"></i>
                    Werknemer
                </div>
            </div>
        </div>
    !-->
        <!--Oude filter op campussen!-->
        <select class="ui search dropdown" name="Filter_Campussen" id="Filter_Campussen"
                onchange="CampusChange(this.value)">
            <option value="Default">Campus</option>
        </select>


        <section id="Filters_Zoek">
            <!--<input type="text" name="Filter_Taak" id="Filter_Taak" placeholder="Titel taak.."/>!-->
            <input type="text" name="Filter_Taak" id="Filter_Taak" placeholder="Titel taak.." OnKeyup="TitelChange
                (this.value)"/>
            <i class="ui search icon"></i>
            <input type="text" name="Filter_Lokaal" id="Filter_Lokaal" placeholder="Lokaal.."
                   OnKeyup="LokaalChange(event,this.value)"/>
            <i class="ui search icon"></i>
        </section>
        <div class="clearfix"></div>

        <section id="SelectedFilters">
            <div>
                <h3>Geselecteerde Filters: </h3>

                <div id="TitelFilter" onclick="TitelRemove(this)">
                    <label></label>
                </div>

        <i class="ui search icon"></i>
        <input type="text" name="Filter_Lokaal" id="Filter_Lokaal" placeholder="Lokaal.."
               OnKeyup ="LokaalChange(event,this.value)"/>
        <i class="ui search icon"></i>
    </section>

    <section id="Grid">
        <a href="#">
            <i id="Weergave_Tabel" class="fa fa-list-alt popup" data-content="Tabel weergave"></i>
        </a>
        <a href="../Overzicht_Takenlijst/index.php">
            <i id="Weergave_Kaartjes" class="fa fa-th-large popup" data-content="Kaartjes weergave"></i>
        </a>

    </section>
    <div class="clearfix"></div>

    <section id="SelectedFilters">
        <div>
            <h3>Geselecteerde Filters: </h3>
            <div id="TitelFilter" onclick="TitelRemove(this)">
                <label></label>
>>>>>>> origin/master
            </div>

        </section>
        <div class="clearfix"></div>

        <h1 class="mijnklasse">Overzicht taken</h1>
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
        <p>Vragen? Mail naar <a href="mailto:helpdesk@howest.be">helpdesk@howest.be</a> of download <a href="">hier</a>
            de handleiding</p>
    </footer>
    <div class="clearfix"></div>
    <script>
        $(document).ready(function () {
            console.log("ok");
            console.log($("#Overzicht_Takenlijst"));
            $("#Overzicht_Takenlijst").fadeIn(2000);
        });

    </script>
    </body>
    </html>
    <script>
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

    document.getElementById("Weergave_Kaartjes").addEventListener("click", function(e){
        e.preventDefault();
        $("#Overzicht_Takenlijst").fadeOut(400);
        newLocation = document.getElementById("Weergave_Kaartjes").parentNode.href;
        setTimeout(function(){window.location = newLocation; }, 400);
    }, false);

    $('.popup')
        .popup({
            inline   : true,
            hoverable: true,
            position : 'bottom left',
            delay: {
                show: 100,
                hide: 100
            }
        });

var mnarray=[];
var mnarray2=[];
var mnarray3=[];
    $('.dropdown')
        .dropdown({
            // you can use any ui transition
            transition: 'drop'
        })
    ;
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
    function afmelden(a) {
        console.log("test");

        $.ajax({
            url: '../logout.php',
            dataType: 'html',
            success: function (data) {
                //data returned from php
                window.open("../", "_self");
            }
        });
    }
    var mijnteller = 0;


    //Haal alle kaartjes op van een bepaalde lijst
    Trello.get("/lists/" + takenlist + "?fields=name&cards=open&card_fields=name&token=" + application_token, function (cards) {

        //console.log(cards["cards"]);
        var CardId = [];
//overloop alle kaarten die we terug krijgen
        console.log(cards["cards"].length);
        var mijnstopsignaal = cards["cards"].length;
        $.each(cards["cards"], function (ix, card) {
            //console.log(card.id);

            var full = [];
            var tempydesc = [];
            var tempyatt = [];

//      
            Trello.get("/cards/" + card.id + "?fields=name,desc&attachments=true&token=" + application_token, function (carddesc) {
                //  console.log(carddesc);
                var tempy = [];
                $.each(carddesc, function (ix, card) {
                    //console.log(ix);
                    //  console.log(card);
                    switch (ix) {
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
                maakitem(tempy[0], tempy[1], tempy[2], tempy[3]);
                mijnteller++;
                if (mijnteller == mijnstopsignaal) {
                    console.log("gedaan");
                    $('#OT')
                        .removeClass('display')
                        .addClass('table table-striped table-bordered');

                    ooTable = $('#OT').DataTable({
                        "dom": '<"top">rt<"bottom"lp><"clear">'
                    });
                    $(function () {
                        $("#Filter_Lokaal").autocomplete({
                            source: mnarray

                        });
                        $.each(mnarray2, function (ix, campussen) {
                            var option = document.createElement("OPTION");
                            option.setAttribute("value", campussen);
                            option.innerHTML = campussen;
                            document.getElementById("Filter_Campussen").appendChild(option);
                        });

                    });
                }
            });
        });
        console.log("ja");
    });

    function maakitem(id, name, desc, attach) {
        var x = desc.split("/n@");
        var de = x[0];
        var prio = x[1];
        var eml = x[2];
        var klas = x[3];

        if (mnarray != null) {
            if (mnarray.indexOf(klas) == -1) {
                mnarray.push(klas);
            }

        } else {

    var color;
    // Toon kleur op basis van prioriteit
    switch (prio) {
        case "Niet Dringend": color = "#5bbd72";
            break;
        case "Dringend": color = "#f2c61f";
            break;
        case "Zeer Dringend": color = "#d95c5c";
            break;
    }

    if(mnarray!=null){
        if(mnarray.indexOf(klas)==-1){
            mnarray.push(klas);
        }
        var camp = klas.split(".")[0];
        if (mnarray2 != null) {
            if (mnarray2.indexOf(camp) == -1) {
                mnarray2.push(camp);
            }

        } else {
            mnarray2.push(camp);
        }


        var tr = document.createElement("tr");
        tr.id = id;
        var td1 = document.createElement("td");
        td1.appendChild(document.createTextNode(name));
        var td2 = document.createElement("td");
        td2.appendChild(document.createTextNode(de));
        var td3 = document.createElement("td");
        if(prio=="Dringend"){prio="Dringend ";}
        td3.appendChild(document.createTextNode(prio));
        var td99 = document.createElement("td");
        td99.appendChild(document.createTextNode(klas));


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td99);

        var doe = 0;
        var td100 = document.createElement("td");
        $.each(attach, function (ix, at) {
            console.log(at);
            doe = 1;

            var img = document.createElement("img");
            img.src = at["url"];
            img.className = "picturetable";
            td100.appendChild(img);

    }else{
        mnarray2.push(camp);
    }

    var tr =  document.createElement("tr");
    tr.id = id;
    var td1 = document.createElement("td");
    td1.appendChild(document.createTextNode(name));
    var td2 = document.createElement("td");
    td2.appendChild(document.createTextNode(de));
    var td3 = document.createElement("td");
    //td3.appendChild(document.createTextNode(prio));
    var div = document.createElement("div");
    div.style.borderRadius = "10px";
    div.style.backgroundColor = color;
    div.style.width = "15px";
    div.style.height = "15px";
    div.style.display = "inline-block";
    div.style.float = "right";
    div.style.marginRight = "10px";
    td3.appendChild(document.createTextNode(prio));
    td3.appendChild(div);
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
        if (doe == 0) {


            td100.appendChild(document.createTextNode("geen foto"));

        }
        tr.appendChild(td100);
//}
        var td4 = document.createElement("td");
        var iWrite = document.createElement("i");

        iWrite.className = "write icon";
        iWrite.addEventListener("click", function () {
            dosomething(tr);
            formmodified = 1;
        });

        td4.appendChild(iWrite);
        tr.appendChild(td4);

        if (ooTable != null) {
            ooTable.row.add(tr).draw();
        } else {
            var table = document.getElementById("OverzichtTaken");
            table.appendChild(tr);
        }
    }

    var FilterSection = document.getElementById("SelectedFilters");
    function PriorityChange(value) {
        if (value != "Default") {
            makeDiv(value, "P");
            filterglobaal();
            //  Filters(value,"P");
        }

    }
    function WorkerChange(value) {
        if (value != "Default") {
            makeDiv(value, "W");
            filterglobaal();
            //  Filters(value,"W");
        }
    }
    function CampusChange(value) {
        if (value != "Default") {
            makeDiv(value, "C");
            filterglobaal();
            //  Filters(value,"C");
        }
    }

    function makeDiv(name, idprefix) {
        var div = document.createElement("DIV");
        div.setAttribute("class", "");
        div.setAttribute("Onclick", "DeleteFilter(this)");
        div.setAttribute("id", idprefix + "/" + name);

        var label = document.createElement("LABEL");
        label.innerHTML = name;
        label.className = "ui blue large horizontal label";

        var icon = document.createElement("i");
        icon.className = "delete icon";

        label.appendChild(icon);
        div.appendChild(label);

        FilterSection.appendChild(div);

    }
    function filterglobaal() {
        var filt = document.getElementById("SelectedFilters");
        //document.getElementById("SelectedFilters").childNodes[3].id.split("/")[1];
        console.log(filt.childNodes);
        var a = "";
        $.each(filt.childNodes, function (ix, c) {

            if (ix <= 2) {
            } else {
                // console.log("YEUY");
                //  console.log(c);
                var id = c.id.split("/")[1];
if(id=="Dringend"){id="Dringend ";}
                if (a == "") {
                    a = id;
                } else {
                    a = a + "|" + id;
                }

            }

        });
        console.log(a);
        //  a = "Niet Dringend|Dringend|RSS|GKG";
        ooTable.search(a, true, true).draw();
    }
    function TitelChange(value) {
        var TitelFilter = document.getElementById("TitelFilter");
        TitelFilter = TitelFilter.firstChild.nextSibling;
        TitelFilter.innerText = value;
        //  Filters("niks","/");
        filterglobaal();

    }
    function TitelRemove(element) {
        //console.log(element.firstChild.nextSibling);
        element.firstChild.nextSibling.innerHTML = "";
        //Filters("niks","/");
        filterglobaal();
    }

    function LokaalChange(event, value) {
        var code = event.keyCode;
        if (code == 13) {
            //console.log(value);
            makeDiv(value, "L");
            filterglobaal();
            // Filters(value,"L");
        }


    }
    function DeleteFilter(element) {
        console.log(element);
        element.parentNode.removeChild(element);
        filterglobaal();
        //   Filters(element);
        var e = element.id;
        var x = e.split("/");
        /*
         $.ajax({
         url: '../CookieDeleter.php?val='+x[1],
         dataType: 'html',
         success: function(data){
         Filters("niks","/");
         //data returned from php
         // window.open("../","_self");
         }
         });*/
    }

    </script>
<?php
//connectie maken met db(mysql)
//local
//$mysqli = new mysqli('localhost', 'root', 'usbw', 'tasktool');
//$mysqli = new mysqli('mysqlstudent','cedriclecat','ooDohQuuo2uh','cedriclecat');
//student howest
$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');
if ($mysqli->connect_error) {
    echo "Geen connectie mogelijk met de database";
}
$data = array();
?>


    <script>    var arraymetlokalen = [];
        var campussen = []</script>
<?php
//alles ophalen en in array steken
//echo 'h';
$result = $mysqli->query("SELECT NAME FROM klassen");
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    ?>
    <script>
        //    console.log("h");
        var lokaal = <?php print "'".$row['NAME']."'" ?>;
        arraymetlokalen.push(lokaal);
        var campus = lokaal.split(".");
        //console.log(campus[0]);
        if (doesExist(campus[0])) {
            campussen.push(campus[0]);
        }
        function doesExist(name) {
            for (var i = 0; i < campussen.length; i++) {
                if (name == campussen[i]) {
                    return false;
                }
            }
            return true;
        }
    </script>
    <?php
    // array_push($data['merken'],$row);
}
//connectie sluiten
$mysqli->close();
?>
<script>
    $(document).ready(function(){
        // Element moet hidden staan voor dat het ingefade wordt
        $("#Overzicht_Takenlijst").fadeIn(600).removeClass('hidden');
    });

</script>
