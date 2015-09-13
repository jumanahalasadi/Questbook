<?php
//session_start();
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



 		
 		//$userNum = $_GET["UserID"];
		//echo $userNum;
		//echo $_GET["UserID"];
		if (!(isset($_GET['UserID'])))
		{
	
		
			//echo $_GET("userID"); 
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
						echo "<p style ='font-size: 100%;'><a href = '/~MDM2014.01/Prototype2/profile.php?UserID=".$row['UserID']."' style='text-decoration:none'>". $Friendname. "</a><BR></p>";
					}
				}
			}
		}
		
		
		
		else if (isset($_GET['UserID']))
		{
			$newID = $_GET['UserID'];
		
		
		
		
			//echo $_GET("userID"); 
		  
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
						echo "<p style ='font-size: 100%;'><a href = '/~MDM2014.01/Prototype/AnotherProfile.php?UserID=".$row['UserID']."' style='text-decoration:none'>". $Friendname. "</a><BR></p>";
					}
				}
			}
		
		
		
		
		}
			?>
            
                  </div>
        </div>
        

<?php include_once "db_close.php"; ?>