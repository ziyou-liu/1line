<?php

function dbInfo(){
	mysql_connect ("localhost","goodiswill",'goodiswill2015');
	mysql_select_db ("oneline");
	mysql_query("set names 'utf8'");
}

function visit_webservice($serviceName,$paramSet){

	$webServiceUrl="https://www.kingdom.cards/Trade/TransDirect.asmx";
	
	$companyInfo="CompanyId=11000007&Token=9547D21322B72A56DBB14534CC523157";

	$paramSet = "$companyInfo&$paramSet";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"$webServiceUrl/$serviceName");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$paramSet);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);
	return $server_output;
}

function getV($paramName){
    $tmp = $_GET["$paramName"];
    if (!get_magic_quotes_gpc()) { // �ж�magic_quotes_gpc�Ƿ�� 
        $tmp = addslashes($tmp); // ���й��� 
    }
    return trim($tmp);
}
function postV($paramName){
    $tmp = $_POST["$paramName"];
    if (!get_magic_quotes_gpc()) { // �ж�magic_quotes_gpc�Ƿ�� 
        $tmp = addslashes($tmp); // ���й��� 
    }
    return trim($tmp);
}
function requestV($paramName){
    $tmp = $_REQUEST["$paramName"];
    if (!get_magic_quotes_gpc()) { // �ж�magic_quotes_gpc�Ƿ�� 
        $tmp = addslashes($tmp); // ���й��� 
    }
    return trim($tmp);
}
function hasParam($paramName){
    if( isset($_GET["$paramName"]) || isset($_POST["$paramName"]) )
    {
            return true;
    }
    return false;
}
?>
