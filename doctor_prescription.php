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
<?
	require "config.php";
	$pid = $_POST["pid"];
		if($did==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	$er = $_POST["er"];
	
	$result=mysql_query("SELECT * FROM user WHERE uid='$did';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
	
	$pres_id=$_POST["pres_id"];
	$pres_amount=$_POST["pres_amount"];
	$pres_use=$_POST["pres_use"];
	
	if($pres_id&&$pres_amount&&$pres_use){ 
		if($did=='20001') $nid='30001';
		else if($did=='20002') $nid='30002';
		else $nid='30003';
		$time=date ("Y-m-d H:i:s" , mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'))) ;
		$str="INSERT INTO prescription(pid, did, nid, time, sid, amount, uuu, paid, print) 
		      VALUES('$pid', '$did', '$nid', '$time', '$pres_id', '$pres_amount', '$pres_use', '0', '0');";
		mysql_query($str, $link);
	}
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  醫生您好!<br>
<a href="logout.php">登出系統</a>　　<a href="doctor_stock.php" target="_blank">看醫院藥品庫存</a><br>
<br><hr>
<br><br>
<center>
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
<h2>填寫藥單</h2><br><br>
<form method="post" action="doctor_prescription.php">
<?
	$str="SELECT sid, name, amount, unit
		  FROM stock
		  WHERE amount>0;";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	echo "<select name='pres_id' class='br'>";
	for($i=0;$i<$l;$i++){
		list($sid, $sname, $samount, $sunit)=mysql_fetch_array($result);
		echo "<option value='$sid'>$sname</option>";
	};
	echo "</select>";
?>
　<input type="text" name='pres_amount' class="br"><? echo $sunit; ?><br><br>
用法：<input type="text" name='pres_use' class="br"><br>
<input type=hidden name="pid" value='<?echo $pid;?>'>
<input type=hidden name="er" value='<?echo $er;?>'><br>
<input type="submit" value="新增" class="br2">
</form><br><br>
<?
	$str="SELECT S.name, P.amount, P.uuu, S.unit
	      FROM prescription P, stock S
		  WHERE P.pid='$pid' AND P.sid=S.sid;";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l!=0){
		echo "<table><tr><td>藥名</td><td>數量</td><td>用法</td></tr>";
		for($i=1;$i<=$l;$i++){
			list($lname, $lamount, $luse, $lunit)=mysql_fetch_array($result);
			echo "<tr><td>$lname</td><td>$lamount$lunit</td><td>$luse</td></tr>";
		}
		echo "</table>";
	}
?>


</center>
</body>
</html>