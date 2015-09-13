<?php
session_start();
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
   <title>Challenge Pop Up</title>
   <style>
   
		html, body {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
			background-color: grey;
		}
		
		#container {
			width: inherit;
			height: inherit;
			margin: 0;
			padding: 0;
			background-color: grey;
		}
			
		h1, h2 {
			margin: 0;
			padding: 0;
		}
			
		#challenge {
			margin-left: -750px;
			margin-top: -150px;
			padding: 0;
		}
		
	</style>
</head>

<body>
        <?php include_once "db_open.php"; ?>
        
        <div id="container"> 
        
          <h1>Challenge</h1>
         
          </br>
          </br>
         
        <?php
		  
			if(isset($_POST['dropdown'])){ //if user selected a friend from drop down	
				//1. SET VALUES
				$reciever = $_POST['dropdown']; //select friend as reciever
				$q_id = $_POST['qid']; //set quest id to be challenged	
				
				//Check if the user has done that quest
				$check = mysql_query("SELECT ID FROM Requests WHERE QuestID = $q_id AND RecieverID = $reciever");
				$donethisbefore = mysql_num_rows($check);
				
				if ($donethisbefore){
					echo "</br>";
					echo "Error: User already has this requested: Cannot send quest!";
						echo "</br>";
					
				}
				else {
				
				
				//2. SQL TO REQUEST THE PERSON
					$sql = "INSERT INTO Requests (ChallengerID , RecieverID , QuestID, Completed) VALUES ( '$userID' , '$reciever' , '$q_id ', 0)";			
					$result = mysql_query($sql);
						echo "</br>";
					echo "Challenge sent! ";
						echo "</br>";
					
				}
			}
			
			if(isset($_GET['action'])){ //if the user clicked challenge on the previous page
				
				 if(isset($_GET['action']) && $_GET['action'] == "challenge" ) { //if action == challenge
								
					$qid = $_GET['quest']; //get the quest id			
					$sql = "SELECT Name, Description FROM Quests WHERE QuestID = $qid "; //Get information about quest from quest ID
					$result = mysql_query($sql);		
								
					while($rowz = mysql_fetch_assoc($result)){				
						$name = $rowz['Name'];
						$d = $rowz['Description'];				
						echo "<strong>" . $name . "</strong>";
						echo "<p>" . $d . "</p>";							
					}
		
								
					echo "<h2>" . "Choose Friend:" . "</h2>";
								
					//Creating dynamic drop down of users friends!		
					$sql2 = "SELECT User.Username, User.UserID FROM User INNER JOIN Friends ON User.UserID = Friends.FriendID WHERE Friends.UserID = '$userID' ";			
					$result2 = mysql_query($sql2);
								
					echo "<div id='challenge'>";
								
						echo "<form method='post' action='challenge.php'>";
									
						echo "<select id='friends' name='dropdown'>";			
						while($row = mysql_fetch_assoc($result2)){
										
							$name = $row['Username'];
							$id = $row['UserID'];						
							echo "<option value='$id'>" . $name . "</option>";
										
						}		
						echo "</select>";		
									
						echo "<input type='submit' value='Request' name='submit'>";		
						echo "<input type='hidden' value='$qid' name='qid'>";							
						echo "</form>";		
									
								
					echo "</div>";					
								
				}		
			}
			
			else
				echo "Please close this page. ";
			
		?>
        
        </div>
        
        <?php include_once "db_close.php"; ?>
</body>
</html>