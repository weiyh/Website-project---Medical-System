<?
	session_start();
	$did=$_SESSION['login_id'];
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
	$pid = $_POST["pid"];
	$er = $_POST["er"]; 
		if($did==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	
	$result=mysql_query("SELECT * FROM user WHERE uid='$did';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  醫生您好!<br>
<a href="logout.php">登出系統</a>　　<a href="doctor_stock.php" target="_blank">看醫院藥品庫存</a><br>
<br><hr><br>
<center>
<!--im-->
<?
if($er) {
?>
<form name="formName" method="post" action="doctor_ercheck.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
	<input type=submit value="【急診】觀看護士檢傷結果" class="br2">
</form>
<? } ?>
<form name="formName" method="post" action="doctor_patient.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
	<input type=submit value="觀看病人資料" class="br2">
</form>
<form name="formName" method="post" action="doctor_exam.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
	<input type=submit value="觀看病人檢查報告" class="br2">
</form>
<form name="formName" method="post" action="doctor_record.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
	<input type=submit value="填寫病人病例" class="br2">
</form>
<form name="formName" method="post" action="doctor_prescription.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
	<input type=submit value="填寫病人藥單" class="br2">
</form>
<form name="formName" method="post" action="doctor.php">
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
	<input type=submit name="end" value="看診結束" class="br2">
</form>
<br><br><hr><br>

<?
	$str="SELECT P.pname, E.time, E.report, U.name 
	      FROM exam_report E, patient P, user U
		  WHERE E.pid='$pid' AND E.pid=P.pid AND E.eid=U.uid;"; 
	$result=mysql_query($str, $link);
	$n=mysql_num_rows($result);
	if($n==0) echo "病人目前沒有檢查結果報告";
	else{
		echo "<table><tr><th>病人</th><th>檢查時間</th><th>檢查結果</th><th>檢查人員</th></tr>";
		for($i=1;$i<=$n;$i++){
			list($pname, $time, $report, $ename)=mysql_fetch_array($result);
			echo "<tr><td>$pname</td><td>$time</td><td>$report</td><td>$ename</td></tr>";
		}
		echo "</table>";
	}

?>


</center>
</body>
</html>