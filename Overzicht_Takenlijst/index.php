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

    var mijnarray = [];
</script>
<?php
$data = unserialize($_COOKIE['cookie']);
print_r($data);
foreach($data as $d){
?>
<script>
    console.log(mijnarray);
    mijnarray.push(<?php print  '"'.$d.'"' ?>);
</script>
<?php
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $.each(mijnarray,function(ix,value){
            var x = value.split("/");
            makeDiv(x[0],x[1]);
                    });
        Filters("niks","/");
    });

</script>
<?php
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Overzicht takenlijst</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
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
    <h1>Overzicht takenlijst</h1>

    <!-- Pop-up Window !-->
    <div id="Popup" class="ui test modal transition" style="z-index: 100000;">
        <!-- TODO: Close icon zoeken !-->
        <i id="close_Popup" class="close icon"></i>
        <div id="Card_Header" class="header">
        </div>
        <div class="content">
            <div class="left">
                <img id="Card_Image"/>
            </div>
            <div class="right">
                <input id="Card_Titel" type="text" placeholder="Titel kaartje"/>

                <div class="ui-widget">

                    <input id="Card_Lokaal" type="text" placeholder="GKG A.202b"/>
                </div>
                <textarea id="Card_Omschrijving" cols="30" rows="10"></textarea>
                <select id="Card_Prioriteit">
                    <option value="Niet Dringend">Niet dringend</option>
                    <option value="Dringend">Dringend</option>
                    <option value="Zeer Dringend">Zeer Dringend</option>
                </select>
                <label>Add Worker</label>
                <select id="AddWorker" onChange="CopyCard(this)">

                </select>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="actions">
            <div id="btnVerwijder" class="ui negative right labeled icon button">
                Verwijder taak <i class="trash icon"></i>
            </div>

            <div class="ui black button">
                Annuleer
            </div>
            <div id="btnOpslaan" class="ui positive right labeled icon button">
                Opslaan <i class="checkmark icon"></i>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- Oude filter op Prioriteit <section>
           <select name="Filter_Prioriteit" id="Filter_Prioriteit" onchange="PriorityChange(this.value)">
               <option value="Default">Prioriteit</option>
               <option value="Niet dringend">Niet dringend</option>
               <option value="Dringend">Dringend</option>
               <option value="Direct">Direct</option>
           </select>!-->

    <!-- Oude filter op Werknemer
         <select name="Filter_Worder" id="Filter_Worker" onchange="WorkerChange(this.value)">
             <option value="Default">Werknemer</option>
         </select>!-->

    <!-- Filter op prioriteit !-->
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
    </div>

    <!-- Filter op Werknemer !-->
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

    <!--Oude filter op campussen!-->
    <select class="ui search dropdown" name="Filter_Campussen" id="Filter_Campussen" onchange="CampusChange(this.value)">
        <option value="Default">Campus</option>
    </select>




    <section id="Filters_Zoek">
        <!--<input type="text" name="Filter_Taak" id="Filter_Taak" placeholder="Titel taak.."/>!-->
        <input type="text" name="Filter_Taak" id="Filter_Taak" placeholder="Titel taak.." OnKeyup="TitelChange
                (this.value)"/>
        <i class="ui search icon"></i>
        <input type="text" name="Filter_Lokaal" id="Filter_Lokaal" placeholder="Lokaal.."
               OnKeyup ="LokaalChange(event,this.value)"/>
        <i class="ui search icon"></i>
    </section>

    <section id="Grid">
        <i class="fa fa-list-alt popup" data-content="Tabel weergave"></i>

        <i class="fa fa-th-large popup" data-content="Kaartjes weergave"></i>
    </section>
    <div class="clearfix"></div>
    <!-- Checkbox die dynamisch aangemaakt zal worden

    <li class="panel panel-default card_final liBorderG" id="556ff1a4cef39b5ae79b9242" draggable="true"
        ondragstart="drag(event)" style="width: 400px;">

        <div class="clearfix"></div>
        <div class="panel-heading"><a class="panel-title collapsed" data-toggle="collapse"
                                      data-parent="cardlist3" href="#d556ff1a4cef39b5ae79b9242"
                                      aria-expanded="false" aria-controls="collapseOne">TEST KAARTJE</a>
            <input type="checkbox" id="CheckboxTest" name="CheckboxTest"/></div>

        <div class="panel-collapse collapse" id="d556ff1a4cef39b5ae79b9242" role="tabpanel"><p
                class="lokaal content" style="padding-top: 10px;">GKG.PTI Werkplaats</p>

            <p class="campus content"></p>

            <div class="clearfix"></div>
            <p class="panel-body">smldkjfqsdkljfklsdqf</p></div>

    </li>
    </section>!-->

    <section id="SelectedFilters">
        <div>
            <h3>Geselecteerde Filters: </h3>
            <div id="TitelFilter" onclick="TitelRemove(this)">
                <label></label>
            </div>
        </div>

    </section>
    <div class="clearfix"></div>
    <section id="Taken" class="Section_Float draglist">
        <h2 class="Overzicht_Titels">Taken</h2>

    </section>
    <section id="Medewerkers" class="Section_Float">
        <h2 class="Overzicht_Titels">Medewerkers</h2>

    </section>

    <section id="OnHold" class="Section_Float draglist">
        <h2 class="Overzicht_Titels">On hold</h2>
        <ul class="cardlist draglist">

        </ul>
    </section>

    <section id="Voltooid" class="Section_Float draglist">
        <h2 class="Overzicht_Titels">Voltooid</h2>

    </section>
    <div class="clearfix"></div>
</main>
<div class="clearfix"></div>
<footer>
    <p>Vragen? Mail naar <a href="mailto:helpdesk@howest.be">helpdesk@howest.be</a> of download <a href="">hier</a> de handleiding</p>
</footer>
<div class="clearfix"></div>
<script>
var mnarray=[];
var mnarray2=[];
    $('.dropdown')
        .dropdown({
            // you can use any ui transition
            transition: 'drop'
        })
    ;

    $('.popup')
        .popup({
            inline   : true,
            hoverable: true,
            position : 'bottom left',
            delay: {
                show: 100,
                hide: 100
            }
        })
    ;

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
    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    var checkKaartInmedewerker;
    var workers = [];

    $(document).ready(GetCards);


    function allowDrop(ev) {
        //console.log(ev.target.tagName);
        if(event.target.tagName !="A" && event.target.className != "lastcard")
        {
            ev.preventDefault();
        }

    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {

        if(event.target.tagName=="LI")
        {
            var newtarget =  event.target.parentElement;
        }
        else if(event.target.tagName=="DIV")
        {
            var newtarget = event.target.parentElement.parentElement;
        }
        else if(event.target.tagName=="SECTION")
        {
            //console.log(event.target.firstChild.nextSibling.nextSibling.nextSibling);
            var newtarget = event.target.firstChild.nextSibling.nextSibling.nextSibling;
        }
        else if(event.target.tagName=="H2")
        {
            //console.log(event.target.nextSibling.nextSibling);
            var newtarget = event.target.nextSibling.nextSibling
        }
        else
        {
            var newtarget = ev.target;
        }
        //console.log(event.target.tagName);

        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        var cardid = data;
        var listId = newtarget.id;

        newtarget.appendChild(document.getElementById(data));

        if(newtarget.parentNode.id == "Medewerkers") {
            document.getElementById(data).style.width = "350px";
            document.getElementById(data).style.maxWidth = "400px";
            console.log("in nen mederwerk gesleept");
            Trello.get("/cards/" + cardid + "?fields=desc&token=" + application_token, function (cardinfo) {
                var unfnaam = newtarget.firstChild.innerHTML.split("<");
                var naam = unfnaam[0];

                var now = new Date();
                var date =now.getFullYear()  + " " + (now.getMonth()+1) + " " + now.getDate();
                var time = now.getHours() + ":" + now.getMinutes();


                var niewedescription = cardinfo.desc + "/n@N@" + naam + "/n@DT@" + date + "@" + time;

                Trello.put("/cards/" + cardid + "?key=" + APP_KEY + "&token=" + application_token + "&idList=" + listId + "&desc=" + niewedescription);
            });
        }
        if(newtarget.parentNode.id == "Voltooid")
        {

            var now = new Date();
            var date =now.getFullYear()  + " " + (now.getMonth()+1) + " " + now.getDate();
            var time = now.getHours() + ":" + now.getMinutes();


            Trello.get("/cards/" + cardid + "?fields=desc&token=" + application_token, function (cardinfo) {

                var niewedescription = cardinfo.desc +"/n@DF@" + date + "@" + time;
                Trello.put("/cards/" + cardid + "?key=" + APP_KEY + "&token=" + application_token + "&idList=" + listId + "&desc=" + niewedescription);

            });
        }
        else
        {
            document.getElementById(data).style.width = "380px";
            //document.getElementById(data).style.maxWidth = "250px";
            //console.log("nie in nen medewerker");
            Trello.put("/cards/"+cardid+"?key="+APP_KEY+"&token="+application_token+"&idList="+listId+"");//&desc=is verzet
        }

        Trello.get("/cards/"+cardid+"?fields=desc&token="+application_token,function(cardinfo)
        {
            var unfnaam = newtarget.firstChild.innerHTML.split("<");
            var naam = unfnaam[0];

            var now = new Date();
            var date = now.getDate() + "/" + now.getMonth()+"/"+now.getFullYear();
            var time = now.getHours()+":"+now.getMinutes();

            var niewedescription =  cardinfo.desc + "/n@N@" + naam+ "/n@DT@"+ date+"@"+time;
            console.log(niewedescription);
        });

    }

    // Zorg ervoor dat de kaartjes kunnen gesleept worden
    var aantalCardsMedewerker = document.getElementsByClassName("card_final").length;
    for (i = 0; i < aantalCardsMedewerker; i++) {
        document.getElementsByClassName("card_final")[i].setAttribute("draggable", "true");
        document.getElementsByClassName("card_final")[i].setAttribute("ondragstart", "drag(event)");

        var parentNode = document.getElementsByClassName("card_final")[i].parentNode.className;
        if (parentNode == "draglist") {
            //console.log("ok");
            document.getElementsByClassName("card_final")[i].style.width = 400 + "px";
        }
    }

    // Zorg ervoor dat de kaartjes kunnen gedropt worden in de lijsten
    var aantalLijsten = document.getElementsByClassName("draglist").length;
    for (i = 0; i < aantalLijsten; i++) {
        document.getElementsByClassName("draglist")[i].setAttribute("ondrop", "drop(event)");
        document.getElementsByClassName("draglist")[i].setAttribute("ondragover", "allowDrop(event)");
    }


    //trello


    function GetCards()
    {
        Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token="+application_token+"",function(lists)
        {
            $.each(lists["lists"],function(ix,list)
            {
                var List = [];

                List.push(list.id,list.name); // in list zitten de parameters van de lijsten dus in ons geval hebben we het id en naam nodig

                var selecteddiv;
                //selecteren voor war de kaarten in te plaatsen

                if(list.name== "Taken")
                {
console.log(list);
                    var taken = document.getElementById("Taken");
                    var unorderedlist= maakUL(list.id,false);
                    getCards(unorderedlist,list.id,false);
                    taken.appendChild(unorderedlist);
                }
                else if(list.name == "Voltooid")
                {
                    var voltooid = document.getElementById("Voltooid");
                    var unorderedlist= maakUL(list.id,false);
                    getCards(unorderedlist,list.id,false);
                    voltooid.appendChild(unorderedlist);

                }
                else if(list.name == "On hold")
                {
                    var onhold = document.getElementById("OnHold");
                    var unorderedlist= maakUL(list.id,false);
                    getCards(unorderedlist,list.id,false);
                    onhold.appendChild(unorderedlist);
                }
                else
                {
                    selecteddiv = document.getElementById("Medewerkers");

                    var unorderedlist= maakUL(list.id,true);

                    var li = document.createElement("LI");
                    li.setAttribute("class","Werkman_Naam");
                    li.innerHTML = list.name;

                    var i = document.createElement("I");
                    i.setAttribute("class","ui print icon");
                    i.setAttribute("onclick","PrintTasks(this)");
                    i.style.cursor = "pointer";

                    li.appendChild(i);
                    unorderedlist.appendChild(li);

                    getCards(unorderedlist,list.id,true);

                    selecteddiv.appendChild(unorderedlist);


                    var divItem = document.createElement("div");
                    divItem.className = "ui item";
                    divItem.onclick = function(){WorkerChange(list.name)};

                    var option = document.createElement("OPTION");
                    option.setAttribute("value",list.name);
                    option.innerHTML = list.name;

                    document.getElementById("Filter_Worker").appendChild(divItem);
                    divItem.appendChild(option);
                    workers.push(list.name);
                }
                // console.log(selecteddiv);
            });

        });
    }


    function maakUL(id,izworker)
    {
        var ul = document.createElement("UL");
        ul.setAttribute("class","draglist");
        ul.setAttribute("id",id);
        ul.setAttribute("ondrop","drop(event)");
        ul.setAttribute("ondragover","allowDrop(event)");

        if(!izworker)
        {
            ul.classList.add("cardlist");
        }
        return ul;
    }


    function getCards(selecteddiv,listID,izworker)
    {
        //Haal alle kaartjes op van een bepaalde lijst
        Trello.get("/lists/"+listID+"?fields=name&cards=open&card_fields=name&token="+application_token, function(cards) {

            //console.log(cards["cards"]);
            var CardId = [];
//overloop alle kaarten die we terug krijgen

            var mijnstopsignaal = cards["cards"].length;
            mijnteller = 0;
            $.each(cards["cards"], function(ix, card){
                //console.log(card.id);
                var temparr = [];
                var attachementsarr = [];
                var description = [];


                var li = document.createElement("LI");
                li.setAttribute("class","panel panel-default card_final");
                li.setAttribute("id",card.id);
                li.setAttribute("draggable","true");
                li.setAttribute("ondragstart","drag(event)");
                if(!izworker)
                {

                    li.style.maxWidth = "400px";
                }
                else
                {
                    li.style.width = "400px";
                }

                // Als op kaart geklikt wordt -> Toon pop-up
                li.addEventListener("dblclick", function() {

                    // Indien transition niet werkt -> Bootstrap link wegdoen
                    $('.modal').addClass('scrolling');
                    $('.modal')
                        .modal('setting', 'transition', 'scale')
                        .modal('show');

                    // li -> geselecteerde taak
                    console.log(li);

                    var style = window.getComputedStyle(li);
                    var borderBottom = style.getPropertyValue('border-bottom');

                    var color;
                    var index;
                    var prioriteit;
                    var classlijst = li.classList;

                    switch (classlijst[3]) {
                        case "liBorderG": color = "yellow"; index = 1; prioriteit = "Dringend";
                            break;
                        case "liBorderL": color = "green"; index = 0; prioriteit = "Niet Dringend";
                            break;
                        case "liBorderH": color = "red"; index = 2; prioriteit = "Zeer Dringend";
                            break;
                    }
                    var kaart_titel = li.childNodes[0].innerText;
                    var kaart_lokaal = li.childNodes[1].childNodes[0].innerText;
                    var kaart_omschrijving = li.childNodes[1].childNodes[3].innerText;
                    var imageSource = li.childNodes[1].childNodes[5].src;



                    var elementHeaderTitel = document.getElementById("Card_Header");

                    elementHeaderTitel.innerText = kaart_titel;

                    var elementTitel = document.getElementById("Card_Titel");
                    elementTitel.value = kaart_titel;

                    var elementLokaal = document.getElementById("Card_Lokaal");
                    elementLokaal.value = kaart_lokaal;

                    var elementOmschrijving = document.getElementById("Card_Omschrijving");
                    elementOmschrijving.innerText = kaart_omschrijving;

                    var elementPrioriteit = document.getElementById("Card_Prioriteit");
                    elementPrioriteit.selectedIndex = index;

                    var elementImage = document.getElementById("Card_Image");
                    elementImage.src = imageSource;



                    document.getElementById("btnOpslaan").addEventListener("click", function(){
                        console.log("uitgevoerd");
                        var nieuweTitel = elementTitel.value;
                        var nieuwLokaal = elementLokaal.value;
                        var nieuweOmschrijving = elementOmschrijving.value;
                        var nieuwePrioriteit = document.getElementById("Card_Prioriteit").value;
                        var listId = li.parentNode.id;

                        // Pas kaartje aan en toon direct de verandering


                        Trello.get("/cards/"+card.id+"?fields=desc&token="+application_token,function(carddesc)
                        {

                          /*  */
                            var odesc = carddesc.desc.split("/n@");
                            var nieuweDescription = nieuweOmschrijving + "/n@" +nieuwePrioriteit+"/n@"+odesc[2]+"/n@"+ nieuwLokaal;
                            var hiden = carddesc.desc.split("/n@N@");
                            console.log(hiden);
                            if(hiden.length > 1)
                            {
                                nieuweDescription += "/n@N@"+ hiden[1];
                            }
                           // console.log(nieuweDescription);
                            Trello.put("/cards/"+li.id+"?key="+APP_KEY+"&token="+application_token+"&idList="+listId+"&desc="+nieuweDescription+"&name="+nieuweTitel);



                        });
                       //foute code in de trello.put




                        var parent = li.firstChild;
                        var parent2 = li.childNodes[1];
                        var nieuweTitelLink = document.createElement("a");
                        nieuweTitelLink.appendChild(document.createTextNode(nieuweTitel));

                        var hx = li.firstChild.childNodes[0].href;
                        var hr = hx.split("/");

                        // Verander de titel
                        nieuweTitelLink.href = hr[hr.length-1];
                        nieuweTitelLink.setAttribute("data-toggle", "collapse");
                        parent.replaceChild(nieuweTitelLink,parent.childNodes[0]);

                        // Verander het lokaal
                        var nieuwLokaalElement = document.createElement("p");
                        var textNode = document.createTextNode(nieuwLokaal);
                        nieuwLokaalElement.appendChild(textNode);
                        nieuwLokaalElement.className = "lokaal content";
                        nieuwLokaalElement.style.paddingTop = "10px";

                        parent2.replaceChild(nieuwLokaalElement, parent2.firstChild);

                        // Verander de omschrijving
                        var nieuwOmschrijvingElement = document.createElement("p");
                        nieuwOmschrijvingElement.className = "panel-body";
                        var textNodeOmschrijving = document.createTextNode(nieuweOmschrijving);
                        nieuwOmschrijvingElement.appendChild(textNodeOmschrijving);

                        parent2.replaceChild(nieuwOmschrijvingElement, parent2.childNodes[3]);

                        // Verander de prioriteit
                        switch (nieuwePrioriteit) {
                            case "Niet Dringend":
                                if (li.classList.contains("liBorderL")) {
                                    li.classList.remove("liBorderL");
                                }
                                else if (li.classList.contains("liBorderG")) {
                                    li.classList.remove("liBorderG");
                                }
                                else if (li.classList.contains("liBorderH")) {
                                    li.classList.remove("liBorderH");
                                }
                                li.classList.add("liBorderL");

                                break;
                            case "Dringend":
                                if (li.classList.contains("liBorderL")) {
                                    li.classList.remove("liBorderL");
                                }
                                else if (li.classList.contains("liBorderG")) {
                                    li.classList.remove("liBorderG");
                                }
                                else if (li.classList.contains("liBorderH")) {
                                    li.classList.remove("liBorderH");

                                }
                                li.classList.add("liBorderG");
                                break;
                            case "Zeer Dringend":
                                if (li.classList.contains("liBorderL")) {
                                    li.classList.remove("liBorderL");
                                }
                                else if (li.classList.contains("liBorderG")) {
                                    li.classList.remove("liBorderG");
                                }
                                else if (li.classList.contains("liBorderH")) {
                                    li.classList.remove("liBorderH");
                                }
                                li.classList.add("liBorderH");
                                break;
                        }

                    },false);

                    document.getElementById("btnVerwijder").addEventListener("click", function(){

                        var nieuweTitel = elementTitel.value;
                        var listId = li.parentNode.id;
                        var ul = li.parentNode;

                        // Verwijder kaart in Trello
                        Trello.delete("/cards/"+li.id+"?key="+APP_KEY+"&token="+application_token);

                        // Verwijder kaart op pagina
                        ul.removeChild(li);

                    },false);

                    $( "#Card_Lokaal" ).autocomplete({
                        source: arraymetlokalen
                    });


                    var worker =this.parentNode.firstChild.innerText;
                    var select = document.getElementById("AddWorker");
                    var otherworkers = this.getElementsByTagName("label")[0].innerHTML.split(" ");
                    //console.log(otherworkers);


                    var element = select.firstChild;
                    while (element){
                        select.removeChild(element);
                        element = select.firstChild;
                    }
                    var input = document.createElement("OPTION");
                    input.setAttribute("value","Default");
                    input.innerHTML = "Default";
                    select.appendChild(input);

                    //<option value="Default">Default</option>
                    var temp = [];
                    for(var i = 0;i<workers.length;i++)
                    {
                        if(worker != workers[i])
                        {
                            temp.push(workers[i]);
                        }
                    }

                    if(otherworkers.length >1)
                    {

                        for(var j = 1;j<otherworkers.length;j++)
                        {
                            for( var i = 0;i<workers.length;i++)
                            {
                                if(otherworkers[j] == workers[i])
                                {
                                    delete workers[i];
                                }
                            }
                        }
                    }

                    for( var i = 0;i<workers.length;i++)
                    {
                        if(workers[i]!= null)
                        {
                            var input = document.createElement("OPTION");
                            input.setAttribute("value",workers[i]);

                            input.innerHTML = workers[i];
                            select.appendChild(input);
                        }
                    }





                    var label = document.createElement("LABEL");
                    label.style.visibility = "hidden";
                    label.innerHTML = card.id;
                    select.parentNode.appendChild(label);


                },false);


                var div1 = document.createElement("DIV");
                div1.setAttribute("class","panel-heading");

                var div2 = document.createElement("DIV");
                div2.setAttribute("class","panel-collapse collapse");
                div2.setAttribute("id","d"+ card.id);
                div2.setAttribute("role","tabpanel");

                var a1 = document.createElement("A");
                a1.setAttribute("class","panel-title");
                a1.setAttribute("data-toggle","collapse");
                a1.setAttribute("data-parent","cardlist3");
                a1.setAttribute("href","#d"+card.id);
                a1.setAttribute("aria-expanded","false");
                a1.setAttribute("aria-controls","collapseOne");
                a1.innerHTML = card.name;

                var input = document.createElement("INPUT");
                input.setAttribute("type","checkbox");
                input.setAttribute("id",card.i);
                input.setAttribute("name",card.i);
                input.style.float = "right";

                //1/cards/"+card.id+"?fields=desc&attachments=true&token=a0fdcb022ad19ba6de1a849f4d325e9d8aedf95f086570718a3054d4e4bf4681
                //Overloop 1 kaartje en haal de data eruit
                Trello.get("/cards/"+card.id+"?fields=desc&attachments=true&token="+application_token,function(cardinfo)
                {
                    //ASYNC!!!
                    description.push(cardinfo.desc);
                    carddescription = cardinfo.desc; //gaat niet aangezien dit async verloopt
var carddesc = cardinfo.desc;
                    var klas = (carddesc).split("/n@")[3];
                    if(mnarray!=null){
                        if(mnarray.indexOf(klas)==-1){
                            mnarray.push(klas);
                        }

                    }else{
                        mnarray.push(klas);
                    }
                    var camp = klas.split(".")[0];
                    if(Z!=null){
                        if(mnarray2.indexOf(camp)==-1){
                            mnarray2.push(camp);
                        }

                    }else{
                        mnarray2.push(camp);
                    }
                    mijnteller++;
                    if(mijnteller==mijnstopsignaal){
                        console.log("gedaan");

                        $(function() {
                            $( "#Filter_Lokaal" ).autocomplete({
                                source: mnarray
                            });
                            $.each(mnarray2,function(ix,campussen){
                                var option = document.createElement("OPTION");
                                option.setAttribute("value",campussen);
                                option.innerHTML = campussen;
                                document.getElementById("Filter_Campussen").appendChild(option);
                            });


                        });

                    };


                    //kijkt naar de attachments en voegt de link toe in een array
                    $.each(cardinfo.attachments,function(ix,attachement){
                        attachementsarr.push(attachement.url);

                    });
                    var descriptionn = cardinfo.desc.split("/n@");
                    //console.log(descriptionn);

                    var label24 = document.createElement("LABEL");

                    $.each(descriptionn,function(ix,descript){
                        var descsplit = descript.split("@");
                        if(descsplit[0] == "AW")
                        {
                            //console.log("hahaha");
                            label24.innerHTML = descsplit[1];

                        }
                    });

                    var hasImage = false;
                    if (cardinfo.attachments.length > 0) {
                        //console.log(cardinfo.attachments[0].url);

                        var imageLink = document.createElement("img");
                        imageLink.src = cardinfo.attachments[0].url;
                        imageLink.className = "Card_Image";

                        hasImage = true;
                    }

                    var divclearfix = document.createElement("DIV");
                    divclearfix.setAttribute("Class","clearfix");

                    var p21 = document.createElement("P");
                    p21.setAttribute("Class","lokaal content");
                    p21.style.paddingTop = "10px";
                    p21.innerHTML = descriptionn[3];

                    var p22 = document.createElement("P");
                    p22.setAttribute("Class","campus content");
                    p22.innerHTML = "";

                    var div21 = document.createElement("DIV");
                    div21.setAttribute("Class","clearfix");

                    var p23 = document.createElement("P");
                    p23.setAttribute("Class","panel-body");
                    p23.innerHTML = descriptionn[0];

                    if(descriptionn[1]=="Niet Dringend"){li.classList.add("liBorderL");}
                    else if(descriptionn[1]=="Dringend"){li.classList.add("liBorderG");}
                    else if(descriptionn[1]=="Zeer Dringend"){li.classList.add("liBorderH");}

                    div2.appendChild(p21);
                    div2.appendChild(p22);
                    div2.appendChild(div21);
                    div2.appendChild(p23);
                    div2.appendChild(label24);
                    if (hasImage == true) {
                        div2.appendChild(imageLink);
                    }
                    div2.appendChild(divclearfix);
                    Filters("niks","/");
                });


                temparr.push(card.id,card.name,description,attachementsarr);
                //array met alle kaartjes in
                CardId.push(temparr);

                div1.appendChild(a1);
                div1.appendChild(input);
                li.appendChild(div1);
                li.appendChild(div2);
                selecteddiv.appendChild(li);




                //<li class="lastcard"><i class="fa fa-refresh"></i></li>
            });

            if(!izworker)
            {
                var liend = document.createElement("UL");
                liend.setAttribute("class","lastcard");
                var i = document.createElement("I");
                i.setAttribute("class","fa fa-refresh");
                liend.appendChild(i);

                selecteddiv.parentElement.appendChild(liend);

            }

            //console.log(CardId); //print de arrat met alle kaartjes of in de console

        });
    }
    //--------------------filter----------------------//
    var FilterSection=document.getElementById("SelectedFilters");
    function PriorityChange(value)
    {
        if(value != "Default")
        {
            makeDiv(value,"P");
            Filters(value,"P");
        }

    }
    function WorkerChange(value)
    {
        if(value != "Default")
        {
            makeDiv(value,"W");
            Filters(value,"W");
        }
    }
    function CampusChange(value)
    {
        if(value != "Default")
        {
            makeDiv(value, "C");
            Filters(value,"C");
        }
    }

    function makeDiv(name,idprefix)
    {
        var div = document.createElement("DIV");
        div.setAttribute("class","");
        div.setAttribute("Onclick","DeleteFilter(this)");
        div.setAttribute("id",idprefix+"/"+name);

        var label = document.createElement("LABEL");
        label.innerHTML = name;
        label.className = "ui blue large horizontal label";

        var icon = document.createElement("i");
        icon.className = "delete icon";

        label.appendChild(icon);
        div.appendChild(label);

        FilterSection.appendChild(div);

    }

    function TitelChange(value)
    {
        var TitelFilter = document.getElementById("TitelFilter");
        TitelFilter = TitelFilter.firstChild.nextSibling;
        TitelFilter.className = "ui blue large horizontal label";

        var icon = document.createElement("i");
        icon.className = "delete icon";

        TitelFilter.innerText = value;


        Filters("niks","/");
        TitelFilter.appendChild(icon);

        if (value == "") {
            TitelFilter.className = "";
            icon.className = "";
        }
    }
    function TitelRemove(element)
    {
        //console.log(element.firstChild.nextSibling);
        element.firstChild.nextSibling.innerHTML ="";
        element.firstChild.nextSibling.className = "";
        Filters("niks","/");
    }

    function LokaalChange(event,value)
    {
        var code = event.keyCode;
        if(code == 13)
        {
            //console.log(value);
            makeDiv(value,"L");
            Filters(value,"L");
        }


    }

    function Filters(el,ely) {
        var divs = FilterSection.getElementsByTagName("Div");
        var campusfilters = [];
        var priorityfilters = [];
        var workerfilters = [];
        var lokaalfilters = [];
        var filtered = [];

        for (var i = 1; i < divs.length; i++) {
            var filters = divs[i].id.split("/");
            if (filters[0] == "P") {
                priorityfilters.push(divs[i]);

            }
            else if (filters[0] == "C") {
                campusfilters.push(divs[i]);
            }
            else if (filters[0] == "W") {
                workerfilters.push(divs[i]);
            }

            else if (filters[0] == "L") {
                lokaalfilters.push(divs[i]);
            }
        }

        var workersUL = document.getElementById("Medewerkers").getElementsByTagName("UL");

        if (workerfilters.length <= 0) {
            SetWorkersVisible();
        }
        else {
            for (var i = 0; i < workersUL.length; i++) {
                workersUL[i].style.display = "none";
            }
        }

        var onhold = document.getElementById("OnHold").getElementsByTagName("LI");
        var voltooid = document.getElementById("Voltooid").getElementsByTagName("LI");
        var taken = document.getElementById("Taken").getElementsByTagName("LI");
        var workers = document.getElementById("Medewerkers").getElementsByTagName("LI");
        var blocks = [];
        for (var j = 0; j < onhold.length; j++) {
            blocks.push(onhold[j]);
        }
        for (var j = 0; j < voltooid.length; j++) {
            blocks.push(voltooid[j]);
        }
        for (var j = 0; j < taken.length; j++) {
            blocks.push(taken[j]);
        }
        for (var j = 0; j < workers.length; j++) {

            if (workers[j].firstChild.nextSibling.firstChild != null) {
                blocks.push(workers[j]);
            }
        }
        //allemaal afzetten

        for (var i = 0; i < blocks.length; i++) {
            blocks[i].style.display = "none";
        }

        for (var i = 1; i < divs.length; i++) {
            var filters = divs[i].id.split("/" +
            "");


            if (filters[0] == "W") {

                for (var j = 0; j < workersUL.length; j++) {
                    if (workersUL[j].firstChild.innerText == filters[1]) {
                        workersUL[j].style.display = "block";
                    }


                }
            }
        }

        for (var i = 0; i < priorityfilters.length; i++) {

            var priority;
            if (priorityfilters[i].id.split("/")[1] == "Niet Dringend") {
                priority = "liBorderL";
            }
            if (priorityfilters[i].id.split("/")[1] == "Dringend") {
                priority = "liBorderG";
            }
            else if (priorityfilters[i].id.split("/")[1] == "Zeer Dringend") {
                priority = "liBorderH";
            }


            for (var j = 0; j < blocks.length; j++) {
                if (blocks[j].className.split(" ")[3] == priority) {
                    //onhold[j].style.display="inline-block";
                    filtered.push(blocks[j]);
                }
            }

        }

        if (priorityfilters.length <= 0) {
            filtered = blocks;

        }


        var filtered1 = [];
        for (var i = 0; i < campusfilters.length; i++) {
            var filters = campusfilters[i].id.split("/");


            for (var j = 0; j < filtered.length; j++) {

                var campus = filtered[j].firstChild.nextSibling.firstChild.innerHTML.split(".")[0];


                if (campus == filters[1]) {

                    filtered1.push(filtered[j]);
                }
            }

        }

        var endfilterobjects;
        if (filtered1.length != 0) {
            endfilterobjects = filtered1;
        }
        else if (filtered.length != 0) {
            endfilterobjects = filtered;
        }
        else {
            endfilterobjects = blocks;
        }


        var TitelFilter = document.getElementById("TitelFilter");
        TitelFilter = TitelFilter.firstChild.nextSibling.innerHTML;

        var temptitel = [];
        for (var j = 0; j < endfilterobjects.length; j++) {
            var titel = endfilterobjects[j].firstChild.firstChild.innerText;
            titel = titel.toLowerCase();
            if (titel.indexOf(TitelFilter) > -1) {


                temptitel.push(endfilterobjects[j]);
            }
        }

        if (temptitel.length != 0) {
            endfilterobjects = temptitel;
        }
        var tempLokaal = [];
        for (var i = 0; i < lokaalfilters.length; i++) {

            for (var j = 0; j < endfilterobjects.length; j++) {

                var campus = endfilterobjects[j].firstChild.nextSibling.firstChild.innerHTML;
                //console.log(campus,lokaalfilters[i]);
                if (campus == lokaalfilters[i].id.split("/")[1]) {
                    tempLokaal.push(endfilterobjects[j]);

                }
            }
        }
        //console.log(tempLokaal);
        if (tempLokaal.length != 0)
        {
            endfilterobjects = tempLokaal;
        }

        for( var i = 0;i<endfilterobjects.length;i++)
        {
            endfilterobjects[i].style.display = "inline-block";
        }
        if(divs.length <=1)
        {
            var onhold = document.getElementById("OnHold").getElementsByTagName("LI");
            var voltooid = document.getElementById("Voltooid").getElementsByTagName("LI");
            var taken = document.getElementById("Taken").getElementsByTagName("LI");
            var workers = document.getElementById("Medewerkers").getElementsByTagName("LI");
            for(var j = 0;j<onhold.length;j++ )
            {
                onhold[j].style.display="inline-block";
            }
            for(var j = 0;j<voltooid.length;j++ )
            {
                voltooid[j].style.display="inline-block";

            }
            for(var j = 0;j<taken.length;j++ )
            {
                taken[j].style.display="inline-block";
            }
            for(var j = 0;j<workers.length;j++ )
            {
                if(workers[j].firstChild.nextSibling.firstChild!=null) {
                    workers[j].style.display = "inline-block";
                }
            }

            SetWorkersVisible();
        }
        Cookiefilter(el,ely);
    }

    function Cookiefilter(text,id){
        //maak cookie aan
        if(id=="/"){return;}
text = String(text);
        if( ""+text.indexOf('[object HTMLDivElement]') >= 0){
            // Found world
        }else{
            console.log("tesst");
            //maak cookie
            $.ajax({
                url: '../CookieMaker.php?val='+text+'/'+id,
                dataType: 'html',
                success: function(data){
                    //data returned from php
                  // window.open("../","_self");
                }
            });
        }

    }



    function SetWorkersVisible()
    {
        var workersUL = document.getElementById("Medewerkers").getElementsByTagName("UL");
        for(var j = 0;j<workersUL.length;j++ )
        {

            workersUL[j].style.display = "block";



        }
    }

    function DeleteFilter(element)
    {
        console.log(element);
        element.parentNode.removeChild(element);
     //   Filters(element);
var e = element.id;
        var x = e.split("/");

        $.ajax({
            url: '../CookieDeleter.php?val='+x[1],
            dataType: 'html',
            success: function(data){
Filters("niks","/");
                //data returned from php
                // window.open("../","_self");
            }
        });
    }
    var count;
    function PrintTasks(element,callback)
    {
        count = 0;
        var worker = element.parentNode.parentNode;
        var workertasks = worker.getElementsByTagName("li");

        var name = worker.firstChild.innerText;
        var listId = worker.id;

        var checkeds = 0;
        var tasks = [];
        for(var i = 1;i<workertasks.length;i++)
        {

            var checkbox = workertasks[i].firstChild.firstChild.nextSibling;
            if(checkbox.checked)
            {
                checkeds++;
                tasks.push(workertasks[i]);
            }
        }
       // console.log(checkeds);

        for(var i = 0;i<tasks.length;i++)
        {
            id = tasks[i].id;


            Trello.get("/cards/"+id+"?fields=desc&token="+application_token,function(cardinfo)
            {
                var niewedescription =  cardinfo.desc + "/n@W@"+name;

                //checkeds.push(workertasks[i].id);
                var id = workertasks[i].id;


                var descsplilt = cardinfo.desc.split("/n@");
                var found = false;
                $.each(descsplilt,function(ix,descpart) {
                    if (descpart.split("@")[0] == "W" && descpart.split("@")[1] == name)
                    {
                        console.log("tsta der al in");
                        count++;
                        found = true;
                        if(count == checkeds)
                        {
                            console.log("redirecting nu");
                            redirect(name);
                        }

                    }
                });
                if(!found)
                {
                    console.log("uitgevoerd");
                    SetTag(cardinfo.id,listId,niewedescription,checkeds,name);

                }

            });


        }


        //
       // window.open("../Afdrukpagina.php?Werkman="+name,"_self");

    }

    function SetTag(id,listId,nieuwedescription,lengte,naam)
    {
        Trello.put("/cards/"+id+"?key="+APP_KEY+"&token="+application_token+"&idList="+listId+"&desc="+nieuwedescription,function()
        {

            count++;
            console.log(id);
            //console.log(nieuwedescription);

            if(count == lengte)
            {

                redirect(naam);
            }
        });
    }
    function redirect(name)
    {
        console.log("redirect");
       window.open("../Afdrukpagina.php?Werkman="+name,"_self");
    }

    function CopyCard(value) {
        if (value.value != "Default")
        {
            var div = value.parentNode;
            var id = div.getElementsByTagName("label")[1].innerHTML;
            var li = document.getElementById(id);
            var temp = li.getElementsByTagName("label");
            console.log(temp);
            Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token="+application_token,function(lists)
            {

                $.each(lists["lists"],function(ix,list)
                {

                    if(list.name == value.value)
                    {
                        Trello.get("/cards/"+id+"?fields=desc&token="+application_token,function(cardinfo)
                        {
                            niewedescription = cardinfo.desc + "/n@AW@" + value.value;
                            console.log(niewedescription);
                            Trello.put("/cards/"+id+"?key="+APP_KEY+"&token="+application_token+"&desc="+niewedescription,function(){
                                Trello.post("/cards?idList="+list.id+"&idCardSource="+id+"&due=null&token="+application_token+"&key"+APP_KEY);
                            });
                        });
                        temp[0].innerText += " "+ value.value;
                        console.log(temp[0].innerText);

                    }
                });

            });
        }

    }


        /* Nieuwe code -> Bug moet nog opgelost worden 'mutable variable i'
         var divItem = document.createElement("div");
         divItem.className = "ui item";
         divItem.onclick = function (){CampusChange(campussen[i])};

         var option = document.createElement("OPTION");
         option.setAttribute("value", campussen[i]);
         option.setAttribute("name", campussen[i]);
         option.innerHTML = campussen[i];

         document.getElementById("Filter_Campussen").appendChild(divItem);
         divItem.appendChild(option);

         //console.log(divItem.childNodes[0].getAttribute("value"));
         //console.log(campussen[i]);*/

        /* OUDE CODE */

       // console.log(campussen[i]);

</script>

<?php
//connectie maken met db(mysql)
//local
//$mysqli = new mysqli('localhost', 'root', 'usbw', 'tasktool');
//$mysqli = new mysqli('mysqlstudent','cedriclecat','ooDohQuuo2uh','cedriclecat');
//student howest
$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');
if ($mysqli->connect_error)
{
    echo "Geen connectie mogelijk met de database";
}
$data = array();
?>


<script>    var arraymetlokalen =[]; var campussen=[]</script>
<?php
//alles ophalen en in array steken
//echo 'h';
$result = $mysqli->query("SELECT NAME FROM klassen");
while($row = $result->fetch_array(MYSQLI_ASSOC))
{
    ?>
    <script>
        //    console.log("h");
        var lokaal = <?php print "'".$row['NAME']."'" ?>;
        arraymetlokalen.push(lokaal);
        var campus = lokaal.split(".");
        //console.log(campus[0]);
        if(doesExist(campus[0]))
        {
            campussen.push(campus[0]);
        }
        function doesExist(name)
        {
            for(var i = 0;i<campussen.length;i++)
            {
                if(name == campussen[i])
                {
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

</body>
</html>