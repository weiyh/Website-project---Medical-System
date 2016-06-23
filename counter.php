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
<!--im-->
<?
	require "config.php";
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}

	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];

?>
<!--im-->
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  櫃台人員您好!<br>
<a href="logout.php">登出系統</a><br>
<br><hr>
<!--im-->
<br><br><center>
<form name="formName" method="post" action="counter_patient.php">
	病人身分證號碼：
	<input type="text" name="patientIDnum" class="br"><br><br>
	<input type=submit class="br2">
</form>
</center>
</body>
</html>