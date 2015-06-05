<?php

$naam = "";
if(isset($_GET['Werkman'])){
    $naam=$_GET['Werkman'];
}
if($naam != "") {

    ?>
<!DOCTYPE html>
<html>
<head lang='en'>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="css/Print.css"/>
    <title>Lijst van <?php print$naam; ?> </title>
</head>
<body>
    <div id="container"></div>
    </body>
</html>

    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
<script type="text/javascript" src="qrcodejs-master/qrcode.js"></script> <!-- Laad de qrcode js in ( MIT license ) -->
    <script>

        var APP_KEY = '23128bd41978917ab127f2d9ed741385';
        var APP_SKEY = 'dfe27886101982c335c417a25919baaf7923056549ea2ff5bca0fd3953944fe1';
        var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
        var url_boards = "https://api.trello.com/1/members/me/boards/?&key=$key&token=$application_token";
        var TrelloLists = [];
        var SelectedList = "";
        Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token=" + application_token, function (lists) {


            $.each(lists["lists"], function (ix, list) {
                var List = [];
                //  console.log(ix); is gelijk aan de int i = 0 van de for lus
                List.push(list.id, list.name); // in list zitten de parameters van de lijsten dus in ons geval hebben we het id en naam nodig
                if (list.name.includes(<?php print "'".$naam."'" ?>)) {
                    SelectedList = list.id; //kijken of de naam die meegeven is in del ink voorkomt in in de lijst namen
//    console.log(SelectedList);
                }
                TrelloLists.push(List);//Voeg de array list toe aan de array TrelloList
            });
            console.log(TrelloLists);
//Haal alle kaartjes op van een bepaalde lijst
            Trello.get("/lists/" + SelectedList + "?fields=name&cards=open&card_fields=name&token=" + application_token, function (cards) {
                //console.log(cards["cards"]);
                 CardId = [];
//overloop alle kaarten die we terug krijgen
                $.each(cards["cards"], function (ix, card) {
                    //console.log(card.id);
                    var temparr = [];
                    var attachementsarr = [];
                    var description = [];
                    var carddescription = "";
                    //1/cards/"+card.id+"?fields=desc&attachments=true&token=a0fdcb022ad19ba6de1a849f4d325e9d8aedf95f086570718a3054d4e4bf4681
                    //Overloop 1 kaartje en haal de data eruit
                    Trello.get("/cards/" + card.id + "?fields=desc&attachments=true&token=" + application_token, function (cardinfo) {
                        //ASYNC!!!
                       // description.push(cardinfo.desc);
                        carddescription = cardinfo.desc; //gaat niet aangezien dit async verloopt
                        console.log(cardinfo.desc);
                        //kijkt naar de attachments en voegt de link toe in een array
                        $.each(cardinfo.attachments, function (ix, attachement) {
                            attachementsarr.push(attachement.url);
                        });

                    //Bevat 1 kaartje zijn info
                    temparr.push(card.id, card.name, carddescription, attachementsarr);
                  //  Trello.put('/1/cards/' + card.id + '/checklist/5506dbf5b32e668bde0de1b4/checkItem/' + ix + '/' + card.name + '&value=HAHAHAHAHAHAHHA');
                    //array met alle kaartjes in



 //  <!-- Maak evenveel DIV's aan als er kaartzen zijn ( zal nog in for lus moeten ) -->

                    console.log('hhh');
                    console.log(temparr);
                    console.log('hhh');
                        //<img src="pic_mountain.jpg" alt="Mountain View" style="width:304px;height:228px;">
var dc = carddescription.split("/n@");

                        //TODO
                        var para = document.createElement("div");
                        var centerdiv = document.createElement("div");
                        var chkbox = document.createElement("input");
                        var label = document.createElement('label');
                        label.appendChild(document.createTextNode('Afgewerkt'));
                        chkbox.setAttribute("type","checkbox");
                        chkbox.setAttribute("name","afgewerkt");
                        chkbox.setAttribute("value","Afgewerkt");
                        chkbox.setAttribute("class","chkbox");
                        centerdiv.setAttribute("class", "column-center");
                        var titel = document.createElement("h1");
                        var p2 = document.createElement("p");
                        var node = document.createTextNode(""+dc[0]);
                        titel.appendChild(node);
                        var node2 = document.createTextNode(""+temparr[1]);
                        p2.appendChild(node2);
                        para.appendChild(centerdiv);
                        centerdiv.appendChild(titel);
                        centerdiv.appendChild(p2);
                        centerdiv.appendChild(chkbox);
                        centerdiv.appendChild(label);
                        para.setAttribute("id","qrcode"+ix);

                       // console.log(element);

                     //   document.write("<input type='checkbox' name='smiley' value='Ja'>Afgewerkt<br>");
                        $.each(temparr[3],function(ix,temp){
                            console.log("naam is:" + temp);
                            var extension = temp.substr(temp.length - 3); // => "Tabs1"
                            if(extension=="jpg"||extension=="png") {
                                var pimg = document.createElement("img");
                                pimg.setAttribute("src",temp);
                                pimg.setAttribute("class","afbeelding");
                                centerdiv.appendChild(pimg);
                            }

                            });
                        var element = document.getElementById("container");
                        element.appendChild(para);

                   var qrcode = new QRCode(document.getElementById("qrcode" + ix), {
                       width: 150,
                       height: 150
                   });
                   qrcode.makeCode("http://student.howest.be/wouter.dumon/testing/finish.php?id="+temparr[0]);



                CardId.push(temparr)
                }); });
  /*  <div id="qrcode1" style="width:100px; height:100px; margin-top:15px;"></div>
    <div id="qrcode2" style="width:100px; height:100px; margin-top:100px;"></div>
    <div id="qrcode3" style="width:100px; height:100px; margin-top:150px;"></div>
    <div id="qrcode4" style="width:100px; height:100px; margin-top:200px;"></div>
    <div id="qrcode5" style="width:100px; height:100px; margin-top:250px;"></div>*/

                });

/*
        var loop = CardId.length; // 6-1 = 5 hij zal 5 keer in de loop terecht komen
        for (i = 0; i < loop+1; i++) {
            var qrcode = new QRCode(document.getElementById("qrcode" + i), {
                width: 100,
                height: 100
            });
            //console.log(qrcode);

            //maak de qr code aan
            qrcode.makeCode("http://student.howest.be/wouter.dumon/ProjectTEst/PROJECT/root/Afdrukpagina.html");
        }*/


            });

     //   });


    </script>
<?php


}?>