<?php

$link = mysql_connect('localhost', 'se2012haha', 'se2012haha') or
die("mysql_connect() failed.");

mysql_select_db("se2012") or
die("mysql_select_db() failed.");

mysql_query('SET NAMES utf8');
mysql_query('SET CHARACTER_SET_CLIENT=utf8');
mysql_query('SET CHARACTER_SET_RESULTS=utf8');

?>