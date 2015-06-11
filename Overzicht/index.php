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