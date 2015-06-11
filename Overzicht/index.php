<?php
session_start();
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if(isset($_SESSION['loggedin'])){
$ber = $_SESSION['loggedin'];
}else {
    header("Location: ../");
}
$rol = $_COOKIE["rol"];


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

$result = $mysqli->prepare("SELECT ROL FROM EmailsLeerkrachten where userPrincipalName =?");
$result->bind_param('s', $ber);
$result->execute();
$result->bind_result($data);
$d = array();
while($result->fetch()){
    array_push($d,$data);
};
echo "<br>";
//print $data;
$ha =  md5("exteralayersecuresalt".$data);
echo "<br>";
print $ha;
echo "<br>";
print $ha; print " === "; print $rol;
if($ha==$rol){
    //GOED
    print $data;
}else{
header("Location: ../");
}

//connectie sluiten
$mysqli->close();

switch($data){
    case 'Basic':
        //header("Location:../");

       // $naam = explode('@', $bericht);
      //  header('Location: ../Afdrukpagina.php?Werkman=' . $naam[0]);

        break;
    case 'Werkman':
       // header("../Werkman");
        break;
    case 'Onthaal':
      //  header('Location: ../Overzicht');
        //connectie sluiten
        //$results->close();
        break;
    case 'Admin':
        //header('Location: ../Overzicht');
        //connectie sluiten
        //$results->close();
        break;
}



?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Overzicht</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
</head>
<body>
    <header>
        <a href="#"></a><img src="../images/howestlogo.png" alt="Howest Logo"/>
        <button><a onclick="afmelden(this)">Afmelden</a></button>

        <div class="clearfix"></div>
    </header>

    <main id="Overzicht">
        <h1>Overzicht</h1>
        <div><a id="first" href="../Meld_Defect/index.php"><i class="fa fa-bell"></i><p>Meld een defect</p></a></div>
        <div><a id="second" href="../Overzicht_Takenlijst/index.php"><i class="fa fa-list-ul"></i><p>Overzicht takenlijst</p></a></div>
        <div><a id="third" href="../Statistieken/index.php"><i class="fa fa-line-chart"></i><p>Statistieken</p></a></div>
        <!--<div><a id="fourth" href="../Afdrukpagina.php?Werkman=cedric"><i class="fa fa-cogs"></i><p>Instellingen</p></a></div>!-->
        <div><a id="fourth" href="../Instellingen_Overzicht/index.html"><i class="fa fa-cogs"></i><p>Instellingen</p></a></div>
        <div class="clearfix"></div>
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
        </script>