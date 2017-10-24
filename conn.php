<?php

	$con = mysql_connect("103.233.8.187", "root", "hpidc@126");
	//设置字符集为utf8
	mysql_query("SET NAMES 'utf8'");

	if (!$con){
		die(mysql_error());
	}

	mysql_select_db("test", $con);
?>
