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
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<center>
<h2>急診檢傷報告</h2><br>
<form name="form1" method="post" action="nurse.php" style="display:inline">
	病人身分證字號：<input type="text" name="idnum" class="br"><br>
	<br>
	檢傷結果：<br>
	<textarea name="nresult" cols="60" rows="20" class="br"></textarea><br><br>
	<input type="reset" name="reset" value="重新填寫" class="br2">&nbsp;&nbsp;
	<input type="submit" name="submit" value="提交檢傷結果" class="br2">
</form>

</center>

</body>
</html>