<?php
	session_start();
	header("Cache-Control: no-cahce, must-revalidate");
	header("Pragma: no-cache");
	
	include_once("db_open.php");
	
	$userLoggedIn = $_SESSION['userID'];
	
	echo "hello world";
	/*
	$resultSelect = mysql_query("SELECT Message.Text, User.Username
											 FROM Message
											 INNER JOIN User 
											 ON Message.SenderID = User.UserID
											 WHERE (Message.SenderID = $userID AND Message.RecieverID = $friend) OR (Message.SenderID =  $friend AND Message.RecieverID = $userID) ORDER BY Message.MessageID");
	
	if(!$resultSelect)
		echo mysql_error();
	else
	{
		while($rowSelect = mysql_fetch_assoc($resultSelect))
		{
			
			echo $rowSelect['Username'].">>";
			echo $rowSelect['Text'];
			echo "</br>";	
				
			
		}
	}*/
	
	include_once("db_close.php");

?>

