<?php
session_start();
$_SESSION['login_id']=$_POST['in_id'];
$in_id=$_POST['in_id'];
$in_pass=$_POST['in_pass'];
$login=$_POST['login'];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Medical Prototype System</title>
<style type="text/css"> 
<!--
	.border_rounded{
	border-radius: 6px; /* Opera 10.5+ */
	-moz-border-radius: 6px; /* Firefox */
	-webkit-border-radius: 6px; /* Safari 和 Chrome */
	background: #d5d5d5; /* 背景色 */
	border: 1px solid #015492; /* 邊框樣式 */
	padding: 5px; /* 邊框空白 */
	}
-->
</style>
</head>
<body bgcolor="#95dac8"><font face="微軟正黑體" color="#015492">
<center>
<br>
<?php 
require "config.php";
if(isset($login)){
	if($in_id==""||$in_pass==""){   //未輸入
		session_destroy();
		echo ("<b>帳號或密碼未輸入</b><br><br>");
		echo ("<a href=\"index.php\"><font color=\"#668ca6\">請再試一次</font></a>");
		exit;
	}
	else if(ereg("^[0-9]",$in_id)&&ereg("^[0-9a-z]",$in_pass)){      //輸入格式正確
		
		$result = mysql_query("SELECT * FROM user WHERE uid='$in_id';",$link);
		
		if($row = mysql_fetch_row($result)){    //有註冊過
			$buf_pass = $row[1];
			if($in_pass != $buf_pass){    //密碼錯誤
				session_destroy();
				echo "<b>密碼錯誤</b><br><br>";
				echo "<a href=\"index.php\"><font color=\"#668ca6\">請再試一次</font></a>";
			}
			else{        //密碼正確
				echo "<script language='javascript'>";
				echo " location='"; 
				echo $row[3];
				echo ".php';</script>";
			}
		}
		else{   //帳號沒被註冊過
			session_destroy();
			echo "<b>帳號輸入錯誤！使用者中無此帳號</b><br><br>";
			echo "<a href=\"index.php\"><font color=\"#668ca6\">請再試一次</font></a> 或 ";
		}
	}
	else{  //輸入格式錯誤
		session_destroy();
		echo "<b>輸入格式錯誤!!<br>帳號密碼必須為0~9的阿拉伯數字或a~z的小寫英文字母</b><br><br>";
		echo "<a href=\"index.php\"><font color=\"#668ca6\">請再試一次</font></a>";
	}
}
?>
</center>
</font>
</body>
</html>