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
    //header("Location: ../"); // rol is niet juist => hack attempt

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
}
?>
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
    var a = '<?php print $row['DISABLED'] ?>';
    if(a=="1"){}else {
        lokalen.push(dat);
    }

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
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">


</head>
<body id="Lokalen">
<header>
    <a href="../Overzicht/index.php"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a onclick="afmelden(this)">Afmelden</a></button>
    <nav>
        <ul>
            <li><a href="../Meld_Defect/index.php">Probleem melden</a></li>
            <li><a href="../Overzicht_Takenlijst/">Overzicht takenlijst</a>
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
    <h1>Beheer lokalen</h1>

    <div onclick="myfunction(this)" id="Add_Lokaal" class="ui small primary labeled icon button">
        <i class="university icon"></i> Voeg een nieuw lokaal toe
    </div>

    <section id="Toevoegen">

        <p>Filter op lokalen:</p>

        <input type="text" name="Filter_Naam" id="Filter_Naam" placeholder="Naam lokaal" onkeyup="naamChange(this)" data-column="0"/>
        <i class="ui search icon"></i>
        <!-- <input type="text" name="Filter_Naam_Medewerker" id="Filter_Naam_Medewerker" placeholder="Naam medewerker.."/>-->
        <input type="text" name="Filter_email" id="Filter_email" placeholder="Omschrijving" onkeyup="omschrijvingChange(this)"
               data-column="1"/>
        <i class="ui search icon"></i>
        <input type="text" name="Filter_rechten" id="Filter_rechten" placeholder="Extra info"
               onkeyup="extrainfoChange(this)" data-column="2"/>
        <i class="ui search icon"></i>

        <div class="clearfix"></div>

    </section>
<script>
    function myfunction(thi){
        $('#modal_lokalen').addClass("scrolling"); // Verwijdert witte rand onderaan pop-up venster
        $('#modal_lokalen')
            .modal('setting', 'transition', 'scale')
            .modal('show');

    }
</script>


    <!-- Pop-up Window !-->
    <div id="modal_lokalen" class="ui test modal transition" style="z-index: 100000;">
        <!-- TODO: Close icon zoeken !-->
        <i id="close_Popup" class="close icon"></i>
        <div class="header">
            Lokaal toevoegen
        </div>
        <div class="content">
            <div class="left">
                <i id="Unief" class="university icon"></i>
            </div>
            <div class="right" id="Werknemer_Info">
                <input id="Naam_Lokaal" type="text" placeholder="Naam lokaal"/>
                <input id="Naam_Omschrijving" type="text" placeholder="Omschrijving"/>
                <input id="Info" type="text" placeholder="Info"/>


            </div>
            <div class="clearfix"></div>
        </div>
        <div class="actions">
            <div class="ui black button">
                Annuleer
            </div>
            <div onclick="myfunct(this)" id="btnOpslaan_Extern" class="ui positive right labeled icon button">
                Maak lokaal <i class="checkmark icon"></i>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<script>
    function myfunct(t){
     var l =   document.getElementById("Naam_Lokaal");
      var o =  document.getElementById("Naam_Omschrijving");
      var i =  document.getElementById("Info");
        mylink="../ChangeInst/NewLokal.php";

        var url = mylink+"?n="+ l.value+"&o="+ o.value+"&i="+ i.value;
        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
                var id = data.split("<p>");
  //              console.log(id);
//                console.log(id[1].split("</p>"));
                id = id[1].split("</p>")[0];

                maakitemlokaal(table,id, l.value, o.value, i.value,0);
                filterColumn(3,"");

            }
        });


    }
</script>

    <section class="geenmargintop" id="Tabel">
        <table id="DL">
            <thead>
            <tr>

                <th>Naam lokaal</th>
                <th>Omschrijving</th>
                <th>Extra info</th>
                <th>Bewerk</th>
            </tr>
            </thead>
            <tbody id="DynamicLokalen" class="display" cellspacing="0" width="70%">

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
        });


    $( document ).ready(function() { // voert de volgende data uit wanneer html is ingeladen
        //fillup();
        //fillupexternal();
        filluplokalen();
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

    // Lokaal filters
    naamlokaal = "";
    omschrijving = "";
    extrainfo = "";

    function naamChange(value)
    {
        if(value != "Default")
        {
            filterColumn(0,value.value );
        }
    };
    function omschrijvingChange(value)
    {
        if(value != "Default")
        {
            filterColumn( 1,value.value );
        }
    };
    function filterColumn ( i,myd ) {
        console.log( $('#DL').DataTable().column( i ));
        $('#DL').DataTable().column( i ).search(
            myd
        ).draw();
    }
    function extrainfoChange(value)
    {
        if(value != "Default")
        {
            filterColumn(2,value.value );

        }
    };

    function fillup(){

        console.log(ooTable);
        mnnr=0;
        table = document.getElementById('DynamicIntern');
        //verwijder alles in table

        var element = table.firstChild;

        while( element ) {
            table.removeChild(element);
            element = table.firstChild;
        }


        $.each(mydata,function(ix,ar){
            filnaam ="";
            filrol = "";
            $.each(ar,function(i,fill){
                if(i==0){
                    filnaam = fill;

                }else{
                    filrol = fill;
                }

            });


            a = filnaam.split('@');
            b = a[0];
            b = b.replace('.', ' ');
            /*
             if(check(b,naam)){ return;  } else{
             if(check(filnaam,email)){ return;  }else{
             if(check(filrol,rechten)){ return;  }else{*/
            //PASSED FILTERS
            maakitem(table,b,filnaam,filrol);
            // console.log('maak');
            /*     }
             }
             }*/
        });
        $('#DI')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered');

        ooTable = $('#DI').DataTable({
            "dom": '<"top">rt<"bottom"lp><"clear">'
        });
    }
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

    function maakitemlokaal(table, idnummering, naam, omschrijving, user_text_1, disabled){
        var tr =  document.createElement("tr");
        var tdd = document.createElement("td");

        tr.id = idnummering;
     //   var td0 = document.createElement("td");
      //  td0.appendChild(document.createTextNode(idnummering));
        var td1 = document.createElement("td");
        td1.appendChild(document.createTextNode(naam));
        var td2 = document.createElement("td");
        td2.appendChild(document.createTextNode(omschrijving));
        var td3 = document.createElement("td");
        td3.appendChild(document.createTextNode(user_text_1));
        var td4 = document.createElement("td");
        td4.appendChild(document.createTextNode(disabled));
        var td8 = document.createElement("td");

        var td6 = document.createElement("i");
        td6.className="write icon";
        td6.addEventListener("click",function() {
            //       dosomething(tr);
            dosomethinglokalen(tr);
            formmodified = 1;
        });
        var t1 = document.createElement("i");
        t1.className="remove icon";
        t1.addEventListener("click",function(){
            var result = confirm("Bent u zeker dat u dit item wilt verwijderen?");
            if (result) {
                deletelokalen(tr);
            }
        });

        td8.appendChild(td6);
        td8.appendChild(t1);
      //  tr.appendChild(td0);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td8);
        //table.appendChild(tr);
        //var newRow = "<tr><td>row 3, cell 1</td><td>row 3, cell 2</td></tr>";
        console.log(tr);

        if(oooTable!=null) {
            oooTable.row.add(tr).draw();
        }else{
            table.appendChild(tr);
        }

    }
    mnnrext = 0;



    function filluplokalen(){
        mnnrext=0;
        table = document.getElementById('DynamicLokalen');
        //verwijder alles in table

        var element = table.firstChild;

        while( element ) {
            table.removeChild(element);
            element = table.firstChild;
        }

        //console.log(lokalen);
        $.each(lokalen,function(ix,ar) {
            idnummering = "";
            naam = "";
            omschrijving = "";
            user_text_1 = "";
            disabled = "";
            $.each(ar, function (i, fill) {


                if (i == 0) {
                    idnummering = fill;

                } else if (i == 1) {
                    naam = fill;
                } else if (i == 2) {
                    omschrijving = fill;
                } else if (i == 3) {
                    user_text_1 = fill;
                } else if (i == 4) {
                    disabled = fill;
                }
            });
if(naam=="")return;
            if(naam==null)return;
            //PASSED FILTERS
            maakitemlokaal(table, idnummering, naam, omschrijving, user_text_1, disabled);
            // console.log('maak');


        });
        console.log("test");
        $('#DL')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered');
        oooTable = $('#DL').DataTable({
            "dom": '<"top">rt<"bottom"lp><"clear">'
        });

    }

    function filterColumnext ( i,myd ) {

        console.log( $('#DL').DataTable().column( i ));
        console.log(myd);
        $('#DL').DataTable().column( i ).search(
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


    function dosomethinglokalen(eml) {

        var tell = 0;
        //   console.log(eml.childElementCount);
        $.each(eml.childNodes,function(ix,a){

            //  console.log(ix);
            a = eml.childNodes[ix];
            if(ix==3){
                //  console.log("JA VIJF");
                var newicon = document.createElement("i");
                newicon.className = "save icon";
                newicon.addEventListener("click",function(){
                    saverowlokalen(eml);
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



    function saverowlokalen(el) {
        var myar = [];
        var aa="";
        aa=el.id;
        console.log("HIEREUEUHDFSDJFSDF");
        console.log(el);
        $.each(el.childNodes,function(ix,a){
            //  console.log(el.childNodes[ix]);
            //console.log(a);
if(ix==0){
    myar.push(el.id);
}
            if(ix==3){
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
            console.log("IK WIL T WETEN");
            console.log(t);
            myar.push(t);
            hoofdtd.appendChild(document.createTextNode(t));

            el.replaceChild(hoofdtd,el.childNodes[ix]);

        });
        oooTable.row(el).remove().draw();
        oooTable.row.add(el).draw();
        console.log(aa);
        mylink="../ChangeInst/Save_Lokaal.php";
        //   window.open('#','_blank');
//    window.open(this.href,'_self');
        // DOORSTUREN hieronder
        var url = mylink+"?IDNUMMERING="+myar[0]+"&NAME="+myar[1]+"&DESCRIPTION="+myar[2]+"&USER_TEXT_1="+myar[3];
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

        oooTable.row(trr).remove().draw();
        $('#DL').DataTable().column(3).search(
            ""
        ).draw();
    }
</script>
