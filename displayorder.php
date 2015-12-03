<?php

mysql_connect ("localhost","goodiswill",'goodiswill2015');
	mysql_select_db ("oneline");
	mysql_query("set names 'utf8'");
//mysql_query("update travel_witkey_task_bid set task_file='$file_ids' where bid_id=$bid_id");
$result = mysql_query("select username,kingdom_card,line_num,line_taocan,jinbi,aibi,add_time,state,remark from addorder");
//查询
while ($row = mysql_fetch_array($result))
{
echo $row['username']."  |  ".$row['kingdom_card']."  |  ".$row['line_num']."  |  ".$row['line_toacan']."  |  ".$row['jinbi']."  |  ".$row['aibi']."  |  ".$row['add_time']."  |  ".$row['state']."  |  "."  |  ". iconv("utf8", "UTF-8", $row['remark'])."  |<br>  ";
}
mysql_close();

?>