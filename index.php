<?php
session_start();
echo '<head>';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
// echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
echo '<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>';
echo '<script type="text/javascript" src="javascript.js"></script>';

echo '</head>';
set_time_limit(0);
ini_set("memory_limit","512M");
// error_reporting(E_ALL);

$str_data = file_get_contents('https://opendata.ecdc.europa.eu/covid19/casedistribution/csv');
//echo $str_data;

$arr_data = explode("\n", $str_data);

unset($arr_data[0]);
$arr_sorted_data = [];
$arr_countries = [];
foreach($arr_data as $dataEntry){
    @$arr_dataEntry = explode(",", $dataEntry);
    $str_date = str_replace('/', '-', $arr_dataEntry[0]);
    $str_date = date('d-m-Y',(strtotime ('-1 day',strtotime($str_date))));
    if(!in_array($arr_dataEntry[6], $arr_countries)) $arr_countries[] = $arr_dataEntry[6];
    @$arr_sorted_data[$arr_dataEntry[6]]['total_cases'] += $arr_dataEntry[4];
    @$arr_sorted_data[$arr_dataEntry[6]][$str_date]['cases'] = $arr_dataEntry[4];
}

$_SESSION['countries'] = $arr_countries;
$_SESSION['graph_data'] = $arr_sorted_data;

echo '<div id="searchBarContainer" style="text-align: center;">';
echo '<div style="position: relative;">';
echo '<input type="text" onkeyup="countrySearchUpdate(this.value);"></input>';
echo '</div>';
echo '</div>';

echo '<div id="buttonHolder">';
foreach($arr_countries as $country){
    echo '<button onclick="loadData(\'' . $country . '\');">' . $country . '</button>';
}
echo '</div>';

echo '<div id="chart_container"></div>';
//echo '<pre>'; print_r($arr_sorted_data); echo '<pre>';

?>