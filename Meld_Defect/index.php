<?php
session_start();
$thiss = getcwd();
chdir("../");
$t = getcwd();
$a = $t . '/PHPMailer-master/class.phpmailer.php';
chdir($thiss);
$target = "";
$isfoto = 0;
$test = "";
require_once($a);
if (isset($_POST['txtEmailadres'])) {
    $bericht = $_POST['txtEmailadres'];
    //  print "'hhhh'";
    if (isset($_POST['txtWachtwoord'])) {
        echo "hhh";
        $pw = $_POST['txtWachtwoord'];

        $link = ldap_connect('hogeschool-wvl.be'); // Your domain or domain server

        if (!$link) {
            //GEEN TOEGANG TOT DE LDAP SERVER!!!!!
            session_destroy();
            header('Location: ../index.php?error=geen1toegang1tot1Active1Directory');
            echo "mis";
            // Could not connect to server - handle error appropriately
        }

        ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3); // Recommended for AD

// Now try to authenticate with credentials provided by user
        if (!ldap_bind($link, $bericht, $pw)) {
            // Invalid credentials! Handle error appropriately
            echo "error";
            session_destroy();

            header('Location: ../index.php?error=Foute1Inlog1Gegevens');
        } else {
            echo " goed";


            $mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
            if ($mysqli->connect_error) {
                echo "Geen connectie mogelijk met de database";
            }
            $data = "";


            $result = $mysqli->prepare("SELECT userPrincipalName,ROL FROM EmailsLeerkrachten where userPrincipalName =?");
            echo "goed";
            $result->bind_param('s', $bericht);
            print $bericht;
            $result->execute();
            echo "goedsd";
            $resul = $result->bind_result($data);
            echo "goed";
            //  while ($row = $resul->fetch_assoc()) {

            /*      // use your $myrow array as you would with any other fetch
                  printf("%s is in district %s\n", $city, $myrow['district']);

              }
  while($row = $result->fetch_array(MYSQLI_ASSOC))
  {*/
            print $data;


            //cookie aanmaken
            setcookie("rol", hash('sha256', $data), time() + 25920000);
            print("gelukt");
            print hash('sha256', $data);
            //cookie verwijderen
            //  setcookie("rol", "", time()-3600);

            switch ($data) {
                case 'Basic':
                    //mag alleen op meld defect
                    break;
                case 'Werkman':
                    $naam = explode('.', $bericht);

                    header('Location: ../Afdrukpagina.php?Werkman=' . $naam[0]);
                    break;
                case 'Onthaal':
                    header('Location: ../Overzicht');
                    break;
                case 'Admin':
                    header('Location: ../Overzicht');
                    break;
            }
            // print_r($row['NAME']);
            // array_push($data['merken'],$row);
//}
//connectie sluiten
            $mysqli->close();


        }
// Bind was successful - continue


    }


    $_SESSION['loggedin'] = $bericht;
//indien emailadres bestaat 100% kans dat je van login pagina komt en niet refresht ofzo
    if (isset($_POST['chkHouIngelogd'])) {
        //cookie aanmaken
        setcookie("inlognaam", $bericht, time() + 25920000);
    } else {
        //cookie verwijderen
        setcookie("inlognaam", "", time() - 3600);
    }
}


if (isset($_POST['txtEmail'])) {
    $eml = $_POST['txtEmail'];
}
if (isset($_POST['txtLokaal'])) {
    $lokaal = $_POST['txtLokaal'];
}
if (isset($_POST['txtOnderwerp'])) {
    $Onderwerp = $_POST['txtOnderwerp'];
}
if (isset($_POST['txtOmschrijving'])) {
    $Omschrijving = $_POST['txtOmschrijving'];
}
if (isset($_POST['priori'])) {
    $Prioriteit = $_POST['priori'];
}


if (isset($lokaal) && isset($Onderwerp) && isset($Omschrijving) && isset($Prioriteit)) {


    //   print $Prioriteit;
    //Sessie maken dat hij is ingelogd
    // $_SESSION[''] = $eml;

    //STUUR MAIL HIER EN REDIRECT NAAR LOGIN WAAR ZE BEVESTIGING GEVEN DAT HET GEBERUD IS
    $valid_file = true;
//Houd de data bij in een grote string zodat we deze uit de upload maps kunnen verwijderen wanneer dit klaar is
    $targetstrings = "";
    $prio = $Prioriteit;
    //ZEND DE EMAIL
    $email = new PHPMailer();
    $email->From = $eml;
    $email->FromName = $eml;
    $email->Subject = $Onderwerp;

    //kijk of button is aangeklikt zoja add er bij
    if (isset($_POST['chkHoudOpDeHoogte'])) {
        //checkbox aangeklikt
        $prio = $prio . "/n@" . $eml;

    }


    $email->Body = $Omschrijving . "/n@" . $prio . "/n@" . $lokaal;

    $email->AddAddress('howesttasktool+msde5lytyugsq63acucg@boards.trello.com'); //new email

//$email->AddAddress('wouterdumon@hotmail.com');
    $naamvanfoto = $test;

//Herzet de array naar een meer leesbare array
    function reArrayFiles(&$file_post)
    {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    $file_ary = reArrayFiles($_FILES['Foto']);
    //print_r($file_ary);
    foreach ($file_ary as $file) {
        $tmp_naam = $file['tmp_name'];
        $type = $file['type'];
        $name = $file['name'];
        $size = $file['size'];
        $error = $file['error'];
        //Hier ophalen verzetten en attachen aan de email
        //print($error);
        if ($error != 0) {
            $valid_file = false;
            $message = "error";
        } else {
            $nieuw_file_naam = strtolower($tmp_naam);
            if ($size > (21000000)) {
                $valid_file = false;
                $message = "Te groot";
            }//einde error
            //      print($valid_file);
            //       print($message);
            if ($valid_file) {//false indien te groot of een error optreed
                //   print("attachadded1");
                $currentdir = getcwd();
                $target = $currentdir . '/uploads/' . $name;

                $targetstrings = $targetstrings . "/n@" . $target;
                $test = $name;
                move_uploaded_file($tmp_naam, $target);
                $message = 'File\' s are sended';
                $email->AddAttachment($target, $naamvanfoto); // voeg attachment aan email toe
                // hier wordt de data opgelsaan in een grote string ( pad naar waar de afbeelding staat )

            }//einde valid file
        } // einde foreach
    }//einde isset
    //Zend de email naar trello
    $email->Send();
    //delete de foto's uit de uploads map aangezien deze nu op de database van trello zullen komen te staan
    $arraywithtargets = explode("/n@", $targetstrings);
    foreach ($arraywithtargets as $targ) {
        //targ is hier 1 pad naar een bestand die in de uploads map zit
        //  print("test1");
        $targ = str_replace('\\', '/', $targ);
        //kijk of het ad de map uploads bevat

        if (strpos($targ, 'uploads') !== false) {//zoekt de positie van het woord uploads ( soort van contains )
            unlink($targ); // delete de file uit de uploads folder
            // print($targ);
        }


    }
    //Navigeer de user terug naar de login OF start pagian, indien onthaal medewerker
    //TODO: code nog hier voor directory
    if ($eml == 'docent@howest.be') {
        //   header('Location: ../index.php?data=1');

    } else {
      //  header('Location: ../Overzicht');
    }
    //TODO: sessie leeg maken

    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('.modal')
                .modal('setting', 'transition', 'scale')
                .modal('show');
        });
    </script>
<?php
}//einde isset
else {
//Waardes bestaan nog niet => geen goed form of slechte input
    if (isset($bericht)) {
//emailadres bestaat der is ingelogd
        $str = explode("@", $bericht);
        if ($str[1] == "howest.be") {
            //Klopt is goed
        } else {
            if (isset($_SESSION['loggedin'])) {
            } else {
//Klopt niet return
                header('Location: ../index.php?data=2');
            }
        }
    } else {
        if (isset($_SESSION['loggedin'])) {
        } else {
            header('Location: ../index.php?data=2');
        }
    }
}
//data ophalen en printen in een javascript array

//connectie maken met db(mysql)
//local
//$mysqli = new mysqli('localhost', 'root', 'usbw', 'tasktool');

//student howest
$mysqli = new mysqli('mysqlstudent', 'wouterdumoeik9aj', 'zeiSh6sieHuc', 'wouterdumoeik9aj');

//controleren op fouten
//echo "h";
if ($mysqli->connect_error) {
    echo "Geen connectie mogelijk met de database";
}
$data = array();
?>
<!-- uery zelf in -->
<script>    var arraymetlokalen = [];</script>

<?php
//alles ophalen en in array steken
//echo 'h';
$result = $mysqli->query("SELECT NAME FROM klassen");
//print_r($result);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    // print_r($row['NAME']);
    ?>
    <script>
        //    console.log("h");
        arraymetlokalen.push(<?php print "'".$row['NAME']."'" ?>);
    </script>
    <?php
    // array_push($data['merken'],$row);
}
//connectie sluiten
$mysqli->close();
?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<!-- laad de jquery in voor autocomplete -->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    //console.log(arraymetlokalen);
    $(function () {

        $("#txtLokaal").autocomplete({
            source: arraymetlokalen
        });
    });


</script>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    </meta>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"/>
    <title>
        Meldpagina - Howest Tasktool
    </title>

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="../css/transition.min.css">
    <script src="../js/semantic.min.js"></script>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" rel="stylesheet"/>
    <script>
        $(function () {
            $("#slider").slider({
                min: 1,
                max: 100,
                slide: function (event, ui) {
                    $("#amount").val(ui.value);
                }
            });
            $("#slider").css('background', 'linear-gradient(to right,green,orange,red');
            $("#slider").css('border-width', '0px');
        });
    </script>
</head>

<body>
<header>
    <a href="../Overzicht/index.html" class="Howestlogo"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a onclick="afmelden(this)">Afmelden</a></button>
    <nav>
        <ul>
            <li><a href="#">Probleem melden</a></li>
            <li><a href="../Overzicht_Takenlijst/">Overzicht takenlijst</a></li>
            <li><a href="../Statistieken">Statistieken</a></li>
            <li><a href="">Instellingen</a></li>
        </ul>
    </nav>

    <div class="clearfix"></div>
</header>
<main id="MeldDefectFormulier">
    <h1>Meld hier een defect/taak</h1>
    <section id="MeldDefect">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="form" enctype="multipart/form-data">
            <label for="txtEmail">Email: <span> *</span></label>
            <input id="txtEmail" type="email" name="txtEmail" value="<?php

            if (isset($_SESSION['loggedin'])) {
                print $_SESSION['loggedin'];
            } else {
                print $bericht;
            } ?>" placeholder="voornaam.achternaam@howest.be" readonly="readonly" required>
            <label for="txtLokaal">Lokaal:<span> *</span></label>

            <div class="ui-widget">


                <input type="text" id="txtLokaal" name="txtLokaal" placeholder="A.202b (Leslokaal)" tabindex="1"
                       title="Selecteer een lokaal uit de lijst." required/>
            </div>
            <label for="txtOnderwerp">Onderwerp:<span> *</span></label>
            <input id="txtOnderwerp" type="text" name="txtOnderwerp" placeholder="Waterfontein is kapot" tabindex="2"
                   pattern=".{3,}" title="Titel moet minimum 3 karakters bevatten." required/>
            <label for="txtOmschrijving">Omschrijving:<span> *</span></label>
            <textarea id="txtOmschrijving" name="txtOmschrijving" cols="30" rows="7"
                      placeholder="Vul hier uw Omschrijving in" tabindex="3" title="Gelieve een omschrijving te geven."
                      required></textarea>
            <label>Prioriteit:<span> *</span></label>
            <input type="hidden" id="amount" readonly style="border:0;">

            <div id="slider" onmouseover="Prioriteit()"></div>
            <p id="prior"></p>
            <input type="text" style="display: none" id="priori" name="priori">
            <label>Bijlage:</label>
            <!--   <div class="dropzone dz-clickable" id="my-awesome-dropzone">
                   <div class="dz-message" data-dz-message>
                       Klik of sleep hier je foto van het probleem<br />
                       en/of bijhorende bijlages
                   </div>
               </div>-->
            <div id="DFoto">
                <label for="Foto">Foto:</label>
                <input type="file" name="Foto[]" id="Foto" multiple tabindex="5">
            </div>
            <input type="checkbox" name="chkHoudOpDeHoogte" id="chkHoudOpDeHoogte" checked value="chkHoudOpDeHoogte">
            <label for="chkHoudOpDeHoogte">Houd mij op de hoogte</label>
            <input type="submit" value="Meld defect!" name="submit" id="submit" tabindex="6" onsubmit="OpenPopup()">

            <div class="clearfix"></div>
        </form>

        <div class="ui test modal transition" style="z-index: 100000;">
            <!-- TODO: Close icon zoeken !-->
            <i id="close_Popup" class="close icon"></i>

            <div class="header">
                Bedankt!
            </div>
            <div class="content">
                <div class="center">
                    <p>Je bericht werd succesvol verzonden.</p>
                </div>
                <div class="clearfix"></div>
            </div>

    </section>
</main>

<!--<script>    Dropzone.autoDiscover = false;
    Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

        // The configuration we've talked about above
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,

        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;

            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("input[type=submit]").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });
            this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
            });
            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });
        }

    }

</script>-->

<script>
    function afmelden(a) {
        console.log("test");

        $.ajax({
            url: '../logout.php',
            dataType: 'html',
            success: function (data) {
                //data returned from php
                window.open("../", "_self");
            }
        });
    }
    /*
     var btn = document.getElementById("submit");
     var article = document.getElementById("Article");
     var lokaal = document.getElementById("txtLokaal");
     var achternaam = document.getElementById("txtOnderwerp");
     var email = document.getElementById("txtEmail");
     var stad = document.getElementById("txtOmschrijving");
     var stop = false;

     */
    function Prioriteit() {
        var prioriteit = document.getElementById("amount").value;

        if (prioriteit <= 40) {
            document.getElementById("prior").innerHTML = "Niet dringend";
            document.getElementById("priori").value = "Niet dringend";
        }
        else if (prioriteit > 40 && prioriteit <= 70) {
            document.getElementById("prior").innerHTML = "Dringend";
            document.getElementById("priori").value = "Dringend";
        }
        else if (prioriteit > 70) {
            document.getElementById("prior").innerHTML = "Zeer dringend";
            document.getElementById("priori").value = "Zeer dringend";
        }
    }
    /*    //var count = 0;
     lokaal.addEventListener("input",function(e){
     var chck = e.target;
     checkvalidity(chck);
     } );
     achternaam.addEventListener("input",function(e){
     var chck = e.target;
     checkvalidity(chck);
     } );
     email.addEventListener("input",function(e){
     var chck = e.target;
     checkvalidityemail(chck);
     } );
     stad.addEventListener("input",function(e){
     var chck = e.target;
     checkvalidity(chck);
     });
     function checkvalidity(input){
     input.setCustomValidity("");
     if(input.validity.valid){
     input.style.border = "solid #0a7f2e 2px";
     input.style.backgroundColor = "#99ddae";
     input.style.borderRadius =  "5px";
     input.style.marginRight = "9px";
     }else{
     input.style.border = "solid #423737 3px";
     input.style.backgroundColor = "#d4d4d4";
     input.style.marginRight = "9px";
     input.style.borderRadius =  "5px";

     }}
     function checkvalidityemail(input){

     input.setCustomValidity("");
     if(input.validity.valid){
     input.style.border = "solid #0a7f2e 2px";
     input.style.backgroundColor = "#99ddae";
     input.style.borderRadius =  "5px";
     input.style.marginRight = "9px";
     }else{
     input.setCustomValidity("Gelieve een geldige email in te geven");
     input.style.border = "solid #423737 3px";
     input.style.backgroundColor = "#d4d4d4";
     input.style.marginRight = "9px";
     input.style.borderRadius =  "5px";

     }
     }
     btn.addEventListener("click", function(click){

     var ok = true;
     /*
     if(achternaam.validity.valid == false){
     achternaam.setCustomValidity("Gelieve een familienaam in te geven");
     ok = false;
     }

     if(email.validity.valid == false){
     email.setCustomValidity("Gelieve een geldige email in te geven");
     ok = false;
     }
     if(stad.validity.valid == false){
     stad.setCustomValidity("Gelieve een stad in te geven");
     ok = false;
     }
     */
    //   });
</script>

</body>
</html>