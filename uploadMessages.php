<?php
	session_start();
	include_once("db_open.php");
	
	$userID = $_SESSION["userID"];
	$friend = $_SESSION["otherUserID"];
	
	$cMessages = (isset($_REQUEST['text'])) ? $_REQUEST['text'] : "N/A";
	
	$resultInsert = mysql_query("INSERT INTO Message (Text, SenderID, RecieverID) VALUES ('$cMessages', '$userID', '$friend')");
	
	if(!$resultInsert)
		echo mysql_error();
	
	include_once("db_close.php");

?>