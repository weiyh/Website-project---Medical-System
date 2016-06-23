<?
	session_start();
	$uid=$_SESSION['login_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新竹交傲醫院醫療系統</title>
<link rel="stylesheet" href="./template.css" type="text/css">
</head>
<body>
<?php 
require "config.php";
///
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	
	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
///
$pid = $_POST["pid"];
?>
<!--im-->
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  櫃台人員您好!<br>
<a href="logout.php">登出系統</a><br>
<br><hr>
<!--im-->
<br><center>
<form name="formName" method="post" action="counter_patient.php">
	<input type=hidden name="pid" value="<?echo $pid;?>">
	<input type=submit value="個人資料" class="br2">
</form>
<form name="formName" method="post" action="counter_record.php">
	<input type=hidden name="pid" value="<?echo $pid;?>">
	<input type=submit value="病例" class="br2">
</form>
<form name="formName" method="post" action="counter_clinic.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=submit value="候診列表" class="br2">
</form>
<form name="formName" method="post" action="counter_paid.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=submit value="批價" class="br2">
</form>
<form name="formName" method="post" action="counter_ward.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=submit value="住院" class="br2">
</form>
<form name="formName" method="post" action="counter.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=submit value="結束" class="br2">
</form>
<br><br><hr><br>
<?php 

	$str="SELECT R.date, R.record, U.name
	      FROM record R, user U
		  WHERE R.pid='$pid' AND R.did=U.uid;";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l==0){ echo "病人尚未有病例紀錄"; }
	else {
		echo "<table><tr><th>日期</th><th>病例紀錄</th><th>醫生</th></tr>";
		for($i=1;$i<=$l;$i++){
			list($date, $record, $dname)=mysql_fetch_array($result);
			echo "<tr><td>$date</td><td>$record</td><td>$dname</td></tr>";
		}
		echo "</table>";
	}
?>

</center>
</body>
</html>