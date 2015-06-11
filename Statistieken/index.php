<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>TaskTool Howest | Statistieken</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <script src="../js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="../css/screen.css"/>
    <link rel="stylesheet" href="../css/semantic.min.css">
    <!--<link rel="stylesheet" href="../css/icon.min.css">!-->
    <script src="https://api.trello.com/1/client.js?key=23128bd41978917ab127f2d9ed741385"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/Chart.js"></script>
</head>
<body>
<main id="Statistieken">
    <header>
       <a href="../Overzicht/index.html"><img src="../images/howestlogo.png" alt="Howest Logo"/></a>

        <button ><a onclick="afmelden(this)">Afmelden</a></button>
        <nav>
            <ul>
                <li><a href="../Meld_Defect/index.php">Probleem melden</a></li>
                <li><a href="../Overzicht_Takenlijst/index.php">Overzicht takenlijst</a></li>
                <li><a href="#">Statistieken</a></li>
                <li><a href="../Instellingen_Overzicht/index.html">Instellingen</a></li>
            </ul>
        </nav>
        <div class="clearfix"></div>
    </header>

    <h1>Statistieken van werknemers</h1>
    <section id="Werknemers">
        <section id="WerkerSelection">
            <p>Bekijk statistieken van de volgende werknemers</p>
           <!-- <div id="Checkbox1" class="Checkbox_Werknemer">
                <input type="checkbox" value="Bennie" id="Bennie"/>
                <label for="Bennie">Bennie</label>
            </div>

            <div id="Checkbox2" class="Checkbox_Werknemer">
                <input type="checkbox" value="Alain" id="Alain"/>
                <label for="Alain">Alain</label>
            </div>

            <div id="Checkbox3" class="Checkbox_Werknemer">
                <input type="checkbox" value="Erik" id="Erik"/>
                <label for="Erik">Erik</label>
            </div>

            <div id="Checkbox4" class="Checkbox_Werknemer">
                <input type="checkbox" value="Jef" id="Jef"/>
                <label for="Jef">Jef</label>
            </div>-->
        </section>
        <!--<p>Selecteer grafiektype</p>
        <div id="Pie_Chart">
            <p>Pie</p>
            <i  class="pie chart icon"></i>
        </div>
        <div>
            <p>Line</p>
            <i id="Line_Chart" class="line chart icon"></i>
        </div>
        <div>
            <p>Bar</p>
            <i id="Bar_Chart" class="bar chart icon"></i>
        </div>!-->

        <h2>Voltooide taken per werknemer</h2>

        <canvas id="myChart1"></canvas>
        <div id="Legende1">
            <p>Legende</p>
            <div id="GeneratedLegende"></div>
            <div class="clearfix"></div>
        </div>
        <section id="Algemeen">
            <h2>Algemeen overzicht</h2>
            <canvas id="myChart2"></canvas>
            <div id="Legende2">
                <p>Legende</p>
                <div id="GeneratedLegende2"></div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section id="Prestaties">
            <h2>Prestaties van werkmannen</h2>
            <table class="ui table">
                <thead>
                <tr>
                    <th>Werknemers</th>
                    <th>Reactietijd</th>
                    <th>Gemiddelde doorlooptijd</th>
                    <th>Prestatie index</th>
                </tr>
                </thead>
                <tr>
                    <th>Bennie</th>
                    <td>2 uur</td>
                    <td>1 dag</td>
                    <td>75%</td>
                </tr>
                <tr>
                    <th>Alain</th>
                    <td>2 uur</td>
                    <td>1 dag</td>
                    <td>75%</td>
                </tr>
                <tr>
                    <th>Rik</th>
                    <td>2 uur</td>
                    <td>1 dag</td>
                    <td>75%</td>
                </tr>
                <tr>
                    <th>Jef</th>
                    <td>2 uur</td>
                    <td>1 dag</td>
                    <td>75%</td>
                </tr>
            </table>
        </section>
    </section>
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

            //trello
            var APP_KEY = '23128bd41978917ab127f2d9ed741385';
            var application_token = "c7434e2a13b931840e74ba1dceef6b09f503b8db6c19f52b4c2d4539ebeb77f7";
            var workers = [];
            var workerId = [];
            var workersindesc = [];
            $(document).ready(GetWorkers);
            function GetWorkers()
            {
                Trello.get("/boards/5506dbf5b32e668bde0de1b3?lists=open&list_fields=name&fields=name,desc&token="+application_token,function(lists)
                {
                    var werknemers = document.getElementById("WerkerSelection");
                    $.each(lists["lists"],function(ix,list)
                    {
                        if(list.name != "Taken"&& list.name != "Voltooid" && list.name != "On hold")
                        {
                            workerId.push(list.id);
                            workers.push(list.name);


                            //console.log(werknemers);

                            var div = document.createElement("DIV");
                            div.setAttribute("id",list.id);
                            div.setAttribute("class","Checkbox_Werknemer");
                            //div.style = border: 1px solid rgb(51, 122, 183); color: rgb(255, 255,
                            // 255); background-color: rgb(51, 122, 183);

                            var input = document.createElement("INPUT");
                            input.setAttribute("type","checkbox");
                            input.setAttribute("value",list.name);
                            input.setAttribute("id",list.name);

                            var label = document.createElement("LABEL");
                            label.setAttribute("for",list.name);
                            label.innerHTML = list.name;


                            div.appendChild(input);
                            div.appendChild(label);
                            werknemers.appendChild(div);

                        }
                        if(list.name == "Voltooid")
                        {
                            Trello.get("/lists/"+list.id+"?fields=name&cards=open&card_fields=name&token" +
                            "="+application_token, function(cards) {

                                $.each(cards["cards"], function(ix, card){

                                    Trello.get("/cards/"+card.id+"?fields=desc&attachments=true&token="+application_token,function(cardinfo)
                                    {

                                        var descsplilt = cardinfo.desc.split("/n@");
                                        $.each(descsplilt,function(ix,descpart){
                                            if(descpart.split("@")[0] == "N")
                                            {
                                                //console.log(descpart.split("@")[1]);
                                                workersindesc.push(descpart.split("@")[1]);
                                            }

                                        });
                                        console.log(workersindesc);
                                    });
                                });


                            });
                        }
                    });
                    var timer = setInterval(function () {Initialize(werknemers,
                        workersindesc);clearInterval(timer);
                    }, 2000);





                });
            }
</script>