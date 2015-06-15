<?php
session_start(); // Verplicht als je wilt werken met sessie's
if ($_SERVER["HTTPS"] != "on") { // zet de site om naar https indien het http is MEOT VOOR SECURE VAN DATA
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if (isset($_SESSION['loggedin'])) { // kijkt of er een sessie is
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
};
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
    <title>TaskTool Howest | Statistieken</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <script src="../js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/screen.css"/>
    <!--<link rel="stylesheet" href="../css/icon.min.css">!-->
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/Chart.js"></script>
</head>
<body>
<main id="Statistieken">
    <header>
        <a href="../Overzicht/index.php"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>

        <button><a onclick="afmelden(this)">Afmelden</a></button>
        <nav>
            <ul>
                <li><a id="first" href="../Meld_Defect/index.php">Probleem melden</a></li>
                <li><a id="second" href="../Overzicht_Takenlijst/index.php">Overzicht takenlijst</a></li>
                <li><a id="third" href="#">Statistieken</a></li>
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

    <h1>Statistieken van werknemers</h1>
    <section id="Werknemers">
        <section id="WerkerSelection">
            <p>Klik op een of meerdere werknemers</p>
            <!-- <div id="Checkbox1" class="Checkbox_Werknemer">
                 <input type="checkbox" value="Bennie" id="Bennie"/>
                 <label for="Bennie">Bennie</label>
             </div>

             <div id="Checkbox2" class="Checkbox_Werknemer">
                 <input type="checkbox" value="Alain" id="Alain"/>
                 <label for="Alain">Alain</label>
             </div>

             <div id="Checkbox3" class="Checkbox_Werknemer">
                 <input type="checkbox" value="Erik" id="Erik"/>
                 <label for="Erik">Erik</label>
             </div>

             <div id="Checkbox4" class="Checkbox_Werknemer">
                 <input type="checkbox" value="Jef" id="Jef"/>
                 <label for="Jef">Jef</label>
             </div>-->
        </section>
        <!--<p>Selecteer grafiektype</p>
        <div id="Pie_Chart">
            <p>Pie</p>
            <i  class="pie chart icon"></i>
        </div>
        <div>
            <p>Line</p>
            <i id="Line_Chart" class="line chart icon"></i>
        </div>
        <div>
            <p>Bar</p>
            <i id="Bar_Chart" class="bar chart icon"></i>
        </div>!-->

        <h2>Voltooide taken per werknemer</h2>

        <canvas id="myChart1"></canvas>
        <div id="Legende1">
            <p>Legende</p>

            <div id="GeneratedLegende"></div>
            <div class="clearfix"></div>
        </div>
        <section id="Algemeen">
            <h2>Algemeen overzicht van aantal defecten</h2>
            <canvas id="myChart2"></canvas>
            <div id="Legende2">
                <p>Legende</p>

                <div id="GeneratedLegende2"></div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section id="Prestaties">
            <h2>Prestaties van medewerkers</h2>
            <table class="ui table" id="PrestatiesWerkers">
                <thead>
                <tr>
                    <th>Werknemers</th>
                    <th>Gemiddelde taak afwerktijd</th>
                    <th>Gemiddelde taak doorlooptijd</th>

                </tr>
                </thead>


            </table>
        </section>

        <section id="PrioriteitDoorlooptijd">
            <h2>Doorlooptijd taken per prioriteit</h2>
            <table class="ui table">
                <thead>
                <tr>
                    <th>Prioriteit</th>
                    <th>Gemiddelde doorlooptijd</th>
                </tr>
                </thead>
                <tr>
                    <th>Niet dringend</th>
                    <td id="ND">2 uur</td>
                </tr>
                <tr>
                    <th>Dringend</th>
                    <td id="D">2 uur</td>
                </tr>
                <tr>
                    <th>Zeer dringend</th>
                    <td id="ZD">2 uur</td>
                </tr>
            </table>
        </section>
    </section>
</main>
<div class="clearfix"></div>
<footer>
    <p>Vragen? Mail naar <a href="mailto:helpdesk@howest.be">helpdesk@howest.be</a> of download <a href="">hier</a> de
        handleiding</p>
</footer>
<div class="clearfix"></div>
</body>
</html>
<script>
    function afmelden(a) {


        $.ajax({
            url: '../logout.php',
            dataType: 'html',
            success: function (data) {
                //data returned from php
                window.open("../", "_self");
            }
        });
    }

    //trello
    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    var workers = [];
    var workerId = [];
    var workersindesc = [];
    var StartTimes = [];
    var FinishTimes = [];


    var doorlooppriority = [];
    var doorLoopWorkers = [];
    $(document).ready(GetWorkers);
    function GetWorkers() {
        Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token=" + application_token, function (lists) {

            var werknemers = document.getElementById("WerkerSelection");
            $.each(lists["lists"], function (ix, list) {
                //workers
                if (list.name == "Taken" && list.name == "Voltooid" && list.name == "On hold") {
                    /*  Trello.get("/lists/"+list.id+"?fields=name&cards=open&card_fields=name&token" +
                     "="+application_token, function(cards) {

                     $.each(cards["cards"], function(ix, card){

                     Trello.get("/cards/"+card.id+"?fields=desc&token="+application_token,function(cardinfo)
                     {

                     var descsplilt = cardinfo.desc.split("/n@");
                     $.each(descsplilt,function(ix,descpart){

                     if(descpart.split("@")[0] == "DT")
                     {
                     FinishTimes.push(descpart.split("@")[1]);
                     }

                     });

                     });
                     });


                     });*/


                }
                if (list.name == "Voltooid") {
                    Trello.get("/lists/" + list.id + "?fields=name&cards=open&card_fields=name&token" +
                    "=" + application_token, function (cards) {

                        $.each(cards["cards"], function (ix, card) {

                            Trello.get("/cards/" + card.id + "?fields=desc&token=" + application_token, function (cardinfo) {

                                var temp = [];
                                var tempWorkerTabel = [];

                                var descsplilt = cardinfo.desc.split("/n@");
                                temp.push(descsplilt[1]);
                                $.each(descsplilt, function (ix, descpart) {

                                    if (descpart.split("@")[0] == "N") {
                                        //console.log(descpart.split("@")[1]);
                                        workersindesc.push(descpart.split("@")[1]);
                                        tempWorkerTabel.push(descpart.split("@")[1]);
                                    }
                                    if (descpart.split("@")[0] == "T") {
                                        //console.log(descpart.split("@")[1]);
                                        StartTimes.push(descpart.split("@")[1]);
                                        temp.push(descpart.split("@")[1] + "@" + descpart.split("@")[2]);
                                        tempWorkerTabel.push(descpart.split("@")[1] + "@" + descpart.split("@")[2]);
                                    }
                                    if (descpart.split("@")[0] == "DT") {
                                        tempWorkerTabel.push(descpart.split("@")[1] + "@" + descpart.split("@")[2]);
                                    }
                                    if (descpart.split("@")[0] == "DF") {
                                        FinishTimes.push(descpart.split("@")[1]);
                                        temp.push(descpart.split("@")[1] + "@" + descpart.split("@")[2]);
                                        tempWorkerTabel.push(descpart.split("@")[1] + "@" + descpart.split("@")[2]);
                                    }

                                });
                                doorlooppriority.push(temp);
                                doorLoopWorkers.push(tempWorkerTabel);
                            });
                        });


                    });
                } else if(list.name == "Taken" || list.name == "On hold") {}
                else {
                    workerId.push(list.id);
                    workers.push(list.name);


                    //console.log(werknemers);

                    var div = document.createElement("DIV");
                    div.setAttribute("id", list.id);
                    div.setAttribute("class", "Checkbox_Werknemer");
                    //div.style = border: 1px solid rgb(51, 122, 183); color: rgb(255, 255,
                    // 255); background-color: rgb(51, 122, 183);

                    var input = document.createElement("INPUT");
                    input.setAttribute("type", "checkbox");
                    input.setAttribute("value", list.name);
                    input.setAttribute("id", list.name);

                    var label = document.createElement("LABEL");
                    label.setAttribute("for", list.name);
                    label.innerHTML = list.name;


                    div.appendChild(input);
                    div.appendChild(label);
                    werknemers.appendChild(div);

                    Trello.get("/lists/" + list.id + "?fields=name&cards=open&card_fields=name&token" +
                    "=" + application_token, function (cards) {

                        $.each(cards["cards"], function (ix, card) {

                            Trello.get("/cards/" + card.id + "?fields=desc&attachments=true&token=" + application_token, function (cardinfo) {

                                var descsplilt = cardinfo.desc.split("/n@");
                                $.each(descsplilt, function (ix, descpart) {

                                    if (descpart.split("@")[0] == "T") {
                                        //console.log(descpart.split("@")[1]);
                                        StartTimes.push(descpart.split("@")[1]);
                                    }

                                });

                            });
                        });


                    });
                }

            });

            var timer = setInterval(function () {
                Initialize(werknemers,
                    workersindesc, StartTimes, FinishTimes);
                clearInterval(timer);
                PriorityTabel();
                WorkerTabel();
            }, 2000);


        });
    }




    function WorkerTabel() {
        var workertabel = document.getElementById("PrestatiesWerkers");
        var workertimes = [];
        var x = [];
        $.each(doorLoopWorkers, function (ix, worker) {


            var adddate = worker[0].split("@")[0];
            var addhour = worker[0].split("@")[1];
            var assigndate = worker[2].split("@")[0];
            var assignhour = worker[2].split("@")[1];
            var completedate = worker[3].split("@")[0];
            var completehour = worker[3].split("@")[1];

            var stof = totalTime(adddate, completedate, addhour, completehour);
            var atof = totalTime(assigndate, completedate, assignhour, completehour);

            //console.log(worker);

            var ms = [];
            var ma = [];

            var workerstat = worker[1];
            if (x == null) {
                x.push(workerstat);
                ms.push(stof);
                ma.push(atof);
                x.push(ms,ma);
            }
            else {

                if (x.indexOf(workerstat) == -1) {
                    x.push(workerstat);
                    ms.push(stof);
                    ma.push(atof);
                    x.push(ms,ma);
                }
                else
                {
                   var positie = x.indexOf(workerstat);
                    x[positie+1].push(stof);
                    x[positie+2].push(atof);
                }
            }



        });
        //console.log(x);

        for(var i = 0;i< x.length;i+=3)
        {
            var temp = GetAverage(x[i+1]);
            var temp1 = GetAverage(x[i+2]);

            console.log(temp,temp1);

            var tr = document.createElement("TR");

            var th = document.createElement("TH");
            th.innerHTML = x[i];
            var td1 = document.createElement("TD");
            td1.innerHTML = MinutestoMHDM(temp1);
            var td2 = document.createElement("TD");
            td2.innerHTML = MinutestoMHDM(temp);

            tr.appendChild(th);
            tr.appendChild(td1);
            tr.appendChild(td2);
            workertabel.appendChild(tr);
        }


    }

    function totalTime(startD, stopD, startH, stopH) {
        var hours = 0;
        var minutes = 0;
        var months = 0;
        var days = 0;
        var totaltime = 0;

        if (startD == stopD) {
            hours = stopH.split(":")[0] - startH.split(":")[0];
            minutes = stopH.split(":")[1] - startH.split(":")[1];
            if (minutes < 0) {
                minutes = 60 + minutes;
                ;
                hours--;
            }
            totaltime = parseInt(minutes) + parseInt(hours * 60) + parseInt(days * 24 * 60) + parseInt(months * 31 * 24 * 60);
        }
        else {

            months = stopD.split(" ")[1] - startD.split(" ")[1];

            days = stopD.split(" ")[2] - startD.split(" ")[2];
            hours = stopH.split(":")[0] - startH.split(":")[0];

            minutes = stopH.split(":")[1] - startH.split(":")[1];


            if (minutes < 0) {
                60 + minutes;
                hours--;
            }
            if (hours < 0) {
                hours = 24 + hours;
                days--;
            }

            if (days < 0) {
                days = 31 + days;
                months--;
            }


            totaltime = parseInt(minutes) + parseInt(hours * 60) + parseInt(days * 24 * 60) + parseInt(months * 31 * 24 * 60);
        }

        return (totaltime);
    }

    function PriorityTabel() {
        var nd = [];
        var d = [];
        var zd = [];
        $.each(doorlooppriority, function (ix, starttime) {
            var startD = starttime[1].split("@")[0];
            var startH = starttime[1].split("@")[1];
            var stopD = starttime[2].split("@")[0];
            var stopH = starttime[2].split("@")[1];

            var totaltime = totalTime(startD, stopD, startH, stopH);

            if (starttime[0] == "Niet Dringend") {
                nd.push(totaltime);
            }
            else if (starttime[0] == "Dringend") {
                d.push(totaltime);
            }
            else if (starttime[0] == "Zeer Dringend") {
                zd.push(totaltime);
            }


            //MinutestoMHDM(2400);
        });
        var nietdringend = GetAverage(nd);
        var dringend = GetAverage(d);
        var zeerdringend = GetAverage(zd);

        nietdringend = MinutestoMHDM(nietdringend);
        dringend = MinutestoMHDM(dringend);
        zeerdringend = MinutestoMHDM(zeerdringend);

        var thnietdringend = document.getElementById("ND");
        thnietdringend.innerHTML = nietdringend;
        var thdringend = document.getElementById("D");
        thdringend.innerHTML = dringend;
        var thzeerdringend = document.getElementById("ZD");
        thzeerdringend.innerHTML = zeerdringend;
    }

    function GetAverage(array) {
        var total = 0;
        for (var i = 0; i < array.length; i++) {
            total += array[i];

        }
        if (total <= 0) {
            return 0;
        }
        return (total / array.length);
    }
    function MinutestoMHDM(minutes) {
        var minutezz = 0
        var hours = 0;
        var days = 0;

        minutezz = Math.floor(minutes % 60);
        hours = Math.floor((minutes / 60)) % 24;
        days = Math.floor((minutes / 60) / 24);

        return "Dagen: " + days + "  uren: " + hours + "  minuten: " + minutezz;

    }

</script>