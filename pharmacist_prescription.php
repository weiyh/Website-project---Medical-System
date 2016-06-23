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
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  藥劑師您好!<br>
<a href="logout.php">登出系統</a><br>
<br><hr><br>
<center>
<?
	$idnum = $_POST["idnum"];
	$str="SELECT P.pid, P.pname, PP.time, U.depart, U.name, PP.paid
		  FROM patient P, prescription PP, user U
		  WHERE P.idnum='$idnum' AND PP.pid=P.pid AND U.uid=PP.did
		  LIMIT 1;";
	$result=mysql_query($str, $link);
	list($pid, $pname, $time, $depart, $dname, $paid)=mysql_fetch_array($result);
	if($paid==0){
		echo "<h2>病人尚未批價！</h2><br><br>";
		echo '<form method="post" action="pharmacist.php" style="display:inline">';
		echo '<input type="submit" value="回上一頁" class="br2">';
		echo '</form>';
	}
	else{
?>
姓名：<? echo $pname; ?>　身分證字號：<? echo $idnum; ?>　看診日期：<? echo $time; ?><br>
看診科別：<? echo $depart; ?>　醫師：<? echo $dname; ?><br>
<br>
<?
	$str="SELECT S.sid, S.name, P.amount, S.unit, P.uuu 
			  FROM   prescription P, stock S
			  WHERE  (P.sid=S.sid AND P.pid='$pid' AND P.paid='1');";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l!=0){
?>
<div align="center">
<table width="600" height="69">
	<tr><td>NO.</td><td>藥品編號</td><td>藥名</td><td>劑量</td><td>用法</td></tr>
	<?
		for($i=1;$i<=$l;$i++){
			list($psid, $ppname, $pamount, $punit, $puse)=mysql_fetch_array($result);
	?>
	<tr>
		<td><? echo $i ?></td>
		<td><? echo $psid ?></td>
		<td><? echo $ppname ?></td>
		<td><? echo $pamount ?></td>
		<td><? echo $puse ?></td>
	</tr>
	<?  }; } ?>
</table>
</div>
<br><br>
<form method="post" action="pharmacist.php" style="display:inline">
	<input type="hidden" name="pid" value="<? echo $pid; ?>">
	<input type="submit" value="配藥完成" class="br2">
</form>

<? } ?>


</center>




</body>
</html>