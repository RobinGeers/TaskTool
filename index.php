<?php
session_start();
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
if(isset($_SESSION['loggedin']))
{
    header('Location: ./Meld_Defect/index.php');
     //echo "session gevonden";
}

$errormessage = "";
if(isset($_GET['data'])){ $var = $_GET['data']; }
if(isset($_GET['error'])){ $errormessage = $_GET['error'];  $errormessage =  str_replace("1"," ",$errormessage); }

//$var is hier een nummer dat terug keert hier kun je dan errormessages terug tonen aan de hand van dit vb 1 => gelukt 2=> fail ....
//if($errormessage!=""){
/*
 * // Provides: <body text='black'>
$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
 * */



?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8"> </meta>

      <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <title>
        Login - Howest Tasktool
    </title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script>
        $( document ).ready(function() {
            $(".transitions").click(function(){
                $("body").fadeOut(1000);
            });
        });
    </script>

    <link rel="stylesheet" href="css/screen.css" media="screen"/>


</head>
<body id="Body_Login">
<main id="LoginFormulier">
<a href="./Overzicht/index.html"><img src="images/howestlogo.png" alt="Howest Logo"/></a>
    <section id="Login">
        <h1>TaskTool login</h1>
        <form action="./Meld_Defect/index.php" method="POST" id="form">
            <input id="txtEmailadres" type="email" name="txtEmailadres" placeholder="Emailadres" required value="<?php
            if(isset($_COOKIE['inlognaam'])){
                print $_COOKIE['inlognaam'];
            }
            ?>" autofocus tabindex="1">

            <input id="txtWachtwoord" type="Password" name="txtWachtwoord" placeholder="Wachtwoord"  required tabindex="2">
            <input type="checkbox" name="chkHouIngelogd" id="chkHouIngelogd" <?php
            if(isset($_COOKIE['inlognaam'])){
                print "checked";
            }

            ?> value="ingelogd">
            <label for="chkHouIngelogd">Onthoud mij</label>
            <label style="color:red"><?php print $errormessage ?></label>
            <input type="submit" value="Login" name="btnLogin" id="btnLogin" tabindex="8" class="transitions" onclick="doorsturen(event)">
        </form>
    </section>
</main>
<script>
    function doorsturen(b)
    {
        b.preventDefault();


        setTimeout(doSubmit, 800);
    }

    function doSubmit() {
        document.getElementById('form').submit();
    }
</script>
</body>
</html>