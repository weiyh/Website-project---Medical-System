<?
session_start();
session_destroy();
echo "<script language='javascript'>"; 
echo " location='index.php';"; 
echo "</script>";
?>