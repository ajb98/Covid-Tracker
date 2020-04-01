<?
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
if($_GET['mode'] == 'load_data'){

    $_SESSION['graph_data'];
    $arr_data = $_SESSION['graph_data'][$_POST['countryKey']];

    //echo json_encode($arr_data);
    $arr_return = [];
    foreach($arr_data as $date=>$cases){
        if(!is_array($cases)) continue;
        $arr_return[] = [$date, $cases['cases']];
    }

    echo json_encode(array_reverse ($arr_return));
}
else if($_GET['mode'] == 'update_buttons'){
    $arr_countries = $_SESSION['countries'];
    $str_html = "";
    foreach($arr_countries as $country){
        if(!($_POST['searchVal'])){
            $str_html .= '<button onclick="loadData(\'' . $country . '\');">' . str_replace('_', ' ', $country) . '</button>';
        }
        else if(strstr(str_replace('_', ' ', strtolower($country)), strtolower($_POST['searchVal']))){
            $str_html .= '<button onclick="loadData(\'' . $country . '\');">' . str_replace('_', ' ', $country) . '</button>';
        }
    }
    echo $str_html;
}


?>