<?php
	//commenting
	session_start();
	include_once "checkSession.php";
		
		if (checkCookie() == true){
			$userID = $_SESSION['userID'];
	
		}
		else 
			header("Location: index.php"); 
	
	
	include_once "db_open.php";	
	
	$pid = $_REQUEST['id']; //post id
	
	
	
	if (isset($_REQUEST['msg'])) {	
		$string = $_REQUEST['msg']; 
		$INSERT = mysql_query("INSERT INTO Comments (UserID, PostID, CommentText, Date) VALUES ($userID, $pid, '$string' , NOW())");
		//echo "Comment Posted";
	}
	include_once "db_close.php";
?>