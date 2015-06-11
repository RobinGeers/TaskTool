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
    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <!--!-->
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
<body>
<header>
    <a href="../Overzicht/index.html"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a onclick="afmelden(this)">Afmelden</a></button>
    <nav>
        <ul>
            <li><a href="../Meld_Defect/index.php">Probleem melden</a></li>
            <li><a href="../Overzicht_Takenlijst/index.php">Overzicht takenlijst</a></li>
            <li><a href="../Statistieken/index.html">Statistieken</a></li>
            <li><a href="#">Instellingen</a></li>
        </ul>
    </nav>
    <div class="clearfix"></div>
</header>
<main id="Instellingen_Extern">
    <h1>Beheer interne werknemers</h1>

    <div id="Breadcrumb" class="ui breadcrumb">
        <a class="section" href="../Overzicht/index.html">Overzicht</a>
        <i class="right chevron icon divider"></i>
        <a class="section" href="../Instellingen_Overzicht/index.html">Instellingen</a>
        <i class="right chevron icon divider"></i>
        <div class="active section">Interne werknemers</div>
    </div>
    <section id="Toevoegen">

        <p>Filter op interne werknemer: </p>

        <input type="text" name="Filter_Naam" id="Filter_Naam" placeholder="Naam" onkeyup="naamChange(this)" data-column="0"/>
        <i class="ui search icon"></i>
        <!-- <input type="text" name="Filter_Naam_Medewerker" id="Filter_Naam_Medewerker" placeholder="Naam medewerker.."/>-->
        <input type="text" name="Filter_email" id="Filter_email" placeholder="E-mail" onkeyup="emailChange(this)"
               data-column="1"/>
        <i class="ui search icon"></i>
        <input type="text" name="Filter_rechten" id="Filter_rechten" placeholder="Rechten"
               onkeyup="rechtenChange(this)" data-column="2"/>
        <i class="ui search icon"></i>

        <div class="clearfix"></div>

        <!--<div id="Add_Werknemer" class="ui small primary labeled icon button">
            <i class="user icon"></i> Update werknemer
        </div>!-->

        <div id="Add_Externe_Werknemer" class="ui small primary labeled icon button">
            <i class="user icon"></i> Voeg externe werknemer toe
        </div>
        <div class="clearfix"></div>
    </section>



    <!-- Pop-up Window !-->
    <div id="modal_extern" class="ui test modal transition" style="z-index: 100000;">
        <!-- TODO: Close icon zoeken !-->
        <i id="close_Popup" class="close icon"></i>
        <div class="header">
            Werknemer toevoegen
        </div>
        <div class="content">
            <div class="left">
                <img src="../images/Howest_Logo.png" alt="Howest Logo"/>
            </div>
            <div class="right" id="Werknemer_Info">
                <input id="Naam_Werknemer" type="text" placeholder="Naam werknemer"/>
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
                Maak werknemer <i class="checkmark icon"></i>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    <section id="Tabel">

        <table id="DI">
            <thead>
            <tr>
                <th>Naam</th>
                <th>E-mail adres</th>
                <th>Rechten</th>
                <th>Bewerk</th>
            </tr>
            </thead>
            <tbody id="DynamicIntern" class="display" cellspacing="0" width="70%">

            </tbody>
        </table>

    </section>
</main>
</body>
</html>
<script>
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
        fillup();
        //fillupexternal();
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
    function maakitem(table, naam, Email, Rechten){
        var tr =  document.createElement("tr");
        var firsttd = document.createElement("td");
        //      firsttd.appendChild(document.createTextNode(mnnr));
//      tr.appendChild(firsttd);
//        mnnr++;

        var td1 = document.createElement("td");
        td1.appendChild(document.createTextNode(naam));
        var td2 = document.createElement("td");
        td2.appendChild(document.createTextNode(Email));
        var td3 = document.createElement("td");
        td3.appendChild(document.createTextNode(Rechten));
        var td4 = document.createElement("td");
        var iWrite = document.createElement("i");

        iWrite.className="write icon";
        iWrite.addEventListener("click",function() {
            dosomething(tr);

        });


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        td4.appendChild(iWrite);
        //   table.appendChild(tr);
//   ooTable.row.add(tr).draw();
        // console.log(ooTable.row);
        if(ooTable!=null) {
            ooTable.row.add(tr).draw();
        }else{
            table.appendChild(tr);
        }
    }

    function dosomething(eml){
        console.log(eml);

        console.log(eml.firstChild);
        console.log(eml.childNodes);
        var hoofdtd = document.createElement("td");
        var select = document.createElement("select");
        // select.addEventListener('change',function(){checkbox(this.value)});
        var nu =  eml.childNodes[2].innerText;

        var option1 = document.createElement("option"); option1.appendChild(document.createTextNode("Basic")); option1.value = "Basic";
        var option2 = document.createElement("option"); option2.appendChild(document.createTextNode("Onthaal")); option2.value="Onthaal";
        var option3 = document.createElement("option"); option3.appendChild(document.createTextNode("Admin")); option3.value = "Admin";
        var option4 = document.createElement("option"); option4.appendChild(document.createTextNode("Werkman")); option4.value = "Werkman";

        switch(nu){
            case 'Basic': option1.selected = true; break;
            case 'Werkman': option4.selected = true; break;
            case 'Admin': option3.selected = true; break;
            case 'Onthaal': option2.selected = true; break;
            default: break;

        }
        //  td1.innerText = "test";
        select.appendChild(option1);
        select.appendChild(option4);
        select.appendChild(option2);
        select.appendChild(option3);
        hoofdtd.appendChild(select);
        eml.replaceChild(hoofdtd,eml.childNodes[2]);
        var newicon = document.createElement("i");
        newicon.className = "save icon";
        newicon.addEventListener("click",function(){
            saverow(eml);
        });
        eml.replaceChild(newicon,eml.childNodes[3]);
        //table = document.getElementById('DynamicIntern');
        /* $.each(eml.childNodes,function(ix, array){
         console.log(ix + "  " + array.htm);
         });*/

    }

    function saverow(el){
        var selectedvalue= el.childNodes[2].firstChild.value;
        var naam = el.childNodes[1].innerText;
        var tdd = document.createElement("td");
        var td4 = document.createElement("i");
        td4.className="write icon";
        td4.addEventListener("click",function() {
            dosomething(el);

        });
        tdd.appendChild(td4);
        el.replaceChild(tdd,el.childNodes[3]);
        var td3 = document.createElement("td");
        td3.appendChild(document.createTextNode(selectedvalue));
        el.replaceChild(td3,el.childNodes[2]);
        mylink="../ChangeInst/a2fjo4(dsf558sdf.php";
        if(selectedvalue=="Werkman"){
            console.log(selectedvalue);
            createlist(naam);
        }else{
            //todo: DELETE EVENTUELE LIST
            deletelist(naam);
        }
        var url = mylink+"?naam="+naam+"&rol="+selectedvalue;

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data){
                //data returned from php
                console.log("Gelukt");
            }
        });



    }

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

            deleteext(tr);
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

    function maakitemlokaal(table, idnummering, naam, omschrijving, user_text_1, disabled){
        var tr =  document.createElement("tr");
        var tdd = document.createElement("td");

        tr.id = idnummering;
        var td0 = document.createElement("td");
        td0.appendChild(document.createTextNode(idnummering));
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

        });
        var t1 = document.createElement("i");
        t1.className="remove icon";
        t1.addEventListener("click",function(){

            deleteext(tr);
        });

        td8.appendChild(td6);
        td8.appendChild(t1);
        tr.appendChild(td0);
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
                    saverowext(eml);
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

    function dosomethinglokalen(eml) {

        var tell = 0;
        //   console.log(eml.childElementCount);
        $.each(eml.childNodes,function(ix,a){

            //  console.log(ix);
            a = eml.childNodes[ix];
            if(ix==4){
                //  console.log("JA VIJF");
                var newicon = document.createElement("i");
                newicon.className = "save icon";
                newicon.addEventListener("click",function(){
                    saverowlokalen(eml);
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

    function saverowext(el){
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
//HIER
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
    }
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
