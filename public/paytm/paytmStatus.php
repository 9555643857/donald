<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$ORDER_ID = "";
$requestParamList = array();
$responseParamList = array();

// $requestParamList = array("MID" => 'DONALD00058424809411' , "ORDERID" => "ORDERa5cdd0870ea04351a02768b39d004f48"); 
$requestParamList = array("MID" => 'Donald10808253656312' , "ORDERID" => "ORDERa5cdd0870ea04351a02768b39d004f48"); 


$checkSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
$requestParamList['CHECKSUMHASH'] = urlencode($checkSum);

$data_string = "JsonData=".json_encode($requestParamList);
echo $data_string;

$ch = curl_init(); // initiate curl
$url = PAYTM_STATUS_QUERY_URL; //Paytm server where you want to post data

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch); // execute
$info = curl_getinfo($ch);

$data = json_decode($output, true);
echo "<pre>";
print_r($data);
echo "</pre>";
?>