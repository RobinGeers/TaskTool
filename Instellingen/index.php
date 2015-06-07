<script>
    mydata= [];

</script>

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
<script>
    dat = [];
    dat.push('<?php print $row['userPrincipalName'];?>');
dat.push('<?php print $row['ROL'] ?>');
mydata.push(dat);
</script>


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
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
</head>
<body>
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

            <p>Zoeken op: </p>

                <input type="text" name="Filter_Naam" id="Filter_Naam" placeholder="Naam" onkeyup="naamChange(this.value)" />
                <!-- <input type="text" name="Filter_Naam_Medewerker" id="Filter_Naam_Medewerker" placeholder="Naam medewerker.."/>-->
                <input type="text" name="Filter_email" id="Filter_email" placeholder="email" onkeyup="emailChange(this.value)" />
                <input type="text" name="Filter_rechten" id="Filter_rechten" placeholder="rechten" onkeyup="rechtenChange(this.value)" />
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
            <h2>Beheer rechten van personeel</h2>
            <h3>Werknemers van Howest</h3>
            <table class="ui table">
                <thead>
                <tr>
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
                <tr>
                    <td>Jamie Harington</td>
                    <td>jamieharingonton@yahoo.com</td>
                    <td>Werknemer</td>
                </tr>
                <tr>
                    <td>Jill Lewis</td>
                    <td>jilsewris22@yahoo.com</td>
                    <td>Onthaal</td>
                </tr>
                <tr>
                    <td>Jill Lewis</td>
                    <td>jilsewris22@yahoo.com</td>
                    <td>Admin</td>
                </tr>

                -->
                </tbody>
            </table>
            <h3>Externe werknemers</h3>
            <table class="ui table table2">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Naam bedrijf</th>
                    <th>Adres</th>
                    <th>Telefoon nr.</th>
                    <th>E-mail adres</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>John Lilki</td>
                    <td>September 14, 2013</td>
                    <td>jhlilk22@yahoo.com</td>
                    <td>jhlilk22@yahoo.com</td>
                    <td>Docent</td>
                </tr>
                <tr>
                    <td>Jamie Harington</td>
                    <td>January 11, 2014</td>
                    <td>jamieharingonton@yahoo.com</td>
                    <td>jamieharingonton@yahoo.com</td>
                    <td>Werknemer</td>
                </tr>
                <tr>
                    <td>Jill Lewis</td>
                    <td>May 11, 2014</td>
                    <td>May 11, 2014</td>
                    <td>jilsewris22@yahoo.com</td>
                    <td>Onthaal</td>
                </tr>
                <tr>
                    <td>Jill Lewis</td>
                    <td>Jill Lewis</td>
                    <td>May 11, 2014</td>
                    <td>jilsewris22@yahoo.com</td>
                    <td>Admin</td>
                </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
<script>
//script dat voor ervoor zorgt dat filters werken op en data wordt ingeladen
    //array met data =  mydata
$( document ).ready(function() { // voert de volgende data uit wanneer html is ingeladen
fillup();
});
  //  console.log(mydata); // Array[0] => array[0] naam array[1] rol
//filter
   naam = "";
    email = "";
    rechten ="";

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
            console.log('maak');
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
  //  var found = $.inArray('specialword', categories) > -1;

       // console.log(char.indexOf(b) != -1);
        if(res.indexOf(b) != -1){
            console.log("ja");
           gelijk = 1;
       }

   // });
if(gelijk ==0){return true;}
    return false;
}
    function maakitem(table, naam, Email, Rechten){
      var tr =  document.createElement("tr");
      var td1 = document.createElement("td");
    td1.appendChild(document.createTextNode(naam));
      var td2 = document.createElement("td");
        td2.appendChild(document.createTextNode(Email));
      var td3 = document.createElement("td");
        td3.appendChild(document.createTextNode(Rechten));
   tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        table.appendChild(tr);
    }





</script>