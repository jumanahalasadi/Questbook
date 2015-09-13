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
	/* THIS IS FOR THE POP UP "LIGHTBOX" */
		.black_overlay{
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			text-align:center;
			display: none;
			position: absolute;
			top: 25%;
			left: 40%;
			width: 20%;
			height: 10%;
			padding: 16px;
			border: 16px solid orange;
			background-color: white;
			z-index:1002;
			overflow:auto;
		}
		
		#light p, h2{
			color:#000;
		}
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
			
				$userID = $_SESSION['userID'];//your own profile name
		
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
				 
				 
				$userID = $_GET['UserID']; //the other guy
				
				
				
				
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
       		 <a href="#" style="text-decoration:none;"><h2>Message</h2></a>
        </div>
                
        <div id="Circle">
        
        <?php
		
		$id = $_GET['UserID'];
		
		echo " <a href='circle.php?UserID=$id' style='text-decoration:none;'><h2>Circle</h2></a>";
		?>
       		
        </div>
        
        <div id="Follow">
             <a href = "javascript:void(0)" onclick = "FollowUser()" style="text-decoration:none;"><h2>Follow</h2></a>
             <script>
			 function FollowUser()
			 {
				 
 			document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';				
				
			<?php
				$friend = $_GET['UserID']; //the other guy
				//$_SESSION["otherUserID"] = $userID;
				$userID = $_SESSION['userID'];//your own profile name
				 
				//$groupidresult = mysql_query("SELECT UserID FROM User WHERE UserID = $userID");

				//insert data into the database using the now() sql function for the date.
				
				$check = mysql_query("SELECT FriendID FROM Friends WHERE UserID = $userID AND FriendID = $friend ");
				
				$count  = mysql_num_rows($check);
				
				if(!$count)
					$resultInsert = mysql_query("INSERT INTO Friends (UserID, FriendID) VALUES ('$userID', '$friend')");
				
				if(!$resultInsert) //if error
					echo mysql_error();
			?>
				 
				 // alert ("You are now following this user!");
				
			 }
			 </script>
        </div>
        
        <div id="CompletedQuests">
             
                  
        <?php
		
		$id = $_GET['UserID'];
		
		echo " <a href='CompletedQuests.php?UserID=$id' style='text-decoration:none;'><h2>Completed Quests</h2></a>";
		?>
        </div>
    
    </div>
    
    <div id="WrapperTop">
    		
    </div>
    
    <div id = "wrapper">
    	<!--POP UP "LIGHT BOX" window displaying the user has followed another user-->
		<div id="light" class="white_content">
        	<h2>You are now following <?php echo $user ?></h2><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><p>Close</p></a>
        </div>
        
		<div id="fade" class="black_overlay"></div>
        
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