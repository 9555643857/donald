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

$requestParamList = array("MID" => DONALD00058424809411 , "ORDERID" => $_POST["ORDER_ID"]); 

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



<!-- old code -->

<!-- <?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
$checkSum = "";

// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
$findme   = 'REFUND';
$findmepipe = '|';

$paramList = array();

$paramList["MID"] = '';
$paramList["ORDER_ID"] = '';
$paramList["CUST_ID"] = '';
$paramList["INDUSTRY_TYPE_ID"] = '';
$paramList["CHANNEL_ID"] = '';
$paramList["TXN_AMOUNT"] = '';
$paramList["WEBSITE"] = '';

foreach($_POST as $key=>$value)
{  
  $pos = strpos($value, $findme);
  $pospipe = strpos($value, $findmepipe);
  if ($pos === false || $pospipe === false) 
    {
        $paramList[$key] = $value;
    }
}


  
//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
//print_r($_POST);
 echo json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"], "payt_STATUS" => "1"));
  //Sample response return to SDK
 
//  {"CHECKSUMHASH":"GhAJV057opOCD3KJuVWesQ9pUxMtyUGLPAiIRtkEQXBeSws2hYvxaj7jRn33rTYGRLx2TosFkgReyCslu4OUj\/A85AvNC6E4wUP+CZnrBGM=","ORDER_ID":"asgasfgasfsdfhl7","payt_STATUS":"1"} 
 
?> -->