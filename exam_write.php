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
<center><h1>新竹交傲醫院醫療系統</h1></center><br>
<?
	require "config.php";
	if($uid==""){
		echo "<script language='javascript'>"; 
		echo " location='index.php';"; 
		echo "</script>";
	}
	$wid=$_POST["wid"];
	$wname=$_POST["wname"];
	$eterm=$_POST["wterm"];
	
	$t=array("甲狀腺超音波", "胸腔超音波", "乳房超音波", "耳鼻喉科超音波", "腹部超音波", "腎臟超音波", 
			 "上消化道內視鏡", "小腸鏡", "大腸鏡", "膽胰鏡", "支氣管鏡", "內視鏡超音波", "小兒內視鏡", 
			 "心臟超音波", "運動心電圖", "二十四小時心電圖", "心導管檢查", 
			 "肺功能檢查"); //18
			 
	if($wid&&$wname&&$eterm){
?>
<center>
<h2><? echo $wname?>之檢查報告</h2><br>
<br>
<h3>檢查項目：</h3><br>
<? 
	$wterm=array();
	$wterm=explode(",", $eterm);
	for($j=0;$j<count($wterm);$j++){
		echo $t[$wterm[$j]];
		if($j<count($wterm)-1)
			echo "、";
	};
?>
<br><br>
<h3>檢查結果：</h3><br>
<form name="form1" method="post" action="exam.php" style="display:inline">
	<textarea name="words" cols="60" rows="20" class="br"></textarea><br><br>
	<input type="reset" name="reset" value="重新填寫" class="br2">&nbsp;&nbsp;
	<input type="submit" name="submit" value="提交檢查結果" class="br2">
	<input type="hidden" name="wid" value="<? echo $wid; ?>">
</form>
</center>
<? } ?>
</body>


</html>