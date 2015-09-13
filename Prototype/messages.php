
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
<?php include_once "db_open.php"; ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	<title>Homepage</title>
    
    <style>
		
		
	</style>
</head>

<?php
 
 $userID = $_SESSION['userID'];
$sql = "SELECT Message.MessageID, Message.Text, Message.SenderID, Message.RecieverID FROM Message INNER JOIN User ON Message.MessageID = User.UserID WHERE Message.RecieverID = $userID";
$resultQuery = mysql_query($sql);
 
?>

<body>
	<div id="topPage">
    	<div id="cornerLogo">
    		<a href="homepage.php">
    		<img src="Images/logo2.png" width="217px" 
            onmouseover="this.src='Images/logo2_hover.png'  "
            onmouseout="this.src='Images/logo2.png'  "
    		onmousedown="this.src='Images/logo2_hover.png'  "/>
            </a>
        </div>
	
    	<div id="profileTab"><a href="profile.php" style="text-decoration:none"><h3>MY PROFILE</h3></a></div>
    	<div id="exploreTab"><a href="explore.php" style="text-decoration:none"><h3>EXPLORE</h3></a></div>
        <div id="requestsTab"><a href="requests.php" style="text-decoration:none"><h3>REQUESTS</h3></a></div>
    
        <div id="logoutName">
        	<?php
			
				$userID = $_SESSION['userID'];
		
				$sql = "SELECT Username FROM User WHERE UserID = $userID ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$user = $row["Username"];
						
					}
					
					echo "<p>" . "Logged in as: "  . "</p>";
					?>
                    <div id="toprightname">
                    <?php
					echo "<h2>" . $user . "</h2>";
					?>
                    </div>
                    <?php
			?>
           
        </div>
        
        <div id="logoutButton">
       		  <a href="index.php?logout=true" style="text-decoration:none"><h1>Log Out</h1></a>
      </div>
    </div>
 
    <div id="settings">
    		<img src="Images/seticon.png" width="30px;" />
        </div>
        
    
    <div id = "sidebar">
    
    	<div id="profile">
        
            <div id = "picture">
                <img src="Images/profilepicture.png" width="68%" />
            </div>
            
            <div id="profileInfo">
                <?php
				 
				$userID = $_SESSION['userID'];
				
				
				 	$sql = "SELECT Username, Level FROM User WHERE UserID =  $userID ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$user = $row["Username"];
						$lvl = $row["Level"];
						
						
					 	echo "<h3>" . $user ." </h3>";
                	
                 		echo "<h1>" . "Level: " . $lvl . "</h1>";
						
					}
				 
				 	$sql = "SELECT FriendID FROM Friends WHERE UserID =  $userID";
					$result = mysql_query($sql);
					$num = mysql_num_rows($result);
				 
				 	echo "<h1>" . "Friends: " . $num . "</h1>";
				 
				 ?>
            </div>
        
        </div>
    
    	<div id="MessagesActive">
       		<a href="messages.php" style="text-decoration:none"> <h2>Messages</h2> </a>
        </div>
        
        <div id="Circle">
       		 <a href="circle.php" style="text-decoration:none"><h2>Circle</h2> </a>
        </div>
        
        <div id="CompletedQuests" >
       		 <a href="CompletedQuests.php" style="text-decoration:none"> <h2>Completed Quests</h2></a>
        </div>
    
    </div>
    
    <div id = "wrapper">
        <div id="heading">
        	<h1>Wall of Fame</h1>
        </div>
         
        <!------------------------------------->
        <div id = "postsREQUESTS">
        	<div id="questsheading">
            	<h3>MESSAGES</h3>
            </div>

        	<div id="messageboxes">
                 
                 
			<?php 
			
			$userID = $_SESSION['userID'];
			$counter = 0;
			while($rowData = mysql_fetch_assoc($resultQuery))
			{	

			?>
			
			<a href="messages.php?msg=<?php $counter; ?>">
            <?php
			
			echo "Message from " . $rowData['SenderID']. "</br>";
			?>
            
			</a>
            <?php
			echo "</br>"; 
			
			if (isset($_GET["msg"])){
				
				if ($counter)
				?>
				<?php echo $rowData['Text']. "  (Message)" . "</br>"; ?> 
				<?php	
				
				
			}
			
			//end of while loop
			}

			?>
            
            
            
            
            
            
            </div>
          
          
          <!--  
            <div style="padding:15px;">
    <table>
        <form action="index.php" method='post'>
            <tr>
                <td><input type='text' name='ReplyMessage' value=''/></td>        
                <td><input type='submit' name='NewUser' value='Reply'/></td>
             </tr>
        </form>
      </table>
 </div>
 -->
        </div>
        
        
        <!------------------------------------->
    </div>
    
</body>
<?php include_once "db_close.php"; ?>
</html>