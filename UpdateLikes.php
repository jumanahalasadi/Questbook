<?php
	//$id = intval($_GET['id']);
	session_start();
	include 'db_open.php';


// page loads and does not cache because AJAX cannot uncache the image
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
//is imageID valid and ready to be used
//echo "hi";
	
	
	//if(isset($_SESSION['PostID']))
	//{
		//$id = $_SESSION['PostID'];
		
		$id = $_REQUEST['postid'];
		
		//$sql = "SELECT Likes FROM Likes WHERE PostID = $id ";
		//$result = mysql_query($sql);
		//$likes = mysql_num_rows($result);
		
		//echo $likes;
		
		
		$sql = mysql_query("SELECT Likes FROM Post WHERE PostID = $id ");
		
		while($result = mysql_fetch_array($sql))
		{
			$likes = $result['Likes'];
		}
		echo $likes;
		//echo ":P";
		//echo $id;
	//}
		include 'db_close.php';
?>