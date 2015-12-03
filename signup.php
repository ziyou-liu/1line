<?php
 
 $username = $_POST["tuijian_name"];
 
 if( $username != "" ){
 
 	$username = trim($username);
	$username = addslashes($username);
	
 	if($username == ""){
 	}else{
	
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
<title></title>
</head>
<body style="margin:0;">
<script>
function checkname(){
	name =  fm1.tuijian_name.value;
	if(name == ""){
		alert("请输入推荐人代号.");
		return false;
	}
	return true;
}
</script>
<div  style=" background-color:#00FF99;  background-position:center top; text-align:center; height:800px;">
	<div style="padding-top: 190px; margin-left:auto; margin-right: auto ; width:20%;"><a href="http://www.1line.club">
		<img src="https://www.1line.club/images/oneline11.png" ></a>
	</div>
	
	<div style=""></div>
	
	<br /><br />
	<form action="signup.php" onsubmit="return checkname();" name="fm1" method="post">
	 推荐人代号:&nbsp;&nbsp;<input type="text" name="tuijian_name"  size="30"  style="height:25px;" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="注册" />
	</form>
	</div>

</div>
</body>
</html>
