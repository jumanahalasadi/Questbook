
<?php
session_start();
	include_once("db_open.php");
	
	$userID = $_SESSION['userID'];
	$otherUserID = $_SESSION["otherUserID"];
	
	$cMessages = (isset($_REQUEST['uMessages'])) ? $_REQUEST['uMessages'] : "N/A";
	$resultInsert = mysql_query("INSERT INTO Message (Text, SenderID, RecieverID) VALUES ('$cMessages', '$userID', '$otherUserID')");
	
	if(!$resultInsert)
		echo mysql_error();
	
	include_once("db_close.php");

?>