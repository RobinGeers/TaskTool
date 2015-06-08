<script>
    mydata= [];
    myexternaldata = [];


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
    <script src="../js/scripts.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
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
    <main id="Instellingen">
        <h1>Instellingen</h1>
        <section id="Toevoegen">

            <p>Zoeken op interne werknemer: </p>

                <input type="text" name="Filter_Naam" id="Filter_Naam" placeholder="Naam" onkeyup="naamChange(this)"  data-column="0" />
                <!-- <input type="text" name="Filter_Naam_Medewerker" id="Filter_Naam_Medewerker" placeholder="Naam medewerker.."/>-->
                <input type="text" name="Filter_email" id="Filter_email" placeholder="email" onkeyup="emailChange(this)" data-column="1" />
                <input type="text" name="Filter_rechten" id="Filter_rechten" placeholder="rechten" onkeyup="rechtenChange(this)"  data-column="2" />
            <div class="clearfix"></div>
            <p>Zoeken op externe werknemer: </p>

            <input type="text" name="Filter_eNaam" id="Filter_eNaam" placeholder="Naam" onkeyup="naamChangeext(this)" />
            <input type="text" name="Filter_ebedrijf" id="Filter_ebedrijf" placeholder="bedrijf" onkeyup="bedrijfChangeext(this)" />
            <input type="text" name="Filter_eadres" id="Filter_eadres" placeholder="adres" onkeyup="adresChangeext(this)" />
            <input type="text" name="Filter_etel" id="Filter_etel" placeholder="telefoon" onkeyup="telChangeext(this)" />
            <input type="text" name="Filter_eemail" id="Filter_eemail" placeholder="email" onkeyup="emailChangeext(this)" />

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

            <h2>Beheer rechten van personeel</h2>


            <h3 class="ib">Werknemers van Howest</h3>

            <a id="hideintern" class="ib ibb" onclick="hideint(this)">Hide/Show</a>


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


            <h3 class="ib">Externe werknemers</h3>

            <a id="hideextern" class="ib ibb" onclick="hideext(this)">Hide/Show</a>

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
    </main>
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
    $('.dropdown')
        .dropdown({
            // you can use any ui transition
            transition: 'drop'
        })
    ;

    /*document.getElementById("Add_Werknemer").addEventListener("click", function(){

        // Indien transition niet werkt -> Bootstrap link wegdoen
      /*  $('#modal_intern').addClass("scrolling"); // Verwijdert witte rand onderaan pop-up venster
        $('#modal_intern')
            .modal('setting', 'transition', 'scale')
            .modal('show');*/

    //}, false);

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

        id++;
        mylink="https://student.howest.be/robin.geers/TaskTool/ChangeInst/djfqs5dfqs5df46qsd4.php";

        var url = mylink+"?naam="+naamWerknemer+"&bedrijf="+naamBedrijf+"&adres="+adres+"&tel="+telNr+"&email="+emailAdres;
        //
        window.open(url, "s", "width=10, height= 10, left=0, top=0, resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no").blur();
        window.focus();
        maakitemexternal(table, naamWerknemer, naamBedrijf, adres, telNr, emailAdres, id);

    });


$( document ).ready(function() { // voert de volgende data uit wanneer html is ingeladen

    fillup();
    fillupexternal();
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

    $('#DI').dataTable({
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
        table.appendChild(tr);
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
    var td4 = document.createElement("i");
    td4.className="write icon";
    td4.addEventListener("click",function() {
        dosomething(el);

    });
    el.replaceChild(td4,el.childNodes[3]);
    var td3 = document.createElement("td");
    td3.appendChild(document.createTextNode(selectedvalue));
    el.replaceChild(td3,el.childNodes[2]);
    mylink="https://student.howest.be/wouter.dumon/test4/ChangeInst/a2fjo4(dsf558sdf.php";
 //   window.open('#','_blank');
//    window.open(this.href,'_self');

    var url = mylink+"?naam="+naam+"&rol="+selectedvalue;
    window.open(url, "s", "width=10, height= 10, left=0, top=0, resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no").blur();
    window.focus();




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

td8.appendChild(td6);
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);
    tr.appendChild(td8);
    table.appendChild(tr);
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
    $('#DE').dataTable({

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
   /// console.log(eml);
    //var naam = el.childNodes[1].innerText;
  //  console.log(eml.firstChild);
  //  console.log(eml.childNodes);
  //  $.each(eml.childNodes,function(ix,a){
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

function saverowext(el){
    var myar = [];
    var aa="";
    aa=el.id;
   // console.log(el);
    $.each(el.childNodes,function(ix,a){
      //  console.log(el.childNodes[ix]);
        //console.log(a);
        if(ix==5){
            var td4 = document.createElement("i");
            td4.className="write icon";
            td4.addEventListener("click",function() {
                dosomethingext(el);

            });
            el.replaceChild(td4,el.childNodes[ix]);
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
    mylink="https://student.howest.be/wouter.dumon/test4/ChangeInst/sdfjl5dfqs9fdsf4.php";
    //   window.open('#','_blank');
//    window.open(this.href,'_self');
    var url = mylink+"?naam="+myar[0]+"&bedrijf="+myar[1]+"&adres="+myar[2]+"&tel="+myar[3]+"&email="+myar[4]+"&id="+aa;
  //
   window.open(url, "s", "width=10, height= 10, left=0, top=0, resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no").blur();
    window.focus();
}
</script>
