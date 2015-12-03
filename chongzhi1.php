<?php
 
 $kingdom1 = trim($_POST["kingdom1"]);
 $lastname1 = trim($_POST["lastname1"]);
 $firstname1 = trim($_POST["firstname1"]);
 
 if( $username != "" ){
 
 	
	$kingdom1 = addslashes($kingdom1);
	$lastname1 = addslashes($lastname1);
	$firstname1 = addslashes($firstname1);
	
	
	
	
 	if( $kingdom1 == "" || $lastname1 == "" || $firstname1 == "" ){
	  echo "<div>请输入万通卡号或者您的姓或名</div>";
 	}else{
	
	
	$kingdom1 = str_replace(" ","",$kingdom1);
	$lastname1 = str_replace(" ","",$lastname1);
	$firstname1 = str_replace(" ","",$firstname1);
	
	$post_string = "kingdom1=$kingdom1&lastname1=$lastname1&firstname1=$firstname1";
	$request = curl_init($post_url); // initiate curl object
	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
	$post_response = curl_exec($request); // execute curl post and store results in $post_response
	// additional options may be required depending upon your server configuration
	// you can find documentation on curl options at http://www.php.net/curl_setopt
	curl_close ($request); // close curl object
	
	
	if( $username == "qetbcz" ){
		header("Location: https://office.1line.club/membertoolsdotnet/enrollmentnew/startpublicenrollment.aspx");
	   // echo "<script type='text/javascript'>location.href='https://office.1line.club/membertoolsdotnet/enrollmentnew/startpublicenrollment.aspx';return;
		exit;
	}else{
		header("Location: https://office.1line.club/$username");
		
		exit;
	}
	
	}
	
 
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>万通卡充值</title>
</head>
<body style="margin:0;">
<script>
function checkname(){
	kingdom1 =  fm1.kingdom1.value;
	lastname1 =  fm1.lastname1.value;
	firstname1 =  fm1.firstname1.value;
	
	if(kingdom1 == ""){
		alert("请输入万通卡号.");
		return false;
	}
	if(lastname1 == ""){
		alert("请输入名.");
		return false;
	}
	if(firstname1 == ""){
		alert("请输入姓.");
		return false;
	}
	return true;
}
</script>

<div  style=" background-color:#00FF99;  background-position:center top; text-align:center; height:800px;">
	<div style="padding-top: 190px; margin-left:auto; margin-right: auto ; width:20%;"><a href="http://www.1line.club">
		<img src="https://www.1line.club/images/oneline11.png" ></a>
	</div>
	
	<br /><br />
	<form action="chongzhi1.php" onsubmit="return checkname();" name="fm1" method="post">
<center>
	<table cellpadding="5px" cellspacing="5px">
	
	<tr>
	 <td colspan="2">请输入要充值的万通卡号:</td>
	 <td colspan="2"><input type="text" name="kingdom1"  size="30"  style="height:25px;" /></td>
	</tr>
	<tr>
	 <td>姓:</td>
	 <td><input type="text" name="lastname1"  size="15"  style="height:25px;" /></td>
	 <td>名:</td>
	 <td><input type="text" name="firstname1"  size="15"  style="height:25px;" /></td>
	</tr>
	<tr>
	 <td colspan="4" align="center"><input type="submit" value="下一步" /></td>
	</tr>
	
	</table></center>
	</form>
	</div>

</div>
</body>
</html>
