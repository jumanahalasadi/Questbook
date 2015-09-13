<?php
session_start();
 include_once "checkSession.php";
	
	if (checkCookie() == true){
		$userID = $_SESSION["userID"];
		//$_SESSION['userID'] = $userID;

	}
	else 
		header("Location: index.php"); 
		
	if (!isset($_SESSION["userID"])){
		header("Location: index.php"); 
	}
?>

<?php include_once "db_open.php"; ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	<title>AnotherProfile</title>
    
    <style>
		
		
	</style>
</head>

<body>
	<div id="topPage">
    	<div id="cornerLogo">
    		<a href="homepage.php"><img src="Images/logo2.png" width="217px" />
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
				 
				 
				$userID = $_GET['UserID'];
				
				
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
       		 <h2>Message</h2>
        </div>
                
        <div id="Circle">
       		 <h2>Circle</h2>
        </div>
        
        <div id="Follow">
       		 <h2>Follow</h2>
        </div>
        
        <div id="CompletedQuests" >
       		 <h2>Completed Quests</h2>
        </div>
    
    </div>
    
    <div id="WrapperTop">
    		
    </div>
    
    <div id = "wrapper">
    	
        
        <div id = "postsPROFILE">
        
       		<div id="username">
            	 <img src="Images/namebar.png" width="138%" />
            </div>
        
        	<div id="questname">
            	
            </div>
            
        	<div id="specifics">
            
            	<h1>ReQuested By:</h1>
                <h2>Date:</h2>
            	
            </div>
            
            <div id ="like">
            	
                <img src="Images/like.png" width="38%" />
                
            </div>
            
              <div id ="comments">
            	
                <img src="Images/comments.png" width="38%" />
                
            </div>
   
        </div>
    
    </div>
    
</body>
<?php include_once "db_close.php"; ?>
</html>