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

$inward = $_POST["in_ward"];
$outward = $_POST["out_ward"];
$wid = $_POST["wid"];
if(isset($inward)){
	$str="UPDATE ward SET pid='$pid' WHERE wid='$wid';";
	mysql_query($str, $link);
}
if(isset($outward)){
	$str="UPDATE ward SET pid='0' WHERE wid='$wid';";
	mysql_query($str, $link);
}
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
<br><br><hr><br><?php 
$str0="SELECT wid FROM ward WHERE pid='$pid';";
$result0=mysql_query($str0, $link);
$n0=mysql_num_rows($result0);
if($n0==0){ 	
	$str="SELECT wid FROM ward WHERE pid='0';";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l==0){ 
		echo "目前醫院病房無空床，請轉院";
	}
	else {
		echo "醫院病房有空床<br><br>確定登記入院？";
		list($wid)=mysql_fetch_array($result);
?>
		<form name="ward" method="post" action="counter_ward.php">
			<input type="hidden" name="wid" value="<? echo $wid; ?>">
			<input type="hidden" name="pid" value="<? echo $pid; ?>"><br><br>
			<input type="submit" name="in_ward" value="確定" class="br2">
		</form>
<?		
	}
}
else {
	list($wid0)=mysql_fetch_array($result0);
	echo "病人目前的病床號：";
	echo $wid0;
	echo "<br><br>是否要登記出院？";
?>
		<form method="post" action="counter_ward.php">
			<input type="hidden" name="wid" value="<? echo $wid0; ?>">
			<input type='hidden' name='pid' value='<? echo $pid; ?>'><br><br>
			<input type="submit" name="out_ward" value="確定" class="br2">
		</form>
<?
}
?>
</center>
</body>
</html>