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
}?>
<script>
    mydata= [];
    myexternaldata = [];
    lokalen = [];

</script>

<script>
    <?php

    $mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

    //controleren op fouten
    //echo "h";
    if ($mysqli->connect_error)
    {
        echo "Geen connectie mogelijk met de database";
    }
    $dataint = array();
    $dataext = array();

    $result = $mysqli->query("SELECT id,Naam, NaamBedrijf, Adres, Telefoon, Emailadres FROM external");

    //print $_COOKIE['inlognaam'];
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>

    dat = [];
    dat.push('<?php print $row['Naam'];?>');
    dat.push('<?php print $row['NaamBedrijf'] ?>');
    dat.push('<?php print $row['Adres'] ?>');
    dat.push('<?php print $row['Telefoon'] ?>');
    dat.push('<?php print $row['Emailadres'] ?>');
    dat.push('<?php print $row['id'] ?>');
    myexternaldata.push(dat);

    <?php
}

//connectie sluiten
$mysqli->close();


$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
if ($mysqli->connect_error)
{
    echo "Geen connectie mogelijk met de database";
}
$dataint = array();
$dataext = array();

$result = $mysqli->query("SELECT userPrincipalName,ROL FROM EmailsLeerkrachten");

//print $_COOKIE['inlognaam'];
while($row = $result->fetch_array(MYSQLI_ASSOC))
{

    //kijken of hij wel toegang hier heeft

    if($row['userPrincipalName']==$_COOKIE['inlognaam']) {
    switch ($row['ROL']) {
        case 'Basic':
            //mag alleen op meld defect
            header('Location: ../Meld_Defect');
            break;
        case 'Werkman':
            $naam = explode('.', $bericht);

            header('Location: ../Afdrukpagina.php?Werkman=' . $naam[0]);
            break;
        case 'Onthaal':
            header('Location: ../Overzicht');
            break;
        case 'Admin':
            //header('Location: ../Overzicht');
            break;
    }
}



?>

    dat = [];
    dat.push('<?php print $row['userPrincipalName'];?>');
    dat.push('<?php print $row['ROL'] ?>');
    mydata.push(dat);



    <?php


  // print_r($row['NAME']);
  // array_push($data['merken'],$row);
}
/*print_r($dataint);
print 'en /n ';
print_r($dataext);*/
//connectie sluiten
$mysqli->close();
?>

    // Tabel met lokalen
    <?php

    $mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

    //controleren op fouten
    //echo "h";
    if ($mysqli->connect_error)
    {
    echo "Geen connectie mogelijk met de database";
    }
    $dataint = array();
    $dataext = array();
    $result = $mysqli->query("SELECT IDNUMMERING, NAME, DESCRIPTION, USER_TEXT_1, DISABLED FROM klassen");
    //print $_COOKIE['inlognaam'];
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    ?>
    dat = [];
    dat.push('<?php print $row['IDNUMMERING'];?>');
    dat.push('<?php print $row['NAME'] ?>');
    dat.push('<?php print addslashes($row['DESCRIPTION']) ?>');
    dat.push('<?php print $row['USER_TEXT_1'] ?>');
    dat.push('<?php print $row['DISABLED'] ?>');
    lokalen.push(dat);

    <?php
    }

    //connectie sluiten
    $mysqli->close();
    ?>

</script>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Instellingen</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!--!-->
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/screen.css"/>

</head>
<body id="Extern">
<header>
    <a href="../Overzicht/index.php"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a onclick="afmelden(this)">Afmelden</a></button>
    <nav>
        <ul>
            <li><a href="../Meld_Defect/index.php">Probleem melden</a></li>
            <li><a id="second" href="../Overzicht_Takenlijst/">Overzicht takenlijst</a>
                <ul class="gotop">
                    <li><a href="../Overzicht_Takenlijst_Grid/index.php">Tabel weergave</a></li>
                    <li><a href="../Overzicht_Takenlijst/index.php">Kaartjes weergave</a></li>
                </ul>
            </li>
            <li><a href="../Statistieken/index.php">Statistieken</a></li>
            <li><a href="../Instellingen_Overzicht/index.php" class="instellingen">Instellingen</a>
            <ul class="gotop">
                <li><a href="../Instellingen_Interne_Werknemers/index.php">Interne werknemers</a></li>
                <li><a href="../Instellingen_Externe_Werknemers/index.php">Onderaannemers</a></li>
                <li><a href="../Instellingen_Lokalen/index.php">Lokalen</a></li>
            </ul>
            </li>
        </ul>
    </nav>
    <p id="Ingelogd">U bent ingelogd als: <span><?php print $_SESSION["loggedin"] ?></span></p>
    <div class="clearfix"></div>
</header>
<main id="Instellingen_Extern">

    <h1>Beheer onderaannemers</h1>

    <section id="Toevoegen">

        <div id="Add_Externe_Werknemer" class="ui small primary labeled icon button">
            <i class="user icon"></i>Onderaannemer toevoegen
        </div>
        <div class="clearfix"></div>
    </section>



    <!-- Pop-up Window !-->
    <div id="modal_extern" class="ui test modal transition" style="z-index: 100000;">
        <!-- TODO: Close icon zoeken !-->
        <i id="close_Popup" class="close icon"></i>
        <div class="header">
            Nieuwe onderaannemer toevoegen
        </div>
        <div class="content">
            <div class="left">
                <i id="Onderaannemer" class="user icon"></i>
            </div>
            <div class="right" id="Werknemer_Info">
                <input id="Naam_Werknemer" type="text" placeholder="Naam onderaannemer"/>
                <input id="Naam_Bedrijf" type="text" placeholder="Naam bedrijf"/>
                <input id="Adres" type="text" placeholder="Adres"/>
                <input id="Tel_Nr" type="text" placeholder="Telefoon nr."/>
                <input id="E-mail_Adres" type="text" placeholder="E-mail adres"/>

            </div>
            <div class="clearfix"></div>
        </div>
        <div class="actions">
            <div class="ui black button">
                Annuleer
            </div>
            <div id="btnOpslaan_Extern" class="ui positive right labeled icon button">
                Voltooien <i class="checkmark icon"></i>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    <section id="Tabel">

        <section id="Filters_Extern">
            <p>Filter op onderaannemers: </p>

            <input type="text" name="Filter_eNaam" id="Filter_eNaam" placeholder="Naam" onkeyup="naamChangeext(this)" />
            <i class="ui search icon"></i>
            <input type="text" name="Filter_ebedrijf" id="Filter_ebedrijf" placeholder="Bedrijf" onkeyup="bedrijfChangeext(this)" />
            <i class="ui search icon"></i>
            <input type="text" name="Filter_eadres" id="Filter_eadres" placeholder="Adres" onkeyup="adresChangeext(this)" />
            <i class="ui search icon"></i>
            <input type="text" name="Filter_etel" id="Filter_etel" placeholder="Telefoon" onkeyup="telChangeext(this)" />
            <i class="ui search icon"></i>
            <input type="text" name="Filter_eemail" id="Filter_eemail" placeholder="E-mail" onkeyup="emailChangeext(this)" />
            <i class="ui search icon"></i>
        </section>

        <div class="clearfix"></div>

        <table id="DE">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Naam bedrijf</th>
                <th>Adres</th>
                <th>Telefoon nr.</th>
                <th>E-mail adres</th>
                <th>Bewerk</th>
            </tr>
            </thead>
            <tbody id="DynamicExtern" class="display" cellspacing="0" width="70%">

            </tbody>
        </table>
    </section>
    <div class="clearfooter"></div>
</main>

<footer>
    <p>Vragen? Mail naar <a href="mailto:helpdesk@howest.be">helpdesk@howest.be</a> of download <a href="">hier</a> de handleiding</p>
</footer>
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

    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    function createlist(naam){
        naam = naam.split("@")[0];
        var TrelloLists = [];
        var SelectedList = "";
        console.log("test");
        Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name&token=" + application_token, function (lists) {
            console.log("test2");
            console.log(lists);
            console.log(naam);
            $.each(lists["lists"], function (ix, list) {
                var List = [];
                //  console.log(ix); is gelijk aan de int i = 0 van de for lus
                List.push(list.id, list.name); // in list zitten de parameters van de lijsten dus in ons geval hebben we het id en naam nodig
                console.log(list.id + "/"+list.name);
                if (list.name.includes(naam)) {
                    SelectedList = list.id; //kijken of de naam die meegeven is in del ink voorkomt in in de lijst namen
//    console.log(SelectedList);
                }
                TrelloLists.push(List);//Voeg de array list toe aan de array TrelloList
            });
            console.log(TrelloLists);
            // console.log("sel=" + SelectedList);
            if(SelectedList=="") {
                //console.log("juist");
                Trello.post("/lists?name=" + naam + "&idBoard=5506dbf5b32e668bde0de1b3&&token=" + application_token, function () {

                    //console.log("gelukt2");
                });
            }
        });
    }
    function deletelist(naam){
        naam = naam.split("@")[0];
        var TrelloLists = [];
        var SelectedList = "";
        console.log("test");
        Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name&token=" + application_token, function (lists) {
            console.log("test2");
            console.log(lists);
            console.log(naam);
            $.each(lists["lists"], function (ix, list) {
                var List = [];
                //  console.log(ix); is gelijk aan de int i = 0 van de for lus
                List.push(list.id, list.name); // in list zitten de parameters van de lijsten dus in ons geval hebben we het id en naam nodig
                console.log(list.id + "/"+list.name);
                if (list.name.includes(naam)) {
                    SelectedList = list.id; //kijken of de naam die meegeven is in del ink voorkomt in in de lijst namen
//    console.log(SelectedList);
                }
                TrelloLists.push(List);//Voeg de array list toe aan de array TrelloList
            });
            //console.log(TrelloLists);
            // console.log("sel=" + SelectedList);
            if(SelectedList!="") {

                //console.log("juist");
                Trello.post("/lists/"+SelectedList+"/moveAllCards?&idBoard=5506dbf5b32e668bde0de1b3&idList=5506dbf5b32e668bde0de1b4&token=" + application_token, function () {
                    console.log("juist: "+SelectedList);
                    Trello.put("/lists/"+SelectedList+"/closed?value=true&token=" + application_token, function () {

                        //console.log("gelukt2");
                    });
                    //console.log("gelukt2");
                });
            }
        });
    }
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
    $('.dropdown')
        .dropdown({
            // you can use any ui transition
            transition: 'drop'
        })
    ;


    document.getElementById("Add_Externe_Werknemer").addEventListener("click", function(){

        // Indien transition niet werkt -> Bootstrap link wegdoen
        $('#modal_extern').addClass("scrolling"); // Verwijdert witte rand onderaan pop-up venster
        $('#modal_extern')
            .modal('setting', 'transition', 'scale')
            .modal('show');

    }, false);

    var id = 3;
    document.getElementById("btnOpslaan_Extern").addEventListener("click", function(){

        var table = document.getElementById("DynamicExtern");
        var naamWerknemer = document.getElementById("Naam_Werknemer").value;
        var naamBedrijf  = document.getElementById("Naam_Bedrijf").value;
        var adres = document.getElementById("Adres").value;
        var telNr = document.getElementById("Tel_Nr").value;
        var emailAdres = document.getElementById("E-mail_Adres").value;
        //var rechten = document.getElementById("").value;
        naamWerknemer = naamWerknemer.replace(/\s+/g,".");
        id++;
        mylink="../ChangeInst/djfqs5dfqs5df46qsd4.php";

        var url = mylink+"?naam="+naamWerknemer+"&bedrijf="+naamBedrijf+"&adres="+adres+"&tel="+telNr+"&email="+emailAdres;
        //
        /*   window.open(url, "s", "width=10, height= 10, left=0, top=0, resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no").blur();*/

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
                var id = data.split("<p>");
                console.log(id);
                console.log(id[1].split("</p>"));
                id = id[1].split("</p>")[0];

                maakitemexternal(table, naamWerknemer, naamBedrijf, adres, telNr, emailAdres, id);
                createlist(naamWerknemer);

            }
        });

    });


    $( document ).ready(function() { // voert de volgende data uit wanneer html is ingeladen
        //fillup();
        fillupexternal();
        //filluplokalen();
        $.getScript("https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385", function(){
            console.log("script here");
        });

    });

    var de = 0;
    var di=0;
    function hideint(x){

        var ge = document.getElementById("DynamicIntern");
        if(de==0){de=1;ge.style.display="none"; }else if(de==1){de=0;ge.style.display="";}


    }
    function hideext(x){
        var ge = document.getElementById("DynamicExtern");
        if(di==0){di=1;ge.style.display="none";}else if(di==1){di=0;ge.style.display="";}
    }

    //filter
    naam = "";
    email = "";
    rechten ="";
    enaam ="";ebedrijf="";eadres="";etel="";eemail="";

    function naamChange(value)
    {
        if(value != "Default")
        {
            filterColumn(0,value.value );
        }
    };
    function emailChange(value)
    {
        if(value != "Default")
        {
            filterColumn( 1,value.value );
        }
    };
    function filterColumn ( i,myd ) {
        console.log( $('#DI').DataTable().column( i ));
        $('#DI').DataTable().column( i ).search(
            myd
        ).draw();
    }
    function rechtenChange(value)
    {
        if(value != "Default")
        {
            filterColumn(2,value.value );

        }
    };


    function check(a,b){
        b = b.toLowerCase();
        //console.log(a);
        var res = a.toLowerCase();
        res = res.replace(' ', '');
        res = res.replace('.', '');
//var z = res.split('');
        var gelijk = 0;
        //  console.log(z);
        //   console.log(z);
        //  $.each(z,function(ix,char){
        // console.log(char);
        // console.log(char.indexOf(b) != -1);
        if(res.indexOf(b) != -1){
            //  console.log("ja");
            gelijk = 1;
        }

        // });
        if(gelijk ==0){return true;}
        return false;
    }
    mnnr = 0;




    function maakitemexternal(table, naam, naambedrjf, adres, telefoon,email,id){
        var tr =  document.createElement("tr");
        var tdd = document.createElement("td");

        console.log(id);
        tr.id = id;
        var td1 = document.createElement("td");
        td1.appendChild(document.createTextNode(naam));
        var td2 = document.createElement("td");
        td2.appendChild(document.createTextNode(naambedrjf));
        var td3 = document.createElement("td");
        td3.appendChild(document.createTextNode(adres));
        var td4 = document.createElement("td");
        td4.appendChild(document.createTextNode(telefoon));
        var td5 = document.createElement("td");
        td5.appendChild(document.createTextNode(email));
        var td8 = document.createElement("td");

        var td6 = document.createElement("i");
        td6.className="write icon";
        td6.addEventListener("click",function() {
            //       dosomething(tr);
            dosomethingext(tr);

        });
        var t1 = document.createElement("i");
        t1.className="remove icon";
        t1.addEventListener("click",function(){
            var result = confirm("Bent u zeker dat u dit item wilt verwijderen?");
            if (result) {
                deleteext(tr);
            }
        });

        td8.appendChild(td6);
        td8.appendChild(t1);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td8);
        //table.appendChild(tr);
        //var newRow = "<tr><td>row 3, cell 1</td><td>row 3, cell 2</td></tr>";
        console.log(tr);

        if(oTable!=null) {
            oTable.row.add(tr).draw();
        }else{
            table.appendChild(tr);
        }

    }


    mnnrext = 0;

    function fillupexternal(){
        mnnrext=0;
        table = document.getElementById('DynamicExtern');
        //verwijder alles in table

        var element = table.firstChild;

        while( element ) {
            table.removeChild(element);
            element = table.firstChild;
        }

        console.log(myexternaldata);
        $.each(myexternaldata,function(ix,ar) {
            fnaam = "";
            fbedrijf = "";
            fadres = "";
            ftel = "";
            femail = "";
            fid="";
            $.each(ar, function (i, fill) {


                if (i == 0) {
                    fnaam = fill;

                } else if (i == 1) {
                    fbedrijf = fill;
                } else if (i == 2) {
                    fadres = fill;
                } else if (i == 3) {
                    ftel = fill;
                } else if (i == 4) {
                    femail = fill;
                }else if(i==5){
                    fid=fill;
                }

            });

            //PASSED FILTERS
            maakitemexternal(table,fnaam,fbedrijf,fadres,ftel,femail,fid);
            // console.log('maak');


        });
        console.log("test");
        $('#DE')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered');
        oTable = $('#DE').DataTable({
            "dom": '<"top">rt<"bottom"lp><"clear">'
        });

    }



    function filterColumnext ( i,myd ) {

        console.log( $('#DE').DataTable().column( i ));
        console.log(myd);
        $('#DE').DataTable().column( i ).search(
            myd
        ).draw();
    }
    function naamChangeext(value)
    {
        if(value != "Default")
        {
            filterColumnext(0,value.value);
        }
    };
    function bedrijfChangeext(value)
    {
        if(value != "Default")
        {
            filterColumnext(1,value.value);
        }
    };
    function adresChangeext(value)
    {
        if(value != "Default")
        {
            filterColumnext(2,value.value);
        }
    };
    function telChangeext(value)
    {
        if(value != "Default")
        {
            filterColumnext(3,value.value);
        }
    };
    function emailChangeext(value)
    {
        if(value != "Default")
        {
            filterColumnext(4,value.value);
        }
    };

    function dosomethingext(eml){

var ol = eml.childNodes[0].innerText;
        var tell = 0;
        //   console.log(eml.childElementCount);
        $.each(eml.childNodes,function(ix,a){

            //  console.log(ix);
            a = eml.childNodes[ix];
            if(ix==5){
                //  console.log("JA VIJF");
                var newicon = document.createElement("i");
                newicon.className = "save icon";
                newicon.addEventListener("click",function(){
                    saverowext(eml,ol);
                    formmodified = 0;
                });
                eml.replaceChild(newicon,eml.childNodes[ix]);
                return;
            }
            var hoofdtd = document.createElement("td");

            var t = a.innerText;
            var i = document.createElement("input");
            i.type ="text";
            i.name="inputs[]";
            i.id="inputs"+ix;
            i.setAttribute('value', 'default');
            //i.addEventListener('keyup',function(val){i.value=val.value;  });
            i.value = t;
            hoofdtd.appendChild(i);
            eml.replaceChild(hoofdtd,eml.childNodes[ix]);
//console.log(eml.childNodes[ix]);
        });

    }



    function saverowext(el,old){

        var myar = [];
        var aa="";
        aa=el.id;
        // console.log(el);
        $.each(el.childNodes,function(ix,a){
            //  console.log(el.childNodes[ix]);
            //console.log(a);
            if(ix==5){
                var tdd = document.createElement("td");
                var td4 = document.createElement("i");
                td4.className="write icon";
                td4.addEventListener("click",function() {
                    dosomethingext(el);
                    formmodified = 1;
                });
                var t1 = document.createElement("i");
                t1.className="remove icon";
                t1.addEventListener("click",function(){

                    deleteext(tr);
                });
                tdd.appendChild(td4);
                tdd.appendChild(t1);
                el.replaceChild(tdd,el.childNodes[ix]);
                return;
            }

            var hoofdtd = document.createElement("td");

            //  console.log(el.childNodes[ix]);
            var t =  el.childNodes[ix].firstChild.value;

          //  console.log(t);
            myar.push(t);
            hoofdtd.appendChild(document.createTextNode(t));

            el.replaceChild(hoofdtd,el.childNodes[ix]);

        });
        oTable.row(el).remove().draw();
   //     console.log("hhhhh");
        var ntr = document.createElement("tr");

        oTable.row.add(el).draw();
   //     console.log("HIERBOVEN");

     //   console.log(aa);
        mylink="../ChangeInst/sdfjl5dfqs9fdsf4.php";
        //   window.open('#','_blank');
//    window.open(this.href,'_self');
        var url = mylink+"?naam="+myar[0]+"&bedrijf="+myar[1]+"&adres="+myar[2]+"&tel="+myar[3]+"&email="+myar[4]+"&id="+aa;
        //
        //  window.open(url, "s", "width=10, height= 10, left=0, top=0, resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no").blur();
        //   window.focus();
        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
            }
        });

        //TODO: hier put naar trello indien veranderd
//old oude naam van lijst
        console.log(el.childNodes[0]);
        if (old != el.childNodes[0].innerText) {
            var res = el.childNodes[0].innerText;
            res = res.replace(' ', '.');
var r = old.replace(' ','.');
            console.log("NIET HETZELFDE");
            Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token=" + application_token + "", function (lists) {
                $.each(lists["lists"], function (ix, list) {
console.log(list.name + "/" + r);
                    if (list.name.toLowerCase() == r.toLowerCase()) {
                        console.log("ja");
                        Trello.put("/lists/" + list.id + "?key=" + APP_KEY + "&token=" + application_token + "&name=" + res + "");//&desc=is verzet
                    }

                });
            });

        } else {
            console.log("HETZELFDE");
        }
        /* */
    }

   /* function saverowlokalen(el) {
        var myar = [];
        var aa="";
        aa=el.id;
        console.log("HIEREUEUHDFSDJFSDF");
        console.log(el);
        $.each(el.childNodes,function(ix,a){
            //  console.log(el.childNodes[ix]);
            //console.log(a);
            if(ix==4){
                var tdd = document.createElement("td");
                var td4 = document.createElement("i");
                td4.className="write icon";
                td4.addEventListener("click",function() {
                    dosomethinglokalen(el);
//HIER
                });
                var t1 = document.createElement("i");
                t1.className="remove icon";
                t1.addEventListener("click",function(){
                    deletelokalen(el);
                });
                tdd.appendChild(td4);
                tdd.appendChild(t1);
                el.replaceChild(tdd,el.childNodes[ix]);
                return;
            }

            var hoofdtd = document.createElement("td");

            //  console.log(el.childNodes[ix]);
            var t =  el.childNodes[ix].firstChild.value;

            console.log(t);
            myar.push(t);
            hoofdtd.appendChild(document.createTextNode(t));

            el.replaceChild(hoofdtd,el.childNodes[ix]);

        });

        console.log(aa);
        mylink="../ChangeInst/sdfjl5dfqs9fdsf4.php";
        //   window.open('#','_blank');
//    window.open(this.href,'_self');
        var url = mylink+"?naam="+myar[0]+"&bedrijf="+myar[1]+"&adres="+myar[2]+"&tel="+myar[3]+"&email="+myar[4]+"&id="+aa;
        //
        //  window.open(url, "s", "width=10, height= 10, left=0, top=0, resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no").blur();
        //   window.focus();
        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
            }
        });
    }*/
    function deleteext(trr){

        mylink="../ChangeInst/bcfgnlqjr5dfj45.php";
        console.log(trr.id);
        var url = mylink+"?id="+trr.id;

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
            }
        });

        var a = document.getElementById("DynamicExtern");
        deletelist(trr.childNodes[0].innerText);

        oTable.row(trr).remove().draw();
        $('#DE').DataTable().column(0).search(
            ""
        ).draw();
        //console.log(trr.childNodes[0].innerText);
        // console.log(trr.childNodes[0]);
    }

    function deletelokalen(trr) {
        mylink="../ChangeInst/Delete_lokaal.php";
        console.log(trr.id);
        var url = mylink+"?id="+trr.id;

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
            }
        });

        var a = document.getElementById("DynamicLokalen");
        deletelist(trr.childNodes[0].innerText);

        oTable.row(trr).remove().draw();
        $('#DL').DataTable().column(0).search(
            ""
        ).draw();
    }
</script>
