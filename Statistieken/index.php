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
                <li><a href="../Instellingen/index.php">Instellingen</a></li>
            </ul>
        </nav>
        <div class="clearfix"></div>
    </header>

    <h1>Statistieken van werknemers</h1>
    <section id="Werknemers">
        <p>Bekijk statistieken van de volgende werknemers</p>
        <div id="Checkbox1" class="Checkbox_Werknemer">
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
        </div>

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

            vinkAlleWerknemersAan();
            kleurWerknemers();

            function vinkAlleWerknemersAan() {
                document.getElementById("Bennie").checked = true;
                document.getElementById("Alain").checked = true;
                document.getElementById("Erik").checked = true;
                document.getElementById("Jef").checked = true;
            }

            function kleurWerknemers() {
                if (document.getElementById("Bennie").checked) {
                    document.getElementById("Checkbox1").style.backgroundColor = "#337ab7";
                    document.getElementById("Checkbox1").style.border = "1px solid #337ab7";
                    document.getElementById("Checkbox1").style.color = "#ffffff";
                }
                else {
                    document.getElementById("Checkbox1").style.border = "none";
                }

                if (document.getElementById("Alain").checked) {
                    document.getElementById("Checkbox2").style.backgroundColor = "#337ab7";
                    document.getElementById("Checkbox2").style.border = "1px solid #337ab7";
                    document.getElementById("Checkbox2").style.color = "#ffffff";
                }
                else {
                    document.getElementById("Checkbox2").style.border = "none";
                }

                if (document.getElementById("Erik").checked) {
                    document.getElementById("Checkbox3").style.backgroundColor = "#337ab7";
                    document.getElementById("Checkbox3").style.border = "1px solid #337ab7";
                    document.getElementById("Checkbox3").style.color = "#ffffff";
                }
                else {
                    document.getElementById("Checkbox3").style.border = "none";
                }

                if (document.getElementById("Jef").checked) {
                    document.getElementById("Checkbox4").style.backgroundColor = "#337ab7";
                    document.getElementById("Checkbox4").style.border = "1px solid #337ab7";
                    document.getElementById("Checkbox4").style.color = "#ffffff";
                }
                else {
                    document.getElementById("Checkbox4").style.border = "none";
                }
            }


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