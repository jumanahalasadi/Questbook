<?php
session_start();
include_once "checkSession.php";
	
	if (checkCookie() == true){
		$userID = $_SESSION['userID'];

	}
	else 
		header("Location: index.php"); 



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once "db_open.php"; ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	<title>Profile</title>
    
    <style>
	
	</style>
</head>
<?php

/*while($rowData = mysql_fetch_assoc($resultQuery))
{	
echo $rowData['CreatorID'] . " : CreatorID" . "</br>";
echo $rowData['Text']. " : Status" . "</br>"; 
echo $rowData['Date']. " : Date" . "</br>";
echo $rowData['Likes']. " : Likes" . "</br>";
}*/
 
?>
<body>
	<div id="topPage">
    	<div id="cornerLogo">
    		<a href="homepage.php"><img src="Images/logo2.png" width="217px" />
        </div>
	
    	<div id="profileTabActive"><a href="profile.php" style="text-decoration:none"><h3>MY PROFILE</h3></a></div>
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
        
        <div id="Messages">
       		<a href="editprofile.php" style="text-decoration:none"> <h2>Profile Settings</h2> <div id="edit"><img src="Images/edit.png" width="20px;" TOP:"30px";/></div></a>
        </div>
        
       	<div id="Messages">
       		<a href="messages.php" style="text-decoration:none"> <h2>Messages</h2> </a>
        </div>
        
        <div id="Circle">
       		 <a href="circle.php" style="text-decoration:none"><h2>Circle</h2> </a>
        </div>
        
        <div id="CompletedQuests" >
       		 <a href="CompletedQuests.php" style="text-decoration:none"> <h2>Completed Quests</h2></a>
        </div>
    </div>
    
    <div id="WrapperTop">
    		
    </div>
    
   
    <div id = "wrapper">
    
    
     <?php
	 $userID = $_SESSION['userID'];
		$ID = (int) $userID;
$sql = "SELECT Post.PostID, Post.CreatorID, Post.Text, Post.Date, Post.Likes, User.Username FROM Post INNER JOIN User ON Post.CreatorID = User.UserID WHERE Post.CreatorID = $ID ORDER BY Post.Date  DESC";
$resultQuery = mysql_query($sql);



	 
	 
	  while($rowData = mysql_fetch_assoc($resultQuery))
	{ 
	
		$p_ID = $rowData['PostID'];
	
	
	?>
        <div id = "postsPROFILE">
       		<div id="username">
            	<h1><?php 
				
			$userID = $_SESSION['userID'];
		
				$sql = "SELECT Username FROM User WHERE UserID = $userID ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$user = $row["Username"];
					
					
					 	echo "<h3>" . $user ." </h3>";
						}?></h1>
            	<!--<img src="Images/namebar.png" width="138%" />-->
            </div>
        
        
        	<div id="questname">
            
            	<h1><?php 
				
				 $userID = $_SESSION['userID'];
		$ID = (int) $userID;
				
				$questname = "SELECT Quests.Name, Quests.QuestID, Requests.ChallengerID, Requests.QuestID, Post.PostID FROM Quests INNER JOIN Requests ON Quests.QuestID = Requests.QuestID INNER JOIN Post ON Post.PostID = Requests.PostID WHERE Requests.RecieverID = $ID AND Post.PostID = $p_ID"; 
$QuestQuery = mysql_query($questname);

						while($row = mysql_fetch_assoc($QuestQuery)){
						
						$q = $row["Name"];
						
					
					 	echo "<h3>" . $q ." </h3>";
						}
						?></h1>
            </div>
            
			<div id="postText">
				<p><?php echo "</br>" . "</br>" . "</br>" . $rowData['Text']; ?></p>
            </div>
            
        	<div id="specifics">
            	<h1>ReQuested By: <?php echo $rowData['Username']; ?></h1>
                <h2>Date: <?php echo $rowData['Date']; ?></h2>
            </div>
            
            <div id ="like">
                <a href = "#"><img src="Images/like.png" width="38%" /></a>
                
                <div id="likeNumber">
                	<?php echo $rowData['Likes']; ?>
                </div>
            </div>
            
            <div id ="comments">
                <a href = "#"><img src="Images/comments.png" width="38%" /></a>
            </div>
        </div>
        <div id="space">
        
      
        </div><!--separator-->
        <?php } ?>
    </div>		
	
    
</body>
<?php include_once "db_close.php"; ?>
</html>