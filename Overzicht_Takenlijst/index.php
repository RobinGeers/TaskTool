<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Overzicht takenlijst</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/icon.min.css">
    <link rel="stylesheet" href="../css/transition.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/semantic.min.js"></script>
    <script src="../js/transition.min.js"></script>
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
    <!-- laad de jquery in voor autocomplete -->
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>
<header>
    <a href="../Overzicht/index.html"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>
    <button><a href="../index.php">Afmelden</a></button>
    <nav>
        <ul>
            <li><a href="../Meld_Defect/index.php">Probleem melden</a></li>
            <li><a href="#">Overzicht takenlijst</a></li>
            <li><a href="../Statistieken/index.html">Statistieken</a></li>
            <li><a href="../Instellingen/index.php">Instellingen</a></li>
        </ul>
    </nav>
    <div class="clearfix"></div>

</header>
    <main id="Overzicht_Takenlijst">
        <h1>Overzicht takenlijst</h1>

        <!-- Pop-up Window !-->
        <div id="Popup" class="ui test modal transition" style="z-index: 100000;">
            <!-- TODO: Close icon zoeken !-->
            <i id="close_Popup" class="close icon"></i>
            <div class="header">
                Titel kaartje
            </div>
            <div class="content">
                <div class="left">
                    <img src="../images/Howest_Logo.png" alt="Howest Logo"/>
                </div>
                <div class="right">
                    <input type="text" value="Titel kaartje"/>
                    <input type="text" value="GKG A.202b"/>
                    <textarea name="" id="" cols="30" rows="10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</textarea>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="actions">
                <div id="btnVerwijder" class="ui negative right labeled icon button">
                    Verwijder taak <i class="trash icon"></i>
                </div>

                <div class="ui black button">
                    Annuleer
                </div>
                <div id="btnOpslaan" class="ui positive right labeled icon button">
                    Opslaan <i class="checkmark icon"></i>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

         <!-- Oude filter op Prioriteit <section>
                <select name="Filter_Prioriteit" id="Filter_Prioriteit" onchange="PriorityChange(this.value)">
                    <option value="Default">Prioriteit</option>
                    <option value="Niet dringend">Niet dringend</option>
                    <option value="Dringend">Dringend</option>
                    <option value="Direct">Direct</option>
                </select>!-->

        <!-- Oude filter op Werknemer
             <select name="Filter_Worder" id="Filter_Worker" onchange="WorkerChange(this.value)">
                 <option value="Default">Werknemer</option>
             </select>!-->

                <!-- Filter op prioriteit !-->
                <div id="Filter1" class="ui floating dropdown labeled icon button">
                    <i class="filter icon"></i>
                    <span class="text">Filter prioriteit</span>
                    <div class="menu">
                        <div value="Default" class="header">
                            <i class="tags icon"></i>
                            Prioriteit
                        </div>
                        <div onclick="PriorityChange('Niet dringend')" class="item">
                            <div class="ui green empty circular label"></div>
                            Niet dringend
                        </div>
                        <div onclick="PriorityChange('Dringend')" class="item">
                            <div class="ui yellow empty circular label"></div>
                            Dringend
                        </div>
                        <div onclick="PriorityChange('Direct')" class="item">
                            <div class="ui red empty circular label"></div>
                            Direct
                        </div>
                    </div>
                </div>

                <!-- Filter op Werknemer !-->
                <div class="ui floating dropdown labeled icon button">
                    <i class="filter icon"></i>
                    <span class="text">Filter werknemer</span>
                    <div class="menu" id="Filter_Worker">
                        <div value="Default" class="header">
                            <i class="tags icon"></i>
                            Werknemer
                        </div>
                    </div>
                </div>

                <!--Oude filter op campussen!-->
                <select name="Filter_Campussen" id="Filter_Campussen" onchange="CampusChange(this.value)">
                    <option value="Default">Campus</option>
                </select>

                <!-- Filter op Campussen
                 TODO: Helemaal onderaan in de code bug oplossen (Mutable variable i)
                <div class="ui floating dropdown labeled icon button">
                    <i class="filter icon"></i>
                    <span class="text">Filter campus</span>
                    <div class="menu" id="Filter_Campussen">
                        <div value="Default" class="header">
                            <i class="tags icon"></i>
                            Campus
                        </div>
                    </div>
                </div>!-->

            </section>

            <section id="Filters_Zoek">
                <!--<input type="text" name="Filter_Taak" id="Filter_Taak" placeholder="Titel taak.."/>!-->

                <div id="Filter_Taak" class="ui floating dropdown labeled search icon button">
                    <i class="search icon"></i>
                    <span class="text">Titel taak..</span>
                    <div class="menu">
                        <div class="item">Ruit is kapot</div>
                        <div class="item">Lamp moet vervangen worden</div>
                    </div>
                </div>

                <div id="Filter_Lokaal" class="ui floating dropdown labeled search icon button">
                    <i class="search icon"></i>
                    <span class="text">Lokaal..</span>
                    <div class="menu">
                        <div class="item">A.202b</div>
                        <div class="item">A202c</div>
                    </div>
                </div>

                <input type="text" name="Filter_Lokaal" id="Filter_Lokaal" placeholder="Lokaal.."/>
            </section>
            <div class="clearfix"></div>
        </section>
        
        <section id="SelectedFilters">
            <div>
                <h3>Geselecteerde Filters: </h3>
            </div>
        </section>
        <div class="clearfix"></div>
        <section id="Taken" class="Section_Float draglist">
            <h2 class="Overzicht_Titels">Taken</h2>

        </section>
        <section id="Medewerkers" class="Section_Float">
            <h2 class="Overzicht_Titels">Medewerkers</h2>

        </section>
        <section id="Voltooid" class="Section_Float draglist">
            <h2 class="Overzicht_Titels">Voltooid</h2>

        </section>
        <section id="OnHold" class="Section_Float draglist">
            <h2 class="Overzicht_Titels">On hold</h2>
            <ul class="cardlist draglist">

            </ul>
        </section>
        <div class="clearfix"></div>
    </main>
<script>
    var APP_KEY = '23128bd41978917ab127f2d9ed741385';
    var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
    var checkKaartInmedewerker;

    $('.ui.dropdown')
        .dropdown()
    ;


     $(document).ready(GetCards);


    function allowDrop(ev) {
        //console.log(ev.target.tagName);
       if(event.target.tagName !="A" && event.target.className != "lastcard")
       {
           ev.preventDefault();
       }

    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {

        if(event.target.tagName=="LI")
        {
            var newtarget =  event.target.parentElement;
        }
        else if(event.target.tagName=="DIV")
        {
            var newtarget = event.target.parentElement.parentElement;
        }
        else if(event.target.tagName=="SECTION")
        {
            //console.log(event.target.firstChild.nextSibling.nextSibling.nextSibling);
            var newtarget = event.target.firstChild.nextSibling.nextSibling.nextSibling;
        }
        else if(event.target.tagName=="H2")
        {
            //console.log(event.target.nextSibling.nextSibling);
            var newtarget = event.target.nextSibling.nextSibling
        }
        else
        {
            var newtarget = ev.target;
        }
        //console.log(event.target.tagName);

        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        var cardid = data;
        var listId = newtarget.id;

        newtarget.appendChild(document.getElementById(data));

        if(newtarget.parentNode.id == "Medewerkers")
        {
            document.getElementById(data).style.width = "350px";
            document.getElementById(data).style.maxWidth = "400px";
            console.log("in nen mederwerk gesleept");
            Trello.get("/cards/"+cardid+"?fields=desc&token="+application_token,function(cardinfo)
            {
                var unfnaam = newtarget.firstChild.innerHTML.split("<");
                var naam = unfnaam[0];

                var now = new Date();
                var date = now.getDate() + "/" + now.getMonth()+"/"+now.getFullYear();
                var time = now.getHours()+":"+now.getMinutes();

                var niewedescription =  cardinfo.desc + "/n@" + naam+ "/n@"+ date+"/n@"+time;

                Trello.put("/cards/"+cardid+"?key="+APP_KEY+"&token="+application_token+"&idList="+listId+"&desc="+niewedescription);
            });
        }
        else
        {
            document.getElementById(data).style.maxWidth = "250px";
            console.log("nie in nen medewerker");
            Trello.put("/cards/"+cardid+"?key="+APP_KEY+"&token="+application_token+"&idList="+listId+"");//&desc=is verzet
        }

        Trello.get("/cards/"+cardid+"?fields=desc&token="+application_token,function(cardinfo)
        {
            var unfnaam = newtarget.firstChild.innerHTML.split("<");
            var naam = unfnaam[0];

            var now = new Date();
            var date = now.getDate() + "/" + now.getMonth()+"/"+now.getFullYear();
            var time = now.getHours()+":"+now.getMinutes();

            var niewedescription =  cardinfo.desc + "/n@" + naam+ "/n@"+ date+"/n@"+time;
            console.log(niewedescription);
        });

    }

    // Zorg ervoor dat de kaartjes kunnen gesleept worden
    var aantalCardsMedewerker = document.getElementsByClassName("card_final").length;
    for (i = 0; i < aantalCardsMedewerker; i++) {
        document.getElementsByClassName("card_final")[i].setAttribute("draggable", "true");
        document.getElementsByClassName("card_final")[i].setAttribute("ondragstart", "drag(event)");

        var parentNode = document.getElementsByClassName("card_final")[i].parentNode.className;
        if (parentNode == "draglist") {
            //console.log("ok");
            document.getElementsByClassName("card_final")[i].style.width = 400 + "px";
        }
    }

    // Zorg ervoor dat de kaartjes kunnen gedropt worden in de lijsten
    var aantalLijsten = document.getElementsByClassName("draglist").length;
    for (i = 0; i < aantalLijsten; i++) {
        document.getElementsByClassName("draglist")[i].setAttribute("ondrop", "drop(event)");
        document.getElementsByClassName("draglist")[i].setAttribute("ondragover", "allowDrop(event)");
    }



    //trello


    function GetCards()
    {
        Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token="+application_token,function(lists)
        {
            $.each(lists["lists"],function(ix,list)
                {
                var List = [];

                List.push(list.id,list.name); // in list zitten de parameters van de lijsten dus in ons geval hebben we het id en naam nodig

                    var selecteddiv;
                    //selecteren voor war de kaarten in te plaatsen

                    if(list.name== "Taken")
                    {

                        var taken = document.getElementById("Taken");
                        var unorderedlist= maakUL(list.id,false);
                        getCards(unorderedlist,list.id,false);
                        taken.appendChild(unorderedlist);
                    }
                    else if(list.name == "Voltooid")
                    {
                        var voltooid = document.getElementById("Voltooid");
                        var unorderedlist= maakUL(list.id,false);
                        getCards(unorderedlist,list.id,false);
                        voltooid.appendChild(unorderedlist);

                    }
                    else if(list.name == "On hold")
                    {
                        var onhold = document.getElementById("OnHold");
                        var unorderedlist= maakUL(list.id,false);
                        getCards(unorderedlist,list.id,false);
                        onhold.appendChild(unorderedlist);
                    }
                    else
                    {
                        selecteddiv = document.getElementById("Medewerkers");

                        var unorderedlist= maakUL(list.id,true);

                        var li = document.createElement("LI");
                        li.setAttribute("class","Werkman_Naam");
                        li.innerHTML = list.name;

                        var i = document.createElement("I");
                        i.setAttribute("class","fa fa-print");


                        li.appendChild(i);
                        unorderedlist.appendChild(li);

                        getCards(unorderedlist,list.id,true);

                        selecteddiv.appendChild(unorderedlist);


                        var divItem = document.createElement("div");
                        divItem.className = "ui item";
                        divItem.onclick = function(){WorkerChange(list.name)};

                        var option = document.createElement("OPTION");
                        option.setAttribute("value",list.name);
                        option.innerHTML = list.name;

                        document.getElementById("Filter_Worker").appendChild(divItem);
                        divItem.appendChild(option);
                    }
                   // console.log(selecteddiv);
            });

        });
    }


    function maakUL(id,izworker)
    {
        var ul = document.createElement("UL");
        ul.setAttribute("class","draglist");
        ul.setAttribute("id",id);
        ul.setAttribute("ondrop","drop(event)");
        ul.setAttribute("ondragover","allowDrop(event)");

        if(!izworker)
        {
            ul.classList.add("cardlist");
        }
        return ul;
    }


    function getCards(selecteddiv,listID,izworker)
    {
        //Haal alle kaartjes op van een bepaalde lijst
        Trello.get("/lists/"+listID+"?fields=name&cards=open&card_fields=name&token="+application_token, function(cards) {

            //console.log(cards["cards"]);
            var CardId = [];
//overloop alle kaarten die we terug krijgen


            $.each(cards["cards"], function(ix, card){
                //console.log(card.id);
                var temparr = [];
                var attachementsarr = [];
                var description = [];

                var li = document.createElement("LI");
                li.setAttribute("class","panel panel-default card_final");
                li.setAttribute("id",card.id);
                li.setAttribute("draggable","true");
                li.setAttribute("ondragstart","drag(event)");
                if(!izworker)
                {

                    li.style.maxWidth = "250px";
                }
                else
                {
                    li.style.width = "400px";
                }

                // Als op kaart geklikt wordt -> Toon pop-up
                li.addEventListener("dblclick", function() {

                    // Indien transition niet werkt -> Bootstrap link wegdoen
                    $('.modal').addClass('scrolling');
                    $('.modal')
                            .modal('setting', 'transition', 'scale')
                            .modal('show');



                },false);


                var div1 = document.createElement("DIV");
                div1.setAttribute("class","panel-heading");

                var div2 = document.createElement("DIV");
                div2.setAttribute("class","panel-collapse collapse");
                div2.setAttribute("id","d"+ card.id);
                div2.setAttribute("role","tabpanel");

                var a1 = document.createElement("A");
                a1.setAttribute("class","panel-title");
                a1.setAttribute("data-toggle","collapse");
                a1.setAttribute("data-parent","cardlist3");
                a1.setAttribute("href","#d"+card.id);
                a1.setAttribute("aria-expanded","false");
                a1.setAttribute("aria-controls","collapseOne");
                a1.innerHTML = card.name;

                //1/cards/"+card.id+"?fields=desc&attachments=true&token=a0fdcb022ad19ba6de1a849f4d325e9d8aedf95f086570718a3054d4e4bf4681
                //Overloop 1 kaartje en haal de data eruit
                Trello.get("/cards/"+card.id+"?fields=desc&attachments=true&token="+application_token,function(cardinfo)
                {
                    //ASYNC!!!
                    description.push(cardinfo.desc);
                    carddescription = cardinfo.desc; //gaat niet aangezien dit async verloopt
                    //kijkt naar de attachments en voegt de link toe in een array
                    $.each(cardinfo.attachments,function(ix,attachement){
                        attachementsarr.push(attachement.url);

                    });
                    var descriptionn = cardinfo.desc.split("/n@");
                    //console.log(descriptionn);
                    var p21 = document.createElement("P");
                    p21.setAttribute("Class","lokaal content");
                    p21.style.paddingTop = "10px";
                    p21.innerHTML = descriptionn[3];

                    var p22 = document.createElement("P");
                    p22.setAttribute("Class","campus content");
                    p22.innerHTML = "";

                    var div21 = document.createElement("DIV");
                    div21.setAttribute("Class","clearfix");

                    var p23 = document.createElement("P");
                    p23.setAttribute("Class","panel-body");
                    p23.innerHTML = descriptionn[0];

                    if(descriptionn[1]=="Niet dringend"){li.classList.add("liBorderL");}
                    else if(descriptionn[1]=="Dringend"){li.classList.add("liBorderG");}
                    else if(descriptionn[1]=="Zeer dringend"){li.classList.add("liBorderH");}

                    div2.appendChild(p21);
                    div2.appendChild(p22);
                    div2.appendChild(div21);
                    div2.appendChild(p23);

                });


                temparr.push(card.id,card.name,description,attachementsarr);
                //array met alle kaartjes in
                CardId.push(temparr);

                div1.appendChild(a1);
                li.appendChild(div1);
                li.appendChild(div2);
                selecteddiv.appendChild(li);




                //<li class="lastcard"><i class="fa fa-refresh"></i></li>
            });

            if(!izworker)
            {
                var liend = document.createElement("UL");
                liend.setAttribute("class","lastcard");
                var i = document.createElement("I");
                i.setAttribute("class","fa fa-refresh");
                liend.appendChild(i);

                selecteddiv.parentElement.appendChild(liend);

            }

            //console.log(CardId); //print de arrat met alle kaartjes of in de console

        });
    }
//--------------------filter----------------------//
    var FilterSection=document.getElementById("SelectedFilters");
    function PriorityChange(value)
    {
        if(value != "Default")
        {
            makeDiv(value,"P");
            Filters();
        }

    }
    function WorkerChange(value)
    {
        if(value != "Default")
        {
            makeDiv(value,"W");
            Filters();
        }
    }
    function CampusChange(value)
    {
        if(value != "Default")
        {
            makeDiv(value, "C");
            Filters();
        }
    }

    function makeDiv(name,idprefix)
    {
        var div = document.createElement("DIV");
        div.setAttribute("class","");
        div.setAttribute("Onclick","DeleteFilter(this)");
        div.setAttribute("id",idprefix+"."+name);

        var label = document.createElement("LABEL");
        label.innerHTML = name;
        label.className = "ui blue large horizontal label";

        div.appendChild(label);

        FilterSection.appendChild(div);
    }



    function Filters()
    {
        var divs = FilterSection.getElementsByTagName("Div");
        var campusfilters =[];
        var priorityfilters = [];
        var workerfilters = [];
        var filtered = [];

        for(var i = 1;i< divs.length;i++)
        {
            var filters = divs[i].id.split(".");
            if(filters[0]== "P")
            {
                priorityfilters.push(divs[i]);

            }
            else if(filters[0]== "C")
            {
                campusfilters.push(divs[i]);
            }
            else if(filters[0] == "W")
            {
                workerfilters.push(divs[i]);
            }
        }

        var workersUL = document.getElementById("Medewerkers").getElementsByTagName("UL");

        if(workerfilters.length <= 0)
        {
            SetWorkersVisible();
        }
        else
        {
            for(var i = 0;i<workersUL.length;i++)
            {
                workersUL[i].style.display = "none";
            }
        }

        var onhold = document.getElementById("OnHold").getElementsByTagName("LI");
        var voltooid = document.getElementById("Voltooid").getElementsByTagName("LI");
        var taken = document.getElementById("Taken").getElementsByTagName("LI");
        var workers = document.getElementById("Medewerkers").getElementsByTagName("LI");
        var blocks = [];
        for(var j = 0;j<onhold.length;j++ )
        {
            blocks.push(onhold[j]);
        }
        for(var j = 0;j<voltooid.length;j++ )
        {
            blocks.push(voltooid[j]);
        }
        for(var j = 0;j<taken.length;j++ )
        {
            blocks.push(taken[j]);
        }
        for(var j = 0;j<workers.length;j++ )
        {

            if(workers[j].firstChild.nextSibling.firstChild!=null)
            {
                blocks.push(workers[j]);
            }
        }
        //allemaal afzetten

        for(var i = 0;i<blocks.length;i++)
        {
            blocks[i].style.display = "none";
        }

       for(var i = 1;i< divs.length;i++)
        {
            var filters = divs[i].id.split(".");


            if(filters[0]== "W")            {

                for(var j = 0;j<workersUL.length;j++ )
                {
                    if(workersUL[j].firstChild.innerText == filters[1])
                    {
                        workersUL[j].style.display = "block";
                    }


                }
            }
        }

        for(var i = 0;i< priorityfilters.length;i++)
        {

            var priority;
            if(priorityfilters[i].id.split(".")[1] == "Niet dringend"){priority = "liBorderL";}
            if(priorityfilters[i].id.split(".")[1] == "Dringend"){priority = "liBorderG";}
            else if(priorityfilters[i].id.split(".")[1] == "Direct"){priority = "liBorderH";}


            for(var j = 0;j<blocks.length;j++ )
            {
                if(blocks[j].className.split(" ")[3] == priority)
                {
                    //onhold[j].style.display="inline-block";
                    filtered.push(blocks[j]);
                }
            }

        }

        if(priorityfilters.length <=0)
        {
            filtered = blocks;

        }


        var filtered1= [];
        for(var i = 0;i< campusfilters.length;i++)
        {
            var filters = campusfilters[i].id.split(".");


            for( var j = 0;j<filtered.length;j++)
            {

                var campus = filtered[j].firstChild.nextSibling.firstChild.innerHTML.split(".")[0];


                if(campus== filters[1])
                {

                    filtered1.push(filtered[j]);
                }
            }

        }


        var endfilterobjects;
        if(filtered1.length != 0)
        {
            endfilterobjects = filtered1;
        }
        else
        {
            endfilterobjects = filtered;
        }


        for( var i = 0;i<endfilterobjects.length;i++)
        {
            endfilterobjects[i].style.display = "inline-block";
        }
        if(divs.length <=1)
        {
            var onhold = document.getElementById("OnHold").getElementsByTagName("LI");
            var voltooid = document.getElementById("Voltooid").getElementsByTagName("LI");
            var taken = document.getElementById("Taken").getElementsByTagName("LI");
            var workers = document.getElementById("Medewerkers").getElementsByTagName("LI");
            for(var j = 0;j<onhold.length;j++ )
            {
                    onhold[j].style.display="inline-block";
            }
            for(var j = 0;j<voltooid.length;j++ )
            {
                    voltooid[j].style.display="inline-block";

            }
            for(var j = 0;j<taken.length;j++ )
            {
                    taken[j].style.display="inline-block";
            }
            for(var j = 0;j<workers.length;j++ )
            {
                if(workers[j].firstChild.nextSibling.firstChild!=null) {
                    workers[j].style.display = "inline-block";
                }
            }

            SetWorkersVisible();
        }
    }


    function SetWorkersVisible()
    {
        var workersUL = document.getElementById("Medewerkers").getElementsByTagName("UL");
        for(var j = 0;j<workersUL.length;j++ )
        {

            workersUL[j].style.display = "block";



        }
    }

    function DeleteFilter(element)
    {
        console.log(element);
        element.parentNode.removeChild(element);
        Filters();
    }




</script>
<?php
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
?>


<script>    var arraymetlokalen =[]; var campussen=[]</script>
<?php
    //alles ophalen en in array steken
    //echo 'h';
    $result = $mysqli->query("SELECT NAME FROM klassen");
while($row = $result->fetch_array(MYSQLI_ASSOC))
{
    ?>
    <script>
        //    console.log("h");
        var lokaal = <?php print "'".$row['NAME']."'" ?>;
        arraymetlokalen.push(lokaal);
        var campus = lokaal.split(".");
        //console.log(campus[0]);
        if(doesExist(campus[0]))
        {
            campussen.push(campus[0]);
        }
        function doesExist(name)
        {
           for(var i = 0;i<campussen.length;i++)
           {
               if(name == campussen[i])
               {
                   return false;
               }
           }
            return true;
        }
    </script>
    <?php
       // array_push($data['merken'],$row);
    }
    //connectie sluiten
    $mysqli->close();
?>
<script>
    //console.log(arraymetlokalen);
    $(function() {
        $( "#Filter_Lokaal" ).autocomplete({
            source: arraymetlokalen
        });
    });

    for(var i = 0;i<campussen.length;i++) {

        /* Nieuwe code -> Bug moet nog opgelost worden 'mutable variable i'
        var divItem = document.createElement("div");
        divItem.className = "ui item";
        divItem.onclick = function (){CampusChange(campussen[i])};

        var option = document.createElement("OPTION");
        option.setAttribute("value", campussen[i]);
        option.setAttribute("name", campussen[i]);
        option.innerHTML = campussen[i];

        document.getElementById("Filter_Campussen").appendChild(divItem);
        divItem.appendChild(option);

        //console.log(divItem.childNodes[0].getAttribute("value"));
        //console.log(campussen[i]);*/

        /* OUDE CODE */
         var option = document.createElement("OPTION");
         option.setAttribute("value",campussen[i]);
         option.innerHTML = campussen[i];
         document.getElementById("Filter_Campussen").appendChild(option);
         console.log(campussen[i]);
    }
</script>
</body>
</html>