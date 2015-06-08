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
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <!--!-->
    <script src="../js/scripts.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

</head>
<body>
<script>$(document).ready(function() {
        $('#example').dataTable();
    } );</script>
<header>
    <a href="../Overzicht/index.html"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a href="../index.php">Afmelden</a></button>
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

            <p>Zoeken op internal: </p>

                <input type="text" name="Filter_Naam" id="Filter_Naam" placeholder="Naam" onkeyup="naamChange(this.value)" />
                <!-- <input type="text" name="Filter_Naam_Medewerker" id="Filter_Naam_Medewerker" placeholder="Naam medewerker.."/>-->
                <input type="text" name="Filter_email" id="Filter_email" placeholder="email" onkeyup="emailChange(this.value)" />
                <input type="text" name="Filter_rechten" id="Filter_rechten" placeholder="rechten" onkeyup="rechtenChange(this.value)" />
            <div class="clearfix"></div>
            <p>Zoeken op external: </p>

            <input type="text" name="Filter_eNaam" id="Filter_eNaam" placeholder="Naam" onkeyup="naamChangeext(this.value)" />
            <input type="text" name="Filter_ebedrijf" id="Filter_ebedrijf" placeholder="bedrijf" onkeyup="bedrijfChangeext(this.value)" />
            <input type="text" name="Filter_eadres" id="Filter_eadres" placeholder="adres" onkeyup="adresChangeext(this.value)" />
            <input type="text" name="Filter_etel" id="Filter_etel" placeholder="telefoon" onkeyup="telChangeext(this.value)" />
            <input type="text" name="Filter_eemail" id="Filter_eemail" placeholder="email" onkeyup="emailChangeext(this.value)" />

            <div class="clearfix"></div>
            <div id="Add_Werknemer" class="ui small primary labeled icon button">
                <i class="user icon"></i> Voeg werknemer toe
            </div>

            <div id="Add_Externe_Werknemer" class="ui small primary labeled icon button">
                <i class="user icon"></i> Voeg externe werknemer toe
            </div>
            <div class="clearfix"></div>
        </section>


        <section id="Tabel">
            <table id="example" class="display" cellspacing="0" width="70%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Salary</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>$170,750</td>
                </tr>
                <tr>
                    <td>Ashton Cox</td>
                    <td>Junior Technical Author</td>
                    <td>San Francisco</td>
                    <td>$86,000</td>
                </tr>
                <tr>
                    <td>Cedric Kelly</td>
                    <td>Senior Javascript Developer</td>
                    <td>Edinburgh</td>
                    <td>$433,060</td>
                </tr>
                <tr>
                    <td>Airi Satou</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>$162,700</td>
                </tr>
                <tr>
                    <td>Brielle Williamson</td>
                    <td>Integration Specialist</td>
                    <td>New York</td>
                    <td>$372,000</td>
                </tr>
                <tr>
                    <td>Herrod Chandler</td>
                    <td>Sales Assistant</td>
                    <td>San Francisco</td>
                    <td>$137,500</td>
                </tr>
                <tr>
                    <td>Rhona Davidson</td>
                    <td>Integration Specialist</td>
                    <td>Tokyo</td>
                    <td>$327,900</td>
                </tr>
                <tr>
                    <td>Colleen Hurst</td>
                    <td>Javascript Developer</td>
                    <td>San Francisco</td>
                    <td>$205,500</td>
                </tr>
                <tr>
                    <td>Sonya Frost</td>
                    <td>Software Engineer</td>
                    <td>Edinburgh</td>
                    <td>$103,600</td>
                </tr>
                <tr>
                    <td>Jena Gaines</td>
                    <td>Office Manager</td>
                    <td>London</td>
                    <td>$90,560</td>
                </tr>
                <tr>
                    <td>Quinn Flynn</td>
                    <td>Support Lead</td>
                    <td>Edinburgh</td>
                    <td>$342,000</td>
                </tr>
                <tr>
                    <td>Charde Marshall</td>
                    <td>Regional Director</td>
                    <td>San Francisco</td>
                    <td>$470,600</td>
                </tr>
                <tr>
                    <td>Haley Kennedy</td>
                    <td>Senior Marketing Designer</td>
                    <td>London</td>
                    <td>$313,500</td>
                </tr>
                <tr>
                    <td>Tatyana Fitzpatrick</td>
                    <td>Regional Director</td>
                    <td>London</td>
                    <td>$385,750</td>
                </tr>
                <tr>
                    <td>Michael Silva</td>
                    <td>Marketing Designer</td>
                    <td>London</td>
                    <td>$198,500</td>
                </tr>
                <tr>
                    <td>Paul Byrd</td>
                    <td>Chief Financial Officer (CFO)</td>
                    <td>New York</td>
                    <td>$725,000</td>
                </tr>
                <tr>
                    <td>Gloria Little</td>
                    <td>Systems Administrator</td>
                    <td>New York</td>
                    <td>$237,500</td>
                </tr>
                <tr>
                    <td>Bradley Greer</td>
                    <td>Software Engineer</td>
                    <td>London</td>
                    <td>$132,000</td>
                </tr>
                <tr>
                    <td>Dai Rios</td>
                    <td>Personnel Lead</td>
                    <td>Edinburgh</td>
                    <td>$217,500</td>
                </tr>
                <tr>
                    <td>Jenette Caldwell</td>
                    <td>Development Lead</td>
                    <td>New York</td>
                    <td>$345,000</td>
                </tr>
                <tr>
                    <td>Yuri Berry</td>
                    <td>Chief Marketing Officer (CMO)</td>
                    <td>New York</td>
                    <td>$675,000</td>
                </tr>
                <tr>
                    <td>Caesar Vance</td>
                    <td>Pre-Sales Support</td>
                    <td>New York</td>
                    <td>$106,450</td>
                </tr>
                <tr>
                    <td>Doris Wilder</td>
                    <td>Sales Assistant</td>
                    <td>Sidney</td>
                    <td>$85,600</td>
                </tr>
                <tr>
                    <td>Angelica Ramos</td>
                    <td>Chief Executive Officer (CEO)</td>
                    <td>London</td>
                    <td>$1,200,000</td>
                </tr>
                <tr>
                    <td>Gavin Joyce</td>
                    <td>Developer</td>
                    <td>Edinburgh</td>
                    <td>$92,575</td>
                </tr>
                <tr>
                    <td>Jennifer Chang</td>
                    <td>Regional Director</td>
                    <td>Singapore</td>
                    <td>$357,650</td>
                </tr>
                <tr>
                    <td>Brenden Wagner</td>
                    <td>Software Engineer</td>
                    <td>San Francisco</td>
                    <td>$206,850</td>
                </tr>
                <tr>
                    <td>Fiona Green</td>
                    <td>Chief Operating Officer (COO)</td>
                    <td>San Francisco</td>
                    <td>$850,000</td>
                </tr>
                <tr>
                    <td>Shou Itou</td>
                    <td>Regional Marketing</td>
                    <td>Tokyo</td>
                    <td>$163,000</td>
                </tr>
                <tr>
                    <td>Michelle House</td>
                    <td>Integration Specialist</td>
                    <td>Sidney</td>
                    <td>$95,400</td>
                </tr>
                <tr>
                    <td>Suki Burks</td>
                    <td>Developer</td>
                    <td>London</td>
                    <td>$114,500</td>
                </tr>
                <tr>
                    <td>Prescott Bartlett</td>
                    <td>Technical Author</td>
                    <td>London</td>
                    <td>$145,000</td>
                </tr>
                <tr>
                    <td>Gavin Cortez</td>
                    <td>Team Leader</td>
                    <td>San Francisco</td>
                    <td>$235,500</td>
                </tr>
                <tr>
                    <td>Martena Mccray</td>
                    <td>Post-Sales support</td>
                    <td>Edinburgh</td>
                    <td>$324,050</td>
                </tr>
                <tr>
                    <td>Unity Butler</td>
                    <td>Marketing Designer</td>
                    <td>San Francisco</td>
                    <td>$85,675</td>
                </tr>
                <tr>
                    <td>Howard Hatfield</td>
                    <td>Office Manager</td>
                    <td>San Francisco</td>
                    <td>$164,500</td>
                </tr>
                <tr>
                    <td>Hope Fuentes</td>
                    <td>Secretary</td>
                    <td>San Francisco</td>
                    <td>$109,850</td>
                </tr>
                <tr>
                    <td>Vivian Harrell</td>
                    <td>Financial Controller</td>
                    <td>San Francisco</td>
                    <td>$452,500</td>
                </tr>
                <tr>
                    <td>Timothy Mooney</td>
                    <td>Office Manager</td>
                    <td>London</td>
                    <td>$136,200</td>
                </tr>
                <tr>
                    <td>Jackson Bradshaw</td>
                    <td>Director</td>
                    <td>New York</td>
                    <td>$645,750</td>
                </tr>
                <tr>
                    <td>Olivia Liang</td>
                    <td>Support Engineer</td>
                    <td>Singapore</td>
                    <td>$234,500</td>
                </tr>
                <tr>
                    <td>Bruno Nash</td>
                    <td>Software Engineer</td>
                    <td>London</td>
                    <td>$163,500</td>
                </tr>
                <tr>
                    <td>Sakura Yamamoto</td>
                    <td>Support Engineer</td>
                    <td>Tokyo</td>
                    <td>$139,575</td>
                </tr>
                <tr>
                    <td>Thor Walton</td>
                    <td>Developer</td>
                    <td>New York</td>
                    <td>$98,540</td>
                </tr>
                <tr>
                    <td>Finn Camacho</td>
                    <td>Support Engineer</td>
                    <td>San Francisco</td>
                    <td>$87,500</td>
                </tr>
                <tr>
                    <td>Serge Baldwin</td>
                    <td>Data Coordinator</td>
                    <td>Singapore</td>
                    <td>$138,575</td>
                </tr>
                <tr>
                    <td>Zenaida Frank</td>
                    <td>Software Engineer</td>
                    <td>New York</td>
                    <td>$125,250</td>
                </tr>
                <tr>
                    <td>Zorita Serrano</td>
                    <td>Software Engineer</td>
                    <td>San Francisco</td>
                    <td>$115,000</td>
                </tr>
                <tr>
                    <td>Jennifer Acosta</td>
                    <td>Junior Javascript Developer</td>
                    <td>Edinburgh</td>
                    <td>$75,650</td>
                </tr>
                <tr>
                    <td>Cara Stevens</td>
                    <td>Sales Assistant</td>
                    <td>New York</td>
                    <td>$145,600</td>
                </tr>
                <tr>
                    <td>Hermione Butler</td>
                    <td>Regional Director</td>
                    <td>London</td>
                    <td>$356,250</td>
                </tr>
                <tr>
                    <td>Lael Greer</td>
                    <td>Systems Administrator</td>
                    <td>London</td>
                    <td>$103,500</td>
                </tr>
                <tr>
                    <td>Jonas Alexander</td>
                    <td>Developer</td>
                    <td>San Francisco</td>
                    <td>$86,500</td>
                </tr>
                <tr>
                    <td>Shad Decker</td>
                    <td>Regional Director</td>
                    <td>Edinburgh</td>
                    <td>$183,000</td>
                </tr>
                <tr>
                    <td>Michael Bruce</td>
                    <td>Javascript Developer</td>
                    <td>Singapore</td>
                    <td>$183,000</td>
                </tr>
                <tr>
                    <td>Donna Snider</td>
                    <td>Customer Support</td>
                    <td>New York</td>
                    <td>$112,000</td>
                </tr>
                </tbody>
            </table>

            <h2>Beheer rechten van personeel</h2>

            <div class="container">
                <div class="row">
                    <h3 class="ib" >Werknemers van Howest</h3> <p id="hideintern" class="ib ibb" onclick="hideint(this)">hide/show</p>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Naam</th>
                    <th>E-mail adres</th>
                    <th>Rechten</th>
                    <th>Bewerk</th>
                </tr>
                </thead>
                <tbody id="DynamicIntern">
                <!--<tr>
                    <td>John Lilki</td>
                    <td>jhlilk22@yahoo.com</td>
                    <td>Docent</td>
                </tr>
                -->
                </tbody>
                                       </table>
                    </div>
                    <div class="col-md-12 text-center">
                        <ul class="pagination" id="myPager"></ul>
                    </div>
                </div>
            </div>

                        <div class="container">
                            <div class="row">
                                <h3 class="ib">Externe werknemers</h3> <p id="hideextern" class="ib ibb" onclick="hideext(this)">hide/show</p>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Naam bedrijf</th>
                    <th>Adres</th>
                    <th>Telefoon nr.</th>
                    <th>E-mail adres</th>
                    <th>bewerk</th>
                </tr>
                </thead>
                <tbody id="DynamicExtern">
               <!--- <tr>
                    <td>John Lilki</td>
                    <td>September 14, 2013</td>
                    <td>jhlilk22@yahoo.com</td>
                    <td>jhlilk22@yahoo.com</td>
                    <td>Docent</td>
                </tr>
                -->
                </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 text-center">
                                    <ul class="pagination" id="myPagerext"></ul>
                                </div>
                            </div>
                        </div>
        </section>
    </main>
</body>
</html>
<script>
$( document ).ready(function() { // voert de volgende data uit wanneer html is ingeladen
    /*var hi = document.getElementById("hideintern");
     var he = document.getElementById("hideextern");
     */$('#DynamicIntern').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:15});
    $('#Dynamicextern').pageMe({pagerSelector:'#myPagerext',showPrevNext:true,hidePageNumbers:false,perPage:15});
    /*var di = 0;
     var dx = 0;
     hi.addEventListener("click",function(){
     var ge = document.getElementById("DynamicIntern");
     if(di==0){di=1;ge.display="none";}
     if(di==1){di=0;ge.display="block";}


     });

     he.addEventListener("click",function(){
     var ge = document.getElementById("DynamicExtern");
     if(di==0){di=1;ge.display="none";}
     if(di==1){di=0;ge.display="block";}


     });

     */

    fillup();
    fillupexternal();
});
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);

    var listElement = $this;
    var perPage = settings.perPage;
    var children = listElement.children();
    var pager = $('.pagination');

    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }

    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }

    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);

    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }

    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }

    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }

    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
    pager.children().eq(1).addClass("active");

    children.hide();
    children.slice(0, perPage).show();

    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });

    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }

    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }

    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;

        children.css('display','none').slice(startAt, endOn).show();

        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }

        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }

        pager.data("curr",page);
        pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");

    }
};



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
//script dat voor ervoor zorgt dat filters werken op en data wordt ingeladen
    //array met data =  mydata

  //  console.log(mydata); // Array[0] => array[0] naam array[1] rol
//filter
   naam = "";
    email = "";
    rechten ="";
enaam ="";ebedrijf="";eadres="";etel="";eemail="";

    function naamChange(value)
    {
        if(value != "Default")
        {
           // makeDiv(value,"P");
            //Filters();
            naam = value.replace(/\s/g, '');
            fillup();
        }
            };
function emailChange(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        email = value.replace(/\s/g, '');
        fillup();
    }
};
function rechtenChange(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        rechten = value.replace(/\s/g, '');
        fillup();
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

if(check(b,naam)){ return;  } else{
    if(check(filnaam,email)){ return;  }else{
 if(check(filrol,rechten)){ return;  }else{
        //PASSED FILTERS
maakitem(table,b,filnaam,filrol);
           // console.log('maak');
        }
        }
}
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
        firsttd.appendChild(document.createTextNode(mnnr));
      tr.appendChild(firsttd);
        mnnr++;

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
    tdd.appendChild(document.createTextNode(mnnrext));
    tr.appendChild(tdd);
    mnnrext++;

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
    var td6 = document.createElement("i");
    td6.className="write icon";
    td6.addEventListener("click",function() {
 //       dosomething(tr);
        dosomethingext(tr);

    });


    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);
    tr.appendChild(td6);
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


        //a = filnaam.split('@');
        // b = a[0];
        // b = b.replace('.', ' ');


        if (check(fnaam, enaam)) {
            return;
        } else {
            if (check(fbedrijf, ebedrijf)) {
                return;
            } else {
                if (check(fadres, eadres)) {
                    return;
                } else {
                    if (check(ftel, etel)) {
                        return;
                    } else {
                        if (check(femail, eemail)) {
                            return;
                        } else {
                        }
                        //PASSED FILTERS
                        maakitemexternal(table,fnaam,fbedrijf,fadres,ftel,femail,fid);
                        // console.log('maak');
                    }
                }
            }
        }


    });
}
function naamChangeext(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        enaam = value.replace(/\s/g, '');
        fillupexternal();
    }
};
function bedrijfChangeext(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        ebedrijf = value.replace(/\s/g, '');
        fillupexternal();
    }
};
function adresChangeext(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        eadres = value.replace(/\s/g, '');
        fillupexternal();
    }
};
function telChangeext(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        etel = value.replace(/\s/g, '');
        fillupexternal();
    }
};
function emailChangeext(value)
{
    if(value != "Default")
    {
        // makeDiv(value,"P");
        //Filters();
        eemail = value.replace(/\s/g, '');
        fillupexternal();
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
<script type="text/javascript">
    // For demo to fit into DataTables site builder...
    $('#example')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered');
</script>