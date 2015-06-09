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
    <link rel="stylesheet" href="css/bootstrap.minAfdruk.css">
    <link rel="stylesheet" href="css/afdrukcss.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
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

                        console.log(temparr);

                        //
                        <!-- Maak evenveel DIV's aan als er kaartzen zijn ( zal nog in for lus moeten ) -->
                        //<img src="pic_mountain.jpg" alt="Mountain View" style="width:304px;height:228px;">
                        var dc = carddescription.split("/n@");

                        //TODO
                        var hoofddiv = document.createElement("div");
                        var leftdiv = document.createElement("div");
                        var centerdiv = document.createElement("div");
                        var rightdiv = document.createElement("div");
                        var chkbox = document.createElement("input");
                        var label = document.createElement('label');
                        leftdiv.setAttribute("id", "leftdiv");
                        leftdiv.setAttribute("class", "col-md-2");
                        centerdiv.setAttribute("class", "col-md-4");
                        centerdiv.setAttribute("id", "centerdiv");
                        rightdiv.setAttribute("class", "col-md-4");
                        rightdiv.setAttribute("id", "rightdiv");
                        label.appendChild(document.createTextNode('Afgewerkt'));
                        chkbox.setAttribute("type", "checkbox");
                        chkbox.setAttribute("name", "afgewerkt");
                        chkbox.setAttribute("value", "Afgewerkt");
                        chkbox.setAttribute("class", "chkbox");
                        var titel = document.createElement("h1");
                        var p2 = document.createElement("p");
                        var node = document.createTextNode("" + dc[0]);
                        var node2 = document.createTextNode("" + temparr[1]);
                        titel.appendChild(node2);
                        p2.appendChild(node);
                        hoofddiv.appendChild(leftdiv);
                        hoofddiv.appendChild(centerdiv);
                        hoofddiv.appendChild(rightdiv);
                        centerdiv.appendChild(titel);
                        centerdiv.appendChild(p2);
                        rightdiv.appendChild(chkbox);
                        rightdiv.appendChild(label);
                        hoofddiv.setAttribute("id", "qrcode" + ix);
                        hoofddiv.setAttribute("class", "row");
                        $.each(temparr[3], function (ix, temp) {
                            console.log("naam is:" + temp);
                            var extension = temp.substr(temp.length - 3); // => "Tabs1"
                            if (extension.toLowerCase() == "jpg" || extension.toLocaleLowerCase() == "png") {
                                var pimg = document.createElement("img");
                                pimg.setAttribute("src", temp);
                                pimg.setAttribute("class", "afbeelding");
                                rightdiv.appendChild(pimg);
                            }

                        });
                        var element = document.getElementById("container");
                        element.setAttribute("class", "container-fluid");
                        element.appendChild(hoofddiv);

                        var qrcode = new QRCode(leftdiv, {
                            width: 150,
                            height: 150
                        });
                        qrcode.makeCode("http://student.howest.be/sam.bauters/trello/finish.php?id=" + temparr[0]);


                        CardId.push(temparr)
                    });
                });
            });
        });

    </script>

<?php


}?>