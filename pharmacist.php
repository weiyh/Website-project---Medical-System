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
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
	
	$pid = $_POST["pid"];
	if($pid){
		$str="SELECT S.sid, P.amount, S.amount
			  FROM   prescription P, stock S
			  WHERE  P.sid=S.sid AND P.pid='$pid'";
		$result=mysql_query($str, $link);
		$l=mysql_num_rows($result);
		if($l!=0){
			for($i=1;$i<=$l;$i++){
				list($psid, $pamount, $samount)=mysql_fetch_array($result);//echo $pamount." ".$samount."<br>";
				$samount2=$samount-$pamount;//echo $samount2."<br>";
				$str="UPDATE stock SET amount='$samount2' WHERE sid='$psid';";
				mysql_query($str, $link);
			};
		}
		$str="DELETE FROM prescription WHERE pid='$pid'";
		mysql_query($str, $link);
	}
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  藥劑師您好!<br>
<a href="logout.php">登出系統</a><br>
<br><hr><br>
<center>
<form name="formName" method="post" action="pharmacist_prescription.php">
	輸入病人身分證號碼：
	<input type="text" name="idnum" class="br"><br><br>
	<input type=submit class="br2"> <input type=reset class="br2">
</form>
</center>

</body>
</html>