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
$record = $_POST["record"];
$insert = $_POST["insert"];
$update = $_POST["update"];
if($insert){
	$date=date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))) ;
	$str="INSERT INTO record(pid, date, record, did) VALUES('$pid', '$date', '$record', '$did');";
	$result=mysql_query($str, $link);
}
if($update){
	$str="UPDATE record SET record='$record' WHERE pid='$pid' AND finish='0';";
	mysql_query($str, $link);
}
$er = $_POST["er"];

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
	$str="SELECT P.pname FROM patient P WHERE P.pid='$pid'";
	$result=mysql_query($str, $link);
	$n=mysql_num_rows($result);
	if($n>0){
		list($pname)=mysql_fetch_array($result);   
		$str0="SELECT R.record FROM record R WHERE R.pid='$pid' AND R.finish='0';";
		$result0=mysql_query($str0, $link);
		list($unrecord)=mysql_fetch_array($result0);
?>
<form method="post" action="doctor_record.php">
	病人：<?echo $pname;?><br><br>
	病例：<br><textarea name="record" cols="60" rows="20" class="br"><?echo $unrecord;?></textarea><br><br>
	<input type=hidden name="pid" value='<?echo $pid;?>'>
	<input type=hidden name="er" value='<?echo $er;?>'>
<?
	if($unrecord) echo '<input type="submit" name="update" value="確定" class="br2">';
	else echo '<input type="submit" name="insert" value="確定" class="br2">'; 
?>	
</form><br><br><br>
<?
	}
?>
<!--看之前的病例?-->
<?
	$str="SELECT R.date, R.record, U.name
	      FROM record R, user U
		  WHERE R.pid='$pid' AND R.did=U.uid AND R.finish='1'
		  ORDER BY R.date;";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l==0){ echo "病人尚未有病例紀錄"; }
	else {
		echo "<table><tr><th>日期</th><th>病例紀錄</th><th>醫生</th></tr>";
		for($i=1;$i<=$l;$i++){
			list($date, $record, $dname)=mysql_fetch_array($result);
			echo "<tr><td>$date</td><td>$record</td><td>$dname</td></tr>";
		}
		echo "</table>";
	}         
?>
<br>
</center>
</body>
</html>