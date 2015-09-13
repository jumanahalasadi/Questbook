<?php
session_start();
include_once "checkSession.php";
	
	if (checkCookie() == true){
		$userID = $_SESSION['userID'];

	}
	else 
		header("Location: index.php"); 

include_once "db_open.php";


	if (isset($_REQUEST['id'])){ //if passed a post ID to comment on!
		
		$pid = $_REQUEST['id']; //post id

		$SELECT = mysql_query("SELECT UserID, CommentText, Date FROM Comments WHERE PostID = $pid ORDER BY Date DESC");

		echo "<a href='javascript:void(0)' onClick='closecomment($pid)' style='color:red;' >" . "Close [X]"  . " </a>"; //to close the comment pop up
		
		//echo a place to enter a new comment
		echo "<div id='input'>"
		. "<input type='text' size='60' id='textp" . $pid . "'>" . "<input type='submit' onclick='sendcomment($pid)' id='commentp" . $pid . "' value='Comment'>
		</div>";
		
		
		//display comments
		echo " <h3> Comments </h3> ";
		
		$count = 0;
		
		while ( $row = mysql_fetch_assoc($SELECT) ){
			
			$date = $row['Date'];
			$id  = $row['UserID'];
			$name = mysql_query("SELECT Username FROM User WHERE UserID = $id");
			
			$rowuser = mysql_fetch_assoc($name);
			echo $date;
			
			$username = $rowuser['Username'];
			echo " " . "<strong>" . $username . "</strong>" . " : " . $row['CommentText'];
			
			echo "</br>";

			$count++; //how many comments
		}
		
	}


include_once "db_close.php";
?>