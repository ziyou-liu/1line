<?php
error_reporting(0);

header("Content-Type: text/html;charset=gb2312"); 

 include 'globaldata.php';
 session_start();
 
 if( hasParam("card_num") ){
        
        if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
		echo "<script>alert('��֤�벻ƥ��!');</script>";// Captcha verification is incorrect.
                
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
//��ѯ
if ($row = mysql_fetch_array($result))
{
echo "<script>alert('��һֱ���û�ID��֮ǰ�Ѿ��ӵ��ɹ����벻Ҫ�ظ��ӵ���');</script>";//
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
                        echo "<script>alert('һֱ���ײ�".$taocan."����ɹ�����ȥ�鿴���,���ҿ۱�����������벻Ҫ�ظ��ύ��Ϣ��');</script>";
                    }else{
                        $myfile = fopen("paysuc_nostate.txt", "w");
                        $txt = "$username:$card_num:$line_num\n";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                        echo "<script>alert('һֱ���ײ�".$taocan."����ɹ�����ϵͳ�������⣬����ϵ�ͷ���');</script>";
                    }
                    
                }else{
					$info1 = $resultArr[1];
					$info = iconv("UTF-8", "GB2312", $resultArr[1]); 
					
                    dbInfo();
                    $i = mysql_query("update  addorder set state=2,remark='$info1'  where id=$id");
                    mysql_close();
                    
                    
                    
                    if( $i>0 ){
                        echo "<script>alert('һֱ���ײ�".$taocan."����ʧ�ܣ�".$info."');</script>";
                    }else{
                        echo "<script>alert('һֱ���ײ�".$taocan."����ʧ�ܣ�".$info."');</script>";
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
<title>һֱ�߼ӵ�</title>
</head>
<body style="margin:0;">
<link href="./css/style.css" rel="stylesheet">
<script>
function checkname(){
	
        line_num =  fm1.line_num.value;
	if(line_num == ""|| isNaN(line_num) || (!((line_num+"").length == 6)) || (!(line_num+"").startsWith("8"))){
		alert("��������8��ͷ��6λ������ʽ��һֱ���û�ID�ţ�");
		return false;
	}
        
        card_num =  fm1.card_num.value;
        if(card_num == "" ||  ((card_num+"").length != 16)){
		alert("������������ʽ��16λ���ţ�");   
		return false;
	}
        
        username =  fm1.username.value;
	if(username == ""){
		alert("�������û�����");   
		return false;
	}
        
        pwd =  fm1.pwd.value;
	if(pwd == ""){
		alert("�������¼���룡");   
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
                            <strong>  ��һֱ�ߡ��ӵ����ߵǼ�˵����</strong><br><br><br>
1����ҳ��Ϊ��һֱ�ߡ��û�ֱ�ӽ�Ұ��ҹ���ӵ��ĵǼ�ҳ�档<br><br>
2���ڱ�ҳ��ȷ�����������Ϣ��ȷ�����š��û�������½���� ��<br><br>
3��һ���ύ�ɹ����������ϲ鿴�Լ��Ľ�ҡ������Ƿ�۳�������۳���֤���Ǽǳɹ���<strong>�����ظ��ύ��������Ϊ��������������Ʒ��</strong><br><br>
4��ȷ������һֱ�ߵ�ID��������ȷ�����ǽ��ڿۿ��48Сʱ�ڣ�������һֱ�߶�Ӧ���˺ţ�ID�ţ����óɹ�������Ӧ���ײ�״̬��
(���ID��������޷���һֱ�߲鵽ID�ţ����ǽ�ȡ���ۿ
   <br>     <br>                
                    </font>
                        
                    </td>
                    <td align="right">һֱ���ײ�:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="taocan" value="3" checked />306���+306����(�ײ�3)
                        <br>
                         &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="taocan" value="2"  />239���+238����(�ײ�2)
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="taocan" value="1"  />128���+127����(�ײ�1)
                    </td>
                </tr>
                <tr>
                    <td align="right">һֱ��ID��(8��ͷ��6λ����):</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="line_num"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">�����ײ͵�16λ����:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="card_num"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">�û���¼��:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="username"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">��¼����:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="pwd"  size="30"  style="height:25px;" /></td>
                </tr>
                <tr>
                    <td align="right">��֤��:</td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="captcha_code" name="captcha_code" size="20"  style="height:25px;" />&nbsp;&nbsp;<img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: refreshCaptcha();'>��һ����֤��</a></td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="�ύ"  width="80" height="30" style="width:80; height:30;"/>
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
