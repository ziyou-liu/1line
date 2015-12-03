<?php
error_reporting(0);

header("Content-Type: text/html;charset=gb2312"); 

 include 'globaldata.php';
 session_start();
 
 if( hasParam("card_num") ){
        
        if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
		echo "<script>alert('验证码不匹配!');</script>";// Captcha verification is incorrect.
                
	}else{
     
     
 	$card_num = postV("card_num") ;
	$username = postV("username") ;
        $pwd = postV("pwd") ;
        $taocan = postV("taocan") ;
        $line_num = postV("line_num") ;
        
        $start_time = date('Y-m-d H:i:s');
        
        $jinbi = 0;
        $aibi = 0;
        
        if( $taocan == 3){
             $jinbi = 306;
             $aibi = 306;
        }
        
        if( $taocan == 2){
             $jinbi = 239;
             $aibi = 238;
        }
        
        if( $taocan == 1){
             $jinbi = 128;
             $aibi = 127;
        }
   
	dbInfo();
	$result = mysql_query("select * from addorder where line_num='$line_num' and state=1 limit 1");
//查询
if ($row = mysql_fetch_array($result))
{
echo "<script>alert('该一直线用户ID号之前已经加单成功，请不要重复加单！');</script>";//
}else{
	
	
        $i = mysql_query("insert into addorder (username,kingdom_card,line_num,line_taocan,jinbi,aibi,add_time,state) values ('$username','$card_num','$line_num',$taocan,$jinbi,$aibi,'$start_time',0)");
        $id = mysql_insert_id();
        mysql_close();
 
        if($i>0){
            
            $params = "ReferencNum=$id&Remarks=$line_num&CardNum=$card_num&UserName=$username&password=$pwd&GoldCoin=$jinbi&ICoin=$aibi";
            
            $str =  visit_webservice("TransDirectPurchase",$params);
            
            if( $str != "" ){
                $resultArr = explode("|", $str);
                if($resultArr[0] == "ok"){
                    dbInfo();
                    $i = mysql_query("update  addorder set state=1  where id=$id");
                    mysql_close();
                    
                    if( $i>0 ){
                        echo "<script>alert('一直线套餐".$taocan."购买成功！请去查看金币,爱币扣币情况。另外请不要重复提交信息。');</script>";
                    }else{
                        $myfile = fopen("paysuc_nostate.txt", "w");
                        $txt = "$username:$card_num:$line_num\n";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                        echo "<script>alert('一直线套餐".$taocan."购买成功！但系统出现问题，请联系客服！');</script>";
                    }
                    
                }else{
					$info1 = $resultArr[1];
					$info = iconv("UTF-8", "GB2312", $resultArr[1]); 
					
                    dbInfo();
                    $i = mysql_query("update  addorder set state=2,remark='$info1'  where id=$id");
                    mysql_close();
                    
                    
                    
                    if( $i>0 ){
                        echo "<script>alert('一直线套餐".$taocan."购买失败！".$info."');</script>";
                    }else{
                        echo "<script>alert('一直线套餐".$taocan."购买失败！".$info."');</script>";
                    }
                }
            }
            
        }
 }
 }
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>一直线加单</title>
</head>
<body style="margin:0;">
<link href="./css/style.css" rel="stylesheet">
<script>
function checkname(){
	
        line_num =  fm1.line_num.value;
	if(line_num == ""|| isNaN(line_num) || (!((line_num+"").length == 6)) || (!(line_num+"").startsWith("8"))){
		alert("请输入以8开头的6位数字形式的一直线用户ID号！");
		return false;
	}
        
        card_num =  fm1.card_num.value;
        if(card_num == "" ||  ((card_num+"").length != 16)){
		alert("请输入数字形式的16位卡号！");   
		return false;
	}
        
        username =  fm1.username.value;
	if(username == ""){
		alert("请输入用户名！");   
		return false;
	}
        
        pwd =  fm1.pwd.value;
	if(pwd == ""){
		alert("请输入登录密码！");   
		return false;
	}
        
        return true;
}
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<div  style=" background-color:#00FF99;  background-position:center top; text-align:center; height:800px; ">
	<div style="padding-top: 30px; margin-left:auto; margin-right: auto ; width:100%;"><a href="http://www.1line.club">
		<img src="https://www.1line.club/images/oneline11.png" ></a>
	</div>
	
	<div style=""></div>
	
	<br /><br /><br />
        <center>
       
	<form action="addorder.php" onsubmit="return checkname();" name="fm1" method="post">
            <table cellpadding="6" cellspacing="6">
                <tr>
                    <td rowspan="7" width="300px" style=" border-right-style: solid; border-right-width: 1px;">
                         <font size="2">
                            <strong>  “一直线”加单在线登记说明：</strong><br><br><br>
1、本页面为“一直线”用户直接金币爱币购买加单的登记页面。<br><br>
2、在本页面确保您输入的信息正确。卡号、用户名、登陆密码 。<br><br>
3、一旦提交成功，可以马上查看自己的金币、爱币是否扣除，如果扣除，证明登记成功。<strong>请勿重复提交，否则视为购买多个启动包产品。</strong><br><br>
4、确保您的一直线的ID号输入正确，我们将在扣款的48小时内，将您的一直线对应的账号（ID号）设置成购买了相应的套餐状态。
(如果ID输入错误，无法在一直线查到ID号，我们将取消扣款）
   <br>     <br>                
                    </font>
                        
                    </td>
                    <td align="right">一直线套餐:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="taocan" value="3" checked />306金币+306爱币(套餐3)
                        <br>
                         &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="taocan" value="2"  />239金币+238爱币(套餐2)
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="taocan" value="1"  />128金币+127爱币(套餐1)
                    </td>
                </tr>
                <tr>
                    <td align="right">一直线ID号(8开头的6位数字):</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="line_num"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">购买套餐的16位卡号:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="card_num"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">用户登录名:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="username"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">登录密码:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="pwd"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">验证码:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="captcha_code" name="captcha_code" size="20"  style="height:25px;" />&nbsp;&nbsp;<img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: refreshCaptcha();'>换一个验证码</a></td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="提交"  width="80" height="30" style="width:80; height:30;"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="left">
                        </td>
                </tr>
            </table>  
            
	
	</form>
	</center>
</div>

</div>
</body>
</html>
