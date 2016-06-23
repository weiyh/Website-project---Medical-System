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
	$end = $_POST["end"];
		if($did==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	
	if($end){
		//$date=date ("Y-m-d H:i:s" , mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'))) ;
		$str0="UPDATE record SET finish='1' WHERE pid='$pid' AND did='$did' AND finish='0';";
		$result0=mysql_query($str0, $link);
		$str11="SELECT idnum FROM patient WHERE pid='$pid';";
		$result11=mysql_query($str11, $link);
		list($idnum0)=mysql_fetch_array($result11);
		$str1="DELETE FROM er_check WHERE idnum='$idnum0';";
		$result1=mysql_query($str1, $link);	
		$str="DELETE FROM clinic_list WHERE pid='$pid' AND did='$did';";
		$result=mysql_query($str, $link);	
	}
	
	$result=mysql_query("SELECT * FROM user WHERE uid='$did';",$link);
	$row=mysql_fetch_row($result);
	$uname=$row[2];
?>
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<? echo $uname; ?>  醫生您好!<br>
<a href="logout.php">登出系統</a>　　<a href="doctor_stock.php" target="_blank">看醫院藥品庫存</a><br>
<br><hr>
<br><br><center>
<!--im-->
<?
	$str="SELECT P.pname, C.id, P.pid , C.er
	      FROM clinic_list C, patient P
		  WHERE C.pid=P.pid AND C.did='$did'
		  ORDER BY C.er DESC, C.id;";
		  
	$result=mysql_query($str, $link);
	$n=mysql_num_rows($result);
	if($n==0) echo "目前沒有待看診的病患";
	else{
		echo "<table><tr><th>類型</th><th>順序號碼</th><th>病人</th></tr>";
		for($i=1;$i<=$n;$i++){
			list($pname, $sequence, $pid, $er)=mysql_fetch_array($result);
	
			echo "<tr><td>";
			if($er) echo "急診"; else echo "一般";                      //////////////////////////////////
			echo "</td><td>$sequence</td><td>$pname</td><td>";
?>
			<form method="post" action="doctor_patient.php">
				<input type=hidden name="pid" value="<? echo $pid; ?>">
				<input type=hidden name="er" value="<? echo $er; ?>">              <!--/////////////////////////////////////-->
				<input type=submit value="看診" class="br2">
			</form>
<?
			echo "</td></tr>";
		}
		echo "</table>";
	}

?>


</center>
</body>
</html>