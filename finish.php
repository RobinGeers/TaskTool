<?php
$naam = "";
if(isset($_GET['id'])){
    $naam=$_GET['id'];
}else{
    header("location:Afdrukpagina.php");
}
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 3/06/2015
 * Time: 10:16
 */

?>
<!DOCTYPE html>
<html>
<head lang='en'>
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
    <link rel="stylesheet" href="css/screen.css"/>
    <meta charset='UTF-8'>
    <title>Lijst van <?php print$naam; ?> </title>
</head>
<body>
<div id="container" class="finishcontainer">
    <form>
        <label for="taakGelukt" class="lbl">Is de taak gelukt?</label><br />
        <input type="radio" name="taakGelukt" value="Ja" class="radiobt" checked="checked" /> Ja
        <input type="radio" name="taakGelukt" value="Nee" class="radiobt" /> Nee <br /><br />
        <label for="bericht" class="lbl">Voeg een opmerking toe (Enkel verplicht als de taak niet kan worden afgewerkt)</label><br />
        <textarea cols="50" rows="10" name="bericht" class="txtbericht"></textarea><br />
        <input type="submit" id="versturen" name="versturen" class="btnverstuur" />
    </form>
</div>
</body>
</html>

<script>

    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var APP_SKEY = 'dfe27886101982c335c417a25919baaf7923056549ea2ff5bca0fd3953944fe1';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    var url_boards = "https://api.trello.com/1/members/me/boards/?&key=$key&token=$application_token";
    var TrelloLists = [];
    var SelectedList = "";

                var now = new Date();
                var date = now.getDate() + "/" + now.getMonth()+"/"+now.getFullYear();
                var time = now.getHours()+":"+now.getMinutes();


                            Trello.get("/cards/<?php print $naam; ?>?fields=desc&token=" + application_token, function (cardinfo) {
carddesc = cardinfo.desc;
                                carddesc = carddesc +"/n@"+ date + "/n@" + time;
                                console.log(carddesc);
                                //Trello.put("/cards/<?php print$naam; ?>?key="+APP_KEY+"&token="+application_token+"&idList=5506dbf5b32e668bde0de1b6&desc="+carddesc);
                            });


/*
*
*
*
* */
</script>