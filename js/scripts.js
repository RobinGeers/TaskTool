var workers  ;
var complete =[];
var StartTimezzz = [];
var FinishDatezzz = [];

function Initialize(workersection,workersindesc,StartTimings,finishtimes)
{

    workers = workersection.getElementsByTagName("div");
    countComplete(workersindesc);
    CountTimes(StartTimings,StartTimezzz);
    CountTimes(finishtimes,FinishDatezzz);

    vinkAlleWerknemersAan();
    kleurWerknemers();
    toonGrafiek1();
    toonGrafiek2();

}

document.addEventListener("DOMContentLoaded", function(event) {





/*
    // Dropzone plugin om bestanden/foto's up te loaden
    //var Dropzone = require("dropzone");

// Dropzone class:
    var myDropzone = new Dropzone("div#my-awesome-dropzone", { url: "/file/post"});

// "myAwesomeDropzone" is the camelized version of the HTML element's ID
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        accept: function(file, done) {
            if (file.name == "justinbieber.jpg") {
                done("Naha, you don't.");
            }
            else { done(); }
        }

    };*/
});
function CountTimes(base,array)
{

    for(var i = 0;i<base.length;i++)
    {
        var returnvalue = finddouble(base[i],array);

         if(returnvalue<= -1)
        {
            var temp=[base[i],1];

            array.push(temp)
        }
        else
        {
            array[returnvalue][1]++;
        }
    }

}
function countComplete(base)
{


    //complete.push(temp);

    for(var i = 0;i<base.length;i++)
    {
        var returnvalue = finddouble(base[i],complete);
        if(returnvalue<= -1)
        {
            var temp=[base[i],1];
            complete.push(temp);
        }
        else
        {
            complete[returnvalue][1]++;
        }
    }

}
function finddouble(value,list)
{
    for(var j = 0;j<list.length;j++)
    {
        if(value == list[j][0])
        {
            return j;

        }
    }
    return -1;
}


function vinkAlleWerknemersAan() {
    for(var i = 0;i<workers.length;i++)
    {
        workers[i].firstChild.checked = true;

    }
}

function kleurWerknemers()
{
    for(var i = 0;i<workers.length;i++)
    {
        if( workers[i].firstChild.checked == true)
        {
            workers[i].style.backgroundColor = "#337ab7";
            workers[i].style.border = "1px solid #337ab7";
            workers[i].style.color = "#ffffff";
        }
        else
        {
            workers[i].style.border = "none";
            workers[i].style.backgroundColor = "#FFFFFF";
            workers[i].style.color = "#337ab7";

        }
    }
}

function toonGrafiek1() {
    // Grafiek voltooide taken per werknemer
    var ctx = document.getElementById("myChart1").getContext("2d");
  /*  data = {
        labels: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "November", "December"],
        datasets: [
            {
                label: "Bennie",
                fillColor: "rgba(230, 126, 34,0.2)",
                strokeColor: "rgba(230, 126, 34,1)",
                pointColor: "rgba(230, 126, 34,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(230, 126, 34,1)",
                data: [65, 59, 80, 81, 56, 55, 40, 60, 62, 32, 45]
            },
            {
                label: "Alain",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [45, 60, 65, 20, 35, 70, 75, 80, 40, 20, 45]
            },
            {
                label: "Erik",
                fillColor: "rgba(0, 177, 106,0.2)",
                strokeColor: "rgba(0, 177, 106,1)",
                pointColor: "rgba(0, 177, 106,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(0, 177, 106,1)",
                data: [28, 48, 40, 19, 86, 27, 90, 20, 15, 35, 20]
            },
            {
                label: "Jef",
                fillColor: "rgba(30, 139, 195,0.2)",
                strokeColor: "rgba(30, 139, 195,1)",
                pointColor: "rgba(30, 139, 195,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(30, 139, 195,1)",
                data: [18, 38, 30, 9, 55, 17, 80, 10, 5, 25, 10]
            }
        ]
    };*/

    var dataPie = [

    ];

   /* var optionsLine = {

        ///Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - Whether the line is curved between points
        bezierCurve : true,

        //Number - Tension of the bezier curve between points
        bezierCurveTension : 0.4,

        //Boolean - Whether to show a dot for each point
        pointDot : true,

        //Number - Radius of each point dot in pixels
        pointDotRadius : 4,

        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth : 1,

        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius : 20,

        //Boolean - Whether to show a stroke for datasets
        datasetStroke : true,

        //Number - Pixel width of dataset stroke
        datasetStrokeWidth : 2,

        //Boolean - Whether to fill the dataset with a colour
        datasetFill : true,

        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    };*/

    var optionsPie = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke : true,

        //String - The colour of each segment stroke
        segmentStrokeColor : "#fff",

        //Number - The width of each segment stroke
        segmentStrokeWidth : 2,

        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout : 50, // This is 0 for Pie charts

        //Number - Amount of animation steps
        animationSteps : 100,

        //String - Animation easing effect
        animationEasing : "easeOutBounce",

        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate : true,

        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale : false,

        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

    };

    /* var optionsBar = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero : true,

            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - If there is a stroke on each bar
        barShowStroke : true,

        //Number - Pixel width of the bar stroke
        barStrokeWidth : 2,

        //Number - Spacing between each of the X value sets
        barValueSpacing : 5,

        //Number - Spacing between data sets within X values
        barDatasetSpacing : 1,

        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    };*/

  /*  var dataLineBennie = {
        label: "Bennie",
        fillColor: "rgba(230, 126, 34,0.2)",
        strokeColor: "rgba(230, 126, 34,1)",
        pointColor: "rgba(230, 126, 34,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(230, 126, 34,1)",
        data: [65, 59, 80, 81, 56, 55, 40, 60, 62, 32, 45]
    };

    var dataLineAlain = {
        label: "Alain",
        fillColor: "rgba(151,187,205,0.2)",
        strokeColor: "rgba(151,187,205,1)",
        pointColor: "rgba(151,187,205,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: [45, 60, 65, 20, 35, 70, 75, 80, 40, 20, 45]
    };

    var dataLineErik = {
        label: "Erik",
            fillColor: "rgba(0, 177, 106,0.2)",
        strokeColor: "rgba(0, 177, 106,1)",
        pointColor: "rgba(0, 177, 106,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(0, 177, 106,1)",
        data: [28, 48, 40, 19, 86, 27, 90, 20, 15, 35, 20]
    };

    var dataLineJef = {
        label: "Jef",
        fillColor: "rgba(30, 139, 195,0.2)",
        strokeColor: "rgba(30, 139, 195,1)",
        pointColor: "rgba(30, 139, 195,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(30, 139, 195,1)",
        data: [18, 38, 30, 9, 55, 17, 80, 10, 5, 25, 10]
    };*/

    // Toon standaard Line Chart
    myLineChart = new Chart(ctx).Pie(dataPie, optionsPie);

    // Toon legende van standaard grafiek
    toonLegende(myLineChart);
    myLineChart.update();

  /*  // Indien geklikt op Pie Chart
    document.getElementById("Pie_Chart").addEventListener("click", function(){
        myLineChart.destroy();
        myLineChart = new Chart(ctx).Pie(dataPie, optionsPie);

        // Toon legende van grafiek
        toonLegende(myLineChart);

    }, false);

    // Indien geklikt op Line Chart
    document.getElementById("Line_Chart").addEventListener("click", function(){
        myLineChart.destroy();
        myLineChart = new Chart(ctx).Line(data, optionsLine);

        // Toon legende van grafiek
        toonLegende(myLineChart);
        myLineChart.update();

        // Controleer of er werkmannen geselecteerd zijn
        checkWerkmannen(dataLineBennie, dataLineAlain, dataLineErik, dataLineJef, myLineChart);

    }, false);

    // Indien geklikt op Bar Chart
    document.getElementById("Bar_Chart").addEventListener("click", function(){
        myLineChart.destroy();
        myLineChart = new Chart(ctx).Bar(data, optionsBar);

        // Toon legende van grafiek
        toonLegende(myLineChart);

    }, false);*/

    // Toon statistieken van geselecteerde werknemers

    var values = [];
    var letters = '0123456789ABCDEF'.split('');
    for(var i = 0;i<workers.length;i++) {
        var returnvalue = finddouble(workers[i].firstChild.id, complete);

        var color = '#';
        for (var c = 0; c < 6; c++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        if (returnvalue <= -1) {

            var dataErik =
            {

                value: 0,
                color: "#FDB45C",
                highlight: "#FFC870",
                label: workers[i].firstChild.id
            };
            values.push(dataErik);
        }
        else {


            var dataErik =
            {

                value: complete[returnvalue][1],
                color: color,
                highlight: "#FFC870",
                label: workers[i].firstChild.id
            };
            values.push(dataErik);
        }


    }


    var generatedLegende;
    for(var i = 0;i<workers.length;i++)
    {
        var checkWorker = workers[i].firstChild;

        var checkboxWorker = workers[i];



        if(checkWorker.checked)
        {
            toonData(checkboxWorker,dataPie,values[i],myLineChart) ;
        }
        checkWorker.addEventListener("change",function(event){
            var element;
            for(var j = 0;j<values.length;j++)
            {
                if(values[j].label== event.target.value)
                {
                    element = j;
                }
            }

            toonData(checkboxWorker,dataPie,values[element],myLineChart);
            kleurWerknemers();
        },false);
    }
}

function toonData(checkboxDiv, dataPie, dataWerkman, myLineChart) {
    // Positie van dataBennie in de array
    var positionData = dataPie.indexOf(dataWerkman);
    var legende =  document.getElementById("GeneratedLegende").getElementsByTagName("li");
    var  found = false;
    for(var i = 0;i<legende.length;i++)
    {
        if(dataWerkman.label == legende[i].innerText)
        {
            found = true;
        }
    }
    if(found)
    {
        dataPie.splice(positionData, 1);
        myLineChart.removeData(positionData);
        myLineChart.update();
        generatedLegende = myLineChart.generateLegend();
        toonLegende(myLineChart);

        checkboxDiv.style.backgroundColor = "#ffffff";
        checkboxDiv.style.color = "#000000";
    }
    else
    {
        dataPie.push(dataWerkman);
        myLineChart.addData(dataWerkman);
        myLineChart.update();
        generatedLegende = myLineChart.generateLegend();
        toonLegende(myLineChart);
        checkboxDiv.style.backgroundColor = "#337ab7";
        checkboxDiv.style.color = "#ffffff";
    }
}

function checkWerkmannen(dataLineBennie, dataLineAlain, dataLineErik, dataLineJef, myLineChart) {

    // Bennie knop ophalen
    var generatedLegende;
    var checkBennie = document.getElementById("Bennie");
    var checkboxDiv1 = document.getElementById("Checkbox1");

    // Alain knop ophalen
    var checkAlain = document.getElementById("Alain");
    var checkboxDiv2 = document.getElementById("Checkbox2");

    // Erik knop ophalen
    var checkErik = document.getElementById("Erik");
    var checkboxDiv3 = document.getElementById("Checkbox3");

    // Jef knop ophalen
    var checkJef = document.getElementById("Jef");
    var checkboxDiv4 = document.getElementById("Checkbox4");

    if (checkBennie.checked) {
        myLineChart.addData(dataLineAlain);
    }

    if (checkAlain.checked) {
        myLineChart.addData(dataLineAlain);
    }

    if (checkErik.checked) {
        myLineChart.addData(dataLineErik);
    }

    if (checkJef.checked) {
        myLineChart.addData(dataLineJef);
    }
}

function toonLegende(myLineChart) {

    // Genereer legende van grafiek
    generatedLegende = myLineChart.generateLegend();

    // Haal legende element op -> Maak div, vul op met gegenereerde legende -> Hang div aan legende element
    var divLegende = document.getElementById("Legende1");
    var node = document.getElementById("GeneratedLegende");
    node.innerHTML = generatedLegende;
    divLegende.appendChild(node);
}

function toonLegende2(myLineChart) {

    // Genereer legende van grafiek
    generatedLegende = myLineChart.generateLegend();

    // Haal legende element op -> Maak div, vul op met gegenereerde legende -> Hang div aan legende element
    var divLegende = document.getElementById("Legende2");
    var node = document.getElementById("GeneratedLegende2");
    node.innerHTML = generatedLegende;
    divLegende.appendChild(node);
}

function GetDateRange()
{
    var minY = 10000;
    var maxY = 0;
    var minM =  30;
    var maxM = 0;
    var daypermonth = [31,28,31,30,31,30,31,31,30,31,30,31];
    //years

     for(var i = 0;i<StartTimezzz.length;i++)
    {
        var dates = StartTimezzz[i][0].split(" ");
        if(dates[0]< minY)minY = dates[0];
        if(dates[0]> maxY)maxY = dates[0];
    }
    //monts

   for(var i = 0;i<StartTimezzz.length;i++)
    {
        var dates = StartTimezzz[i][0].split(" ");
        if(dates[0] == minY)
        {
            if(dates[1]< minM) minM = dates[1];
        }
        if(dates[0]==maxY)
        {
            if(dates[1]> maxM) maxM = dates[1];
        }
    }


    //maak legende
    var years = maxY - minY;
    var months = maxM - minM + years*12;
    var temp = parseInt(minM) + parseInt(months);
    var days = 0;
    for(var i = minM;i<=temp;i++)
    {
        var month = i;
        if(i > 12)
        {
            month = i-12;
        }

        days += daypermonth[month-1];
    }


    var legende = [];
    var day = 1;
    var month = minM;
    var year = minY;

    for(var i = 0;i<days;i++)
    {
        var legenddate = year + " "+ month + " "+ day;
        legende.push(legenddate);
           day++;
           if(day > daypermonth[month-1])
           {
               month++;
               day = 1;
           }
            if(month > 12)
            {
                year++;
                month = 1;
            }
    }

    return legende;
}



function toonGrafiek2() {

    // Grafiek van algemeen overzicht
    var ctx2 = document.getElementById("myChart2").getContext("2d");

    var legende = GetDateRange();
    var valuesINC = [];
    var valuesOUT = [];

    for(var i = 0;i<legende.length;i++)
    {
        var returnvalue = finddouble(legende[i],StartTimezzz);
        if(returnvalue<= -1)
        {
            valuesINC.push(0);
        }
        else
        {
            valuesINC.push(StartTimezzz[returnvalue][1]);
        }

        returnvalue = finddouble(legende[i],FinishDatezzz);
        if(returnvalue<= -1)
        {
            valuesOUT.push(0);
        }
        else
        {
            valuesOUT.push(FinishDatezzz[returnvalue][1]);
        }
    }


    //hier aanpassen
    var data2 = {
        labels: legende,
        datasets: [
            {
                label: "Gemeldde defecten",
                fillColor: "rgba(230, 126, 34,0.2)",
                strokeColor: "rgba(230, 126, 34,1)",
                pointColor: "rgba(230, 126, 34,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(230, 126, 34,1)",
                data: valuesINC
            },
            {
                label: "Opgeloste defecten",
                fillColor: "rgba(0, 177, 106,0.2)",
                strokeColor: "rgba(0, 177, 106,1)",
                pointColor: "rgba(0, 177, 106,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(0, 177, 106,1)",
                data: valuesOUT
            }
        ]
    };

    var options2 = {

        ///Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - Whether the line is curved between points
        bezierCurve : true,

        //Number - Tension of the bezier curve between points
        bezierCurveTension : 0.4,

        //Boolean - Whether to show a dot for each point
        pointDot : true,

        //Number - Radius of each point dot in pixels
        pointDotRadius : 4,

        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth : 1,

        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius : 20,

        //Boolean - Whether to show a stroke for datasets
        datasetStroke : true,

        //Number - Pixel width of dataset stroke
        datasetStrokeWidth : 2,

        //Boolean - Whether to fill the dataset with a colour
        datasetFill : true,

        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    };

    var myLineChart2 = new Chart(ctx2).Line(data2, options2);
    toonLegende2(myLineChart2);
}