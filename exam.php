<?
	session_start();
	$uid=$_SESSION['login_id'];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新竹交傲醫院醫療系統</title> 
<link rel="stylesheet" href="./template.css" type="text/css">  
</head>
<body>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<?
	require "config.php";
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	
	$t=array("甲狀腺超音波", "胸腔超音波", "乳房超音波", "耳鼻喉科超音波", "腹部超音波", "腎臟超音波", 
			 "上消化道內視鏡", "小腸鏡", "大腸鏡", "膽胰鏡", "支氣管鏡", "內視鏡超音波", "小兒內視鏡", 
			 "心臟超音波", "運動心電圖", "二十四小時心電圖", "心導管檢查", 
			 "肺功能檢查"); //18
			 
	$words=$_POST["words"];
	$wid=$_POST["wid"];
	if($wid)
	{
		$time=date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))) ;
		$str="SELECT MAX(id) FROM exam_report";
		$result=mysql_query($str, $link);
		list($mid)=mysql_fetch_array($result);
		$mid++;
		$str="INSERT INTO exam_report(id, pid, eid, time, report) VALUES('$mid', '$wid', '$uid', '$time', '$words');";
		mysql_query($str, $link);
		$str="DELETE FROM exam_list WHERE pid='$wid';";
		mysql_query($str, $link);
	}
	
	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
?>
<? echo $uname; ?>  檢查人員您好!<br>
<a href="logout.php">登出系統</a><br>
<br>
<br>
<center>待檢查列表:</center><br>
<?
	$str="SELECT P.pid, P.pname, E.term 
			  FROM   exam_list E, patient P
			  WHERE  (E.eid='$uid' AND E.pid=P.pid)
			  ORDER BY E.id;";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l==0){ echo "<center><table width=\"500\" height=\"69\"  class=\"border_rounded\">";
	           echo "<tr><td height=\"22\"><center> 目前尚無待檢查病人! </center></td></tr></table></center>";
	}
	else{
?>
<div align="center">
<table width="600" height="69">
	<tr><th width=30>NO.</th><th width=100>病人編號</th><th width=70>姓名</th><th>檢查項目</th><th></th></tr>
	<?
		for($i=1;$i<=$l;$i++){
			list($wid, $wname, $eterm)=mysql_fetch_array($result);
	?>
	<tr>
		<td><? echo $i ?></td>
		<td><? echo $wid ?></td>
		<td><? echo $wname ?></td>
		<td><? 
			$wterm=array();
			$wterm=explode(",", $eterm);
			for($j=0;$j<count($wterm);$j++){
				echo $t[$wterm[$j]];
				if($j<count($wterm)-1)
					echo "、<br>";
			};
			?>
		</td>
		<td>
			<form name="form1" method="post" action="exam_write.php" style="display:inline">
				<input type="submit" name="submit" value="填寫檢查報告" class="br2">
				<input type="hidden" name="wid" value="<? echo $wid; ?>">
				<input type="hidden" name="wname" value="<? echo $wname; ?>">
				<input type="hidden" name="wterm" value="<? echo $eterm; ?>">
			</form>
		</td>
	</tr>
	<?  }; } ?>
</table>
</div>
</body>

</html>