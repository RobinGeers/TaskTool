<?php
if(isset($_SESSION['loggedin'])){ // kijkt of er een sessie is

}else {
    header("Location: ./"); // Sessie bestaat niet je ben tniet ingelogd
}
$naam = "";
if(isset($_GET['id'])){
    $naam=$_GET['id'];
}else{
    //header("location:Afdrukpagina.php");
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
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
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
        <textarea cols="50" rows="10" id="BER" name="bericht" class="txtbericht"></textarea><br />
        <input onclick="dosome(this)" type="button" id="versturen" name="versturen" class="btnverstuur" value="versturen" />
    </form>
</div>
</body>
</html>

<script>
function dosome(a)
{
    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var APP_SKEY = 'dfe27886101982c335c417a25919baaf7923056549ea2ff5bca0fd3953944fe1';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    var url_boards = "https://api.trello.com/1/members/me/boards/?&key=$key&token=$application_token";
    var TrelloLists = [];
    var SelectedList = "";
    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var APP_SKEY = 'dfe27886101982c335c417a25919baaf7923056549ea2ff5bca0fd3953944fe1';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    var url_boards = "https://api.trello.com/1/members/me/boards/?&key=$key&token=$application_token";
    var TrelloLists = [];
    var SelectedList = "";

    var now = new Date();
    var date = now.getDate() + "/" + now.getMonth()+"/"+now.getFullYear();
    var time = now.getHours()+":"+now.getMinutes();


    Trello.get("/cards/<?php print $naam; ?>?fields=desc,name&token=" + application_token, function (cardinfo) {
        carddesc = cardinfo.desc;
        var test = carddesc.split("/n@");
        $.each(test,function(ix, data){
            if(check(data,"howest.be")){return;}else{
                console.log("MAIL");
                stuurmail(cardinfo.name,data);
            }
        });
        console.log(test);

        carddesc = carddesc +"/n@"+ date + "/n@" + time;
        console.log(carddesc);
  var getchck =  $('input[name=taakGelukt]:checked').val();
    console.log(getchck);
    var value = document.getElementById("BER").value;
    console.log(value);
    if(getchck=="Ja"){
                  Trello.put("/cards/<?php print$naam; ?>?key="+APP_KEY+"&token="+application_token+"&idList=5506dbf5b32e668bde0de1b6&desc="+carddesc,function(){
                      window.open("./closeme.html","_self");
                });


    }else{
        carddesc = carddesc+"/n@"+value;
            console.log(carddesc);
            Trello.put("/cards/<?php print$naam; ?>?key="+APP_KEY+"&token="+application_token+"&idList=55098deeb3d7823addabd976&desc="+carddesc,function(){
                window.open("./closeme.html","_self");
            });

    }
    });
};
    function check(a,b){
        b = b.toLowerCase();
        var res = a.toLowerCase();
        res = res.replace(' ', '');
        var gelijk = 0;
        if(res.indexOf(b) != -1){
            gelijk = 1;
        }
        if(gelijk ==0){return true;}
        return false;
    }
 function stuurmail(naam,email){
     console.log(naam+ " " + email);
     $.ajax({
         url: './zendmail.php?n='+naam+'&e='+email,
         dataType: 'html',
         success: function (data) {
             //data returned from php
            // window.open("../", "_self");
         }
     });
 }
</script>