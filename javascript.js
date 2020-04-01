//google.charts.load('current', {'packages':['corechart']});
//google.charts.setOnLoadCallback(drawChart);
var data = [];
var categories = [];

function drawChart() {
    var options = {
        series: [{
          name: "Cases",
          data: data
      }],
        chart: {
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      title: {
        text: 'Number of new cases a day',
        align: 'left'
      },
      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5
        },
      },
      xaxis: {
        categories: categories,
      }
      };
    
      var chart = new ApexCharts(document.querySelector("#curve_chart"), options);
      chart.render();
}

function loadData(countryKey){
    if($('#chart_container #curve_chart').length){
        $('#chart_container').html("");
        $('#chart_container').html('<div id="curve_chart"></div>');
    }else{
        $('#chart_container').html('<div id="curve_chart"></div>');
    }

    categories = [];
    data = [];
    $.post('ajax.php?mode=load_data', {countryKey: countryKey}, function(json) {
        var obj = JSON.parse(json);
        obj.forEach(element => {
            categories.push(element[0])
            data.push(parseInt(element[1]));
        });

        console.log(categories);
        console.log(data);

        drawChart();
    });
}

function countrySearchUpdate(searchVal){
    console.log(searchVal);
    $.post('ajax.php?mode=update_buttons', {searchVal: searchVal}, function(html){
        console.log(html);
        $("#buttonHolder").html(html);
    });
}