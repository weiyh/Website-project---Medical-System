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
<?php
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
	//檢傷
	$idnum=$_POST["idnum"];
	$nresult=$_POST["nresult"];
	if($idnum&&$nresult)
	{
		$str="INSERT INTO er_check(idnum, result) VALUES('$idnum', '$nresult');";
		mysql_query($str, $link);
	}
	
	//檢查
	$e_term=array(); 
	$e_term=$_POST["term"];
	$e_pid=$_POST["exam_pid"];
	$e_eid=$_POST["exam_eid"];
	if($e_term&&$e_pid&&$e_eid)
	{
		$str="SELECT MAX(id) FROM exam_list;";
		$result=mysql_query($str, $link);
		list($mid)=mysql_fetch_array($result);
		$mid++;
		$eterm=implode(',', $e_term);
		$str="INSERT INTO exam_list(id, pid, eid, term) VALUES('$mid', '$e_pid', '$e_eid', '$eterm');";
		mysql_query($str, $link);
	}
	
	//印藥單
	$print_pid=$_POST["print_pid"];
	if($print_pid)
	{
		$str="UPDATE prescription SET print='1' WHERE pid='$print_pid';";
		mysql_query($str, $link);
	}
	
	//病床
	$done_wid=$_POST["done_wid"];
	if($done_wid)
	{
		$str="UPDATE ward SET done='1' WHERE wid='$done_wid';";
		mysql_query($str, $link);
	}
	
	//使用者名稱
	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  護士您好!<br>
<a href="logout.php">登出系統</a><br>
<br><hr><br>
<center>
急診檢傷<br><br>
<form name="form1" method="post" action="nurse_check.php" style="display:inline">
	<input type="submit" name="submit" value="填檢傷報告" class="br2">
</form>
<br><br><hr><br>
安排檢查程序<br><br>
<form name="form2" method="post" action="nurse_exam.php" style="display:inline">
	<input type="submit" name="submit" value="安排檢查程序" class="br2">
</form>
<br><br><hr><br>
待列印藥單<br><br>
<?
	$str="SELECT P.pid, P.time, PP.pname, PP.idnum, U.depart, U.name
		  FROM   prescription P, patient PP, user U
		  WHERE  (P.nid='$uid' AND P.pid=PP.pid AND U.uid=P.did AND P.print='0')
		  limit 1;";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l==0){ echo "<center><table width=\"500\" height=\"69\"  class=\"border_rounded\">";
	           echo "<tr><td height=\"22\"><center> 目前尚無待列印藥單! </center></td></tr></table></center>";
	}
	else{
?>
<div align="center">
<table width="500" height="69">
	<tr><th>NO.</th><th>病人編號</th><th>姓名</th><th>時間</th><th></th></tr>
	<?
		for($i=1;$i<=$l;$i++){
			list($p_pid, $p_time, $p_pname, $p_idnum, $p_depart, $p_dname)=mysql_fetch_array($result);
	?>
	<tr>
		<td><? echo $i ?></td>
		<td><? echo $p_pid ?></td>
		<td><? echo $p_pname ?></td>
		<td><? echo $p_time ?></td>
		<td>
			<form name="form1" method="post" action="nurse_print.php" style="display:inline">
				<input type="submit" name="submit" value="列印" class="br2">
				<input type="hidden" name="print_pid" value="<? echo $p_pid; ?>">
				<input type="hidden" name="print_depart" value="<? echo $p_depart; ?>">
				<input type="hidden" name="print_time" value="<? echo $p_time; ?>">
				<input type="hidden" name="print_pname" value="<? echo $p_pname; ?>">
				<input type="hidden" name="print_idnum" value="<? echo $p_idnum; ?>">
				<input type="hidden" name="print_dname" value="<? echo $p_dname; ?>">
			</form>
		</td>
	</tr>
	<?  }; } ?>
</table>
</div>
<br><hr><br>
待入住病人<br><br>
<?
	$str="SELECT W.wid, W.pid, P.pname 
		  FROM   ward W, patient P
		  WHERE  (W.nid='$uid' AND W.done='0' AND W.pid!='NULL' AND W.pid=P.pid)";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l==0){ echo "<center><table width=\"500\" height=\"69\"  class=\"border_rounded\">";
	           echo "<tr><td height=\"22\"><center> 目前尚無等待入住的病人! </center></td></tr></table></center>";
	}
	else{
?>
<div align="center">
<table width="500" height="69">
	<tr><th>NO.</th><th>病人編號</th><th>姓名</th><th>病房編號</th><th></th></tr>
	<?
		for($i=1;$i<=$l;$i++){
			list($wid, $pid, $pname)=mysql_fetch_array($result);
	?>
	<tr>
		<td><? echo $i ?></td>
		<td><? echo $pid ?></td>
		<td><? echo $pname ?></td>
		<td><? echo $wid ?></td>
		<td>
			<form name="form1" method="post" action="nurse.php" style="display:inline">
				<input type="submit" name="submit" value="已入住完畢" class="br2">
				<input type="hidden" name="done_wid" value="<? echo $wid; ?>">
			</form>
		</td>
	</tr>
	<?  }; } ?>
</table>
</div>

</body>
</html>