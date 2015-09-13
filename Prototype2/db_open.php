<?php
	$dbuser = "mdm2014.01"; //connect login
	$dbpass = "Flupple28+";  //password
	
	$resLink = mysql_connect('localhost', $dbuser,$dbpass);
	if(!$resLink)
	{
		echo "Connect failed<br/>";
		exit();
	}
	
	$resSelect = mysql_select_db($dbuser,$resLink);
	if(!$resSelect)
	{
		echo "Select failed<br/>";
		exit();
	}
?>