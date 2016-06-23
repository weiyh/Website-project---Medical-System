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
<?php 
require "config.php";
///
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	
	$result=mysql_query("SELECT * FROM user WHERE uid='$uid';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
///
$pid = $_POST["pid"];

$doctor = $_POST["doctor"];
$er = $_POST["patientER"]; 
$inclinic = $_POST["in_clinic"];
if($inclinic){
	$str="SELECT uid FROM user WHERE name='$doctor';"; 
	$result=mysql_query($str, $link);
	list($did)=mysql_fetch_array($result);
$str2="SELECT * FROM clinic_list WHERE did='$did' AND pid='$pid';"; 
$result2=mysql_query($str2, $link);
$n2=mysql_num_rows($result2);
if($n2==0){
	$str0="SELECT MAX(id) FROM clinic_list WHERE did='$did';"; 
	$result0=mysql_query($str0, $link);
	list($id)=mysql_fetch_array($result0);
	$id++;
	$str1="INSERT INTO clinic_list(pid, did, id, er) VALUES('$pid', '$did', '$id', '$er');";
	mysql_query($str1, $link);
}	
}
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

	$str="SELECT U.depart, U.name, C.id 
	      FROM clinic_list C, user U
		  WHERE C.pid='$pid' AND C.did=U.uid;"; 
	$result=mysql_query($str, $link);
	$n=mysql_num_rows($result);
	if($n>0){
		echo "<table><tr><th>科別</th><th>醫生</th><th>順序號碼</th></tr>";
		for($i=1;$i<=$n;$i++){
			list($depart, $dname, $sequence)=mysql_fetch_array($result);
			echo "<tr><td>$depart</td><td>$dname</td><td>$sequence</td></tr>";
		}
		echo "</table><br>";
	}

?>

下拉式選單選科 然後選醫生 加入看診列表<br><br>

<script>
department=new Array();
department[0]=["王風間", "陳永生", "王炳豐", "張世杰", "張智星"];
department[1]=["黑傑克", "黃仲陵", "呂忠津", "鄭博泰"];
department[2]=["楊敬堂", "王培仁", "葉銘權"];	

function renew(index){
	for(var i=0;i<department[index].length;i++)
		document.myForm.doctor.options[i]=new Option(department[index][i], department[index][i]);	// 設定新選項
	document.myForm.doctor.length=department[index].length;	// 刪除多餘的選項
}
</script>

<?

?>

<form name="myForm" method='post' action='counter_clinic.php'>
	<select name="department" size=4 onChange="renew(this.selectedIndex);" class="br"> 
		<option value="內科">內科</option> 
		<option value="外科">外科</option> 
		<option value="小兒科">小兒科</option> 
	</select><br><br>
	<select name="doctor" size=6 class="br">
		<option value="">請先選擇門診科別
	</select><br><br>
	類型：<input type="radio" name="patientER" value="0">一般&nbsp;<input type="radio" name="patientER" value="1">急診<br><br>
	<input type='hidden' name='pid' value='<? echo $pid; ?>'>
	<input name="in_clinic" type=submit value="新增" class="br2">
</form>
</center>
</body>
</html>