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
<?
	require "config.php";
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	$p_pid=$_POST["print_pid"];
	$p_time=$_POST["print_time"];
	$p_pname=$_POST["print_pname"];
	$p_idnum=$_POST["print_idnum"];
	$p_depart=$_POST["print_depart"];
	$p_dname=$_POST["print_dname"];
	if($p_pid){
?>

<center>
<h1>新竹交傲醫院 【藥單】</h1><br>
<h3>請先至櫃檯批價再至領藥處領藥</h3><br>
<br><br>
姓名：<? echo $p_pname; ?>　身分證字號：<? echo $p_idnum; ?>　看診日期：<? echo $p_time; ?><br>
看診科別：<? echo $p_depart; ?>　醫師：<? echo $p_dname; ?><br>
<br>
<?
	$str="SELECT S.sid, S.name, P.amount, S.unit, P.uuu 
			  FROM   prescription P, stock S
			  WHERE  (P.sid=S.sid AND P.pid='$p_pid' AND P.paid='0');";
	$result=mysql_query($str, $link);
	$l=mysql_num_rows($result);
	if($l!=0){
?>
<div align="center">
<table width="600" height="69">
	<tr><td>NO.</td><td>藥品編號</td><td>藥名</td><td>劑量</td><td>用法</td></tr>
	<?
		for($i=1;$i<=$l;$i++){
			list($psid, $pname, $pamount, $punit, $puse)=mysql_fetch_array($result);
	?>
	<tr>
		<td><? echo $i ?></td>
		<td><? echo $psid ?></td>
		<td><? echo $pname ?></td>
		<td><? echo $pamount ?></td>
		<td><? echo $puse ?></td>
	</tr>
	<?  }; } ?>
</table>
</div>
<br>
<form name="form1" method="post" action="nurse.php" style="display:inline">
	<input type="submit" name="print" onClick="window.print();" value="列印" class="br2">
	<input type="hidden" name="print_pid" value="<? echo $p_pid; ?>">
</form>

</center>
<? } ?>
</body>


</html>