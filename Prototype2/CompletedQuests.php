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
         
        <!-------------------------     Completed quests start here    --------------------------->
        <div id = "postsREQUESTS">
        	<div id="questsheading">
            	<h3>Completed Quests</h3>
            </div>

        	<div id="questsdone">
     <?php

		if (!(isset($_GET['UserID'])))
		{
			//$userID = $_GET['UserID'];
         	$completedQuestsQuery = "
			SELECT 
				Quests.QuestID, 
				Quests.Name, 
				Quests.Description,
				Post.Date
			FROM 
				Quests
				INNER JOIN ( User INNER JOIN Post ON User.UserID = Post.CreatorID) 
				ON Quests.QuestID = Post.QuestID
				INNER JOIN Requests ON Requests.QuestID = Post.QuestID
			WHERE 
				User.UserID = $userID
				AND
				Requests.Completed = 1
			ORDER BY
				Post.Date DESC";
			$completedQuestsResult = mysql_query($completedQuestsQuery);
			$completedQuestsRows = mysql_num_rows($completedQuestsResult);

			if ($completedQuestsRows===0)
			{
				echo "You have zero completed Quests :'(";	
			}
			else{
				if (!$completedQuestsResult)
				{
					echo "No connection with completedQuestsQuery";
				}
				else 
				{
					echo "<BR>";
					while ($row = mysql_fetch_array($completedQuestsResult))
					{
						echo "<div style = 'margin-right:20px; text-align: right;' >". $row['Date']. "<br></div>";
						echo "<h3 style ='color:#db5e0a;'>". $row['Name']. "<br></h3>";
						echo $row['Description']. "<br><hr><br>";
					}
				}
			}	
		}
		else if (isset($_GET['UserID']))
		{
			echo"hoehoe";
			$userID = $_GET['UserID'];
         	$completedQuestsQuery = "
			SELECT 
				Quests.QuestID, 
				Quests.Name, 
				Quests.Description,
				Post.Date
			FROM 
				Quests
				INNER JOIN ( User INNER JOIN Post ON User.UserID = Post.CreatorID) 
				ON Quests.QuestID = Post.QuestID
				INNER JOIN Requests ON Requests.QuestID = Post.QuestID
			WHERE 
				User.UserID = $userID
				AND
				Requests.Completed = 1
			ORDER BY
				Post.Date DESC";
			$completedQuestsResult = mysql_query($completedQuestsQuery);
			$completedQuestsRows = mysql_num_rows($completedQuestsResult);

			if ($completedQuestsRows===0)
			{
				echo "You have zero completed Quests :'(";	
			}
			else{
				if (!$completedQuestsResult)
				{
					echo "No connection with completedQuestsQuery";
				}
				else 
				{
					echo "<BR>";
					while ($row = mysql_fetch_array($completedQuestsResult))
					{
						echo "<div style = 'margin-right:20px; text-align: right;' >". $row['Date']. "<br></div>";
						echo "<h3 style ='color:#db5e0a;'>". $row['Name']. "<br></h3>";
						echo $row['Description']. "<br><hr><br>";
					}
				}
			}	
		}
			 
			
		 ?>
            </div>
        </div>
        
        
        <!------------------------------------->
    
<?php include_once "db_close.php"; ?>