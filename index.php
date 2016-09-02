<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');



if(isset($_GET["term"]))
{
    $js_array=array();
    $fjs_array=array();
    
    
    $val=$_GET["term"];
    $lookup="http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".urlencode($val);
     $file2=simplexml_load_file($lookup);
    
        foreach($file2->children() as $xml)
    {
        $js_array["value"]=(string)$xml->Symbol;
        $js_array["label"]=(string)$xml->Symbol."-".(string)$xml->Name."(".(string)$xml->Exchange.")";
        array_push($fjs_array,$js_array);
        
    }
    echo json_encode($fjs_array);
 }

//if(isset($_SERVER["REQUEST_METHOD"] == "GET"))
//if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["stockname"]!=""&&$_GET["action"]=="searchbutton")		
else if(isset($_GET["stockselect"]))	
{
$x = $_GET["stockselect"];
$y = urlencode($x);
$json_url="http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$y;

$content = file_get_contents($json_url);
echo $content;
}

//if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["stockname"]!=""&& $_GET["action"]=="newsfeed")
	elseif(isset($_GET['newsfeed']))
    {
   
    $stockname = $_GET["newsfeed"];	
    $accountKey = '+v2efZk4AGzC2zqnyU0XtmRCQsqccIHXYVrGmbrWFfU';
    $ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/';    
    $WebSearchURL = $ServiceRootURL . '/v1/News?$format=json&Query=';
    $context = stream_context_create(array(
    'http' => array(
                'request_fulluri' => true,
                'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
                )
            ));
    $request = $WebSearchURL . urlencode( '\'' .$stockname. '\'');
    $response = file_get_contents($request, 0, $context);
    echo $response;
    }


//if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["stockname2"]!=""&& $_GET["action"]=="historicalcharts")
elseif(isset($_GET['highChart']))
{
  $interactive_url='http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters={%22Normalized%22:false,%22NumberOfDays%22:1095,%22DataPeriod%22:%22Day%22,%22Elements%22:[{%22Symbol%22:%22'.$_GET["highChart"].'%22,%22Type%22:%22price%22,%22Params%22:[%22ohlc%22]}]}'; 
  $content=file_get_contents($interactive_url);
   echo $content;	
}

?>