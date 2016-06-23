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
?>
<center>
<h1>新竹交傲醫院醫療系統</h1><br>
<h2>安排檢查程序</h2>

<br><br><br>
<?
	$term=array("甲狀腺超音波", "胸腔超音波", "乳房超音波", "耳鼻喉科超音波", "腹部超音波", "腎臟超音波", 
				"上消化道內視鏡", "小腸鏡", "大腸鏡", "膽胰鏡", "支氣管鏡", "內視鏡超音波", "小兒內視鏡", 
				"心臟超音波", "運動心電圖", "二十四小時心電圖", "心導管檢查", 
				"肺功能檢查"); //18
?>
<form name="form1" method="post" action="nurse.php" style="display:inline">
	輸入病人編號: <input type="text" name="exam_pid" class="br">
	<br><br>
	檢查項目:<br>
	<? for($i=0;$i<18;$i++){ ?>
		<?
			if($i==0) echo '<h3>超音波--  </h3>';
			if($i==6) echo '<br><h3>內視鏡--  </h3>';
			if($i==13) echo '<br><h3>心臟功能--  </h3>';
			if($i==17) echo '<br><h3>呼吸診療--  </h3>';
		?>
		<input type=checkbox value="<? echo $i ?>" name="term[]" class="br"><? echo $term[$i]; ?>
	<? }; ?>
	<br><br>
	安排檢查人員:<br>
	<?
		$str="SELECT U.uid, U.name, S.C
			  FROM user U 
			  LEFT JOIN 
				(SELECT eid, count(*) C 
				 FROM exam_list 
				 GROUP BY eid) S 
			  ON U.uid=S.eid 
			  WHERE U.job='exam';";
		$result=mysql_query($str, $link);
	?>
	<select name="exam_eid" class="br">
		<?
			$l=mysql_num_rows($result);
			for($i=0;$i<$l;$i++){
				list($eid, $ename, $enum)=mysql_fetch_array($result);
				if($enum==NULL)
					$enum=0;
				echo "<option value='$eid'>$ename($enum)</option>";
			};
		?>
	</select>
	<br><br>
	<input type="submit" name="submit" value="送出" class="br2">
</form>

</center>

</body>


</html>