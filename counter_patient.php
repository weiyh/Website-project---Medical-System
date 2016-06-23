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
<?

require "config.php";
///
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
///
$idnum = $_POST["patientIDnum"];
$pid = $_POST["pid"];

$insert = $_POST["insert"];
$pname1 = $_POST["patientName1"];
$pbirth1 = $_POST["patientBirth1"];
$psex1 = $_POST["patientSex1"];
$update = $_POST["update"];
$pname2 = $_POST["patientName2"];
$pbirth2 = $_POST["patientBirth2"];
$psex2 = $_POST["patientSex2"];

if(isset($insert)){
	$str0="SELECT MAX(pid) FROM patient;"; 
	$result=mysql_query($str0, $link);
	list($pid)=mysql_fetch_array($result);
	$pid++;	
	$str="INSERT INTO patient(pid, idnum, pname, psex, pbirth) VALUES('$pid', '$idnum', '$pname1', '$psex1', '$pbirth1');";
	mysql_query($str, $link);
}
else if(isset($update)){
	$str="UPDATE patient SET pname='$pname2', pbirth='$pbirth2', psex='$psex2' WHERE pid='$pid';";
	mysql_query($str, $link);
}

if($pid==0){
	$str="SELECT pid FROM patient WHERE idnum='$idnum';";
	$result=mysql_query($str, $link);
	list($pid)=mysql_fetch_array($result);
}

///
	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
///
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
	if($pid==0){
?>
<form name="profile1" method="post" action="counter_patient.php">
	身分證字號：<?echo $idnum;?><br><br>
	姓名：<input type="text" name="patientName1" class="br"><br><br>
	生日：<input type="text" name="patientBirth1" value="--" class="br"><br><br>
	性別：<input type="radio" name="patientSex1" value="0">男&nbsp;<input type="radio" name="patientSex1" value="1">女<br><br>
	<input type="hidden" name="patientIDnum" value="<?echo $idnum;?>">
	<input type="submit" name="insert" value="新增" class="br1">
</form>
<?
	}
	else{
		$str="SELECT * FROM patient WHERE pid='$pid';";
		$result=mysql_query($str, $link);
		$n=mysql_num_rows($result);
		if($n!=0){
			list($pid, $idnum, $pname, $psex, $pbirth)=mysql_fetch_array($result);
?>

<form name="profile2" method="post" action="counter_patient.php">
	身分證字號：<?echo $idnum;?><br><br>
	姓名：<input type="text" name="patientName2" value="<?echo $pname;?>" class="br"><br><br>
	生日：<input type="text" name="patientBirth2" value="<?echo $pbirth;?>" class="br"><br><br>
	性別：
	<? if($psex==0) echo '<input type="radio" name="patientSex2" value="0" checked>男&nbsp;<input type="radio" name="patientSex2" value="1">女';
	   else echo '<input type="radio" name="patientSex2" value="0">男&nbsp;<input type="radio" name="patientSex2" value="1" checked>女'; ?>	
	<br><br>
	<input type="hidden" name="patientIDnum" value="<?echo $idnum;?>">
	<input type="hidden" name="pid" value="<?echo $pid;?>">
	<input type="submit" name="update" value="修改" class="br1">
</form>

<?
		}
	}
?>






</center>
</body>
</html>