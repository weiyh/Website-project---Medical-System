<?php
session_start();
$in_uid=$_SESSION['login_id'];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新竹交傲醫院醫療系統</title>
<link rel="stylesheet" href="./template.css" type="text/css">
</head>
<body>
<?
require "config.php";
if($in_uid!=""){
	$result = mysql_query("SELECT * FROM user WHERE uid='$in_uid';",$link);
	$row = mysql_fetch_row($result);
	echo "<script language='javascript'>";
	echo " location='"; 
	echo $row[3];
	echo ".php';</script>";
}
?>
<center>
<br><br><br>
<h1>新竹交傲醫院醫療系統</h1><br><br>
<form method="post" action="log_check.php">
帳號：<input type="text" name='in_id' maxlength="15" class="br">
<br><br>
密碼：<input type="password" name='in_pass' maxlength="15" class="br">
<br><br>
<input type="submit" value="登入" name='login' class="br2">
</form>
</center>

</body>
</html>
