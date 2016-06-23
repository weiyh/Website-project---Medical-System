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
<br><br><center>
<?
require "config.php";
///
		if($did==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	
///

?>
<!--im-->
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<hr><br>
<h2>藥品庫存</h2><br><br>
<!--im-->
<?
	$str="SELECT * FROM stock"; 
	$result=mysql_query($str, $link);
	$n=mysql_num_rows($result);
	if($n>0) {
		echo "<table><tr><th>藥品代號</th><th>藥品名稱</th><th>數量</th><th>單位</th><th>單價</th></tr>";
		for($i=1;$i<=$n;$i++){
			list($sid, $name, $amount, $unit, $price)=mysql_fetch_array($result);
			echo "<tr><td>$sid</td><td>$name</td><td>$amount</td><td>$unit</td><td>$price</td></tr>";
		}
		echo "</table>";
	}

?>


</center>
</body>
</html>