<?php
	$id = intval($_GET['id']);
	session_start();
?>

<?php

// page loads and does not cache because AJAX cannot uncache the image
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
//is imageID valid and ready to be used
//echo "hi";
	
	$userID = $_SESSION['userID'];
	if(isset($_REQUEST['id']))
	{
		include 'db_open.php';
		//$pid = $_REQUEST['ID'];
		
		$check = mysql_query("SELECT UserID FROM Likes WHERE PostID = $id AND UserID = $userID");
		if(!$check) echo mysql_error();
		else
		{
			while($crosscheck = mysql_fetch_array($check))
			{
				$UserInTable = $crosscheck['UserID'];
			}
		}
		
		if(isset($UserInTable)==false){
		//if($UserInTable != $userID)
			$r = mysql_query("INSERT INTO Likes (UserID,PostID) VALUES ($userID,$id)");
			
			$sql = "SELECT LikeID FROM Likes WHERE PostID = $id ";
			$result = mysql_query($sql);
			$likes = mysql_num_rows($result);
			
			$updatelikes = mysql_query("UPDATE Post SET Likes=$likes WHERE PostID=$id");
			
			//echo $likes;
		}
		
		$NumOfLikes;
		
		$display = mysql_query("SELECT Likes FROM Post WHERE PostID = $id");
		if(!$display) echo mysql_error();
		else
		{
			while($num = mysql_fetch_array($display))
			{
				$NumOfLikes= $num['Likes'];
			}
			
		}
		//echo ":P";
		echo $NumOfLikes;
		include 'db_close.php';
		
		
	}
	?>