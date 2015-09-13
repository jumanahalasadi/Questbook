<?php
include_once "checkSession.php";
	
	if (checkCookie() == true){
		$userID = $_SESSION['userID'];
	}
	else 
		header("Location: index.php"); 
		
	if (!isset($_SESSION["userID"])){
		header("Location: index.php"); 
	}

?>

<?php include_once "db_open.php"; ?>
  
	<div id="heading">
        <h1>Wall of Fame</h1>
	</div>
 	<div id = "postsREQUESTS">
        	
    	<div id="questsheading">
                <h3>CIRCLE</h3>
        </div>
             
     	<div id="followers"> 

<?php 

		//THIS PAGE WILL RUN IN TWO WAYS:
		//1. Your friends will show
		//2. If you are on someone elses profile their friends will show

		if (!(isset($_GET['UserID']))) //this is if you are not passed a user ID, it just loads your own friends
		{
	
		    $userID = $_SESSION['userID'];
			$CircleQuery = "SELECT 
								User.Username,
								User.UserID
							FROM 
								User
							INNER JOIN Friends 
								ON 
								User.UserID = Friends.FriendID
							WHERE 
								Friends.UserID =".$userID."";
								
			$CircleResult = mysql_query ($CircleQuery);
			$CircleNumOfRows = mysql_num_rows($CircleResult);

			if ($CircleNumOfRows==0)
			{
				echo "You have no friends :'(";	
			}
			
			else{
				if (!$CircleResult)
				{
					echo "NO conection to Friends table";
				}
				else 
				{
					echo "<BR>";
					while ($row = mysql_fetch_array($CircleResult))
					{
						$Friendname = $row[0];
						echo "<p style ='font-size: 100%;'><a href = 'profile.php?UserID=".$row['UserID']."' style='text-decoration:none'>". $Friendname. "</a><BR></p>";
					}
				}
			}
		}
		else if (isset($_GET['UserID'])) //this is if you are passed a user ID, it wont load your own friends but will load the user ID friends passed
		{
			$newID = $_GET['UserID'];
		
			$CircleQuery = "SELECT 
								User.Username,
								User.UserID
							FROM 
								User
							INNER JOIN Friends 
								ON 
								User.UserID = Friends.FriendID
							WHERE 
								Friends.UserID =".$newID."";
								
			$CircleResult = mysql_query ($CircleQuery);
			$CircleNumOfRows = mysql_num_rows($CircleResult);

			if ($CircleNumOfRows===0)
			{
				echo "You have no friends :'(";	
			}
			else{
				if (!$CircleResult)
				{
					echo "NO conection to Friends table";
				}
				else 
				{
					echo "<BR>";
					while ($row = mysql_fetch_array($CircleResult))
					{
						$Friendname = $row[0];
						echo "<p style ='font-size: 100%;'><a href = 'profile.php?UserID=".$row['UserID']."' style='text-decoration:none'>". $Friendname. "</a><BR></p>";
					}
				}
			}
		}
			?>
                 </div>
        </div>
        
<?php include_once "db_close.php"; ?>