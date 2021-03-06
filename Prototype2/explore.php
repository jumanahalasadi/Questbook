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


<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=400,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,status=yes')
		
	//alert("Hi");
}
</script>


</head>

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
    	<div id="exploreTabActive"><a href="explore.php" style="text-decoration:none"><h3>EXPLORE</h3></a></div>
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
       		<a href="profile.php?show=messages" style="text-decoration:none"><h2>Messages</h2> </a>
        </div>
        
        <div id="Circle">
       		 <a href="profile.php?show=circle" style="text-decoration:none"><h2>Circle</h2> </a>
        </div>
        
        <div id="CompletedQuests" >
       		 <a href="profile.php?show=completed" style="text-decoration:none"> <h2>Completed Quests</h2></a>
        </div>
    
    </div>
    
      <div id="searchbar">
         	<form action="explore.php" method="post">
                                <input type="text" name="search" size="60" placeholder="Search..." required>
                                <input type="button" name="search" value="Search">
			</form>
         </div>
    
    <div id = "wrapper">
    
        
        <div id="heading">
         <h1>Wall of Fame</h1>
         </div>
         
         
        <!------------------------------------->
        <div id = "postsEXPLORE">
        	<div id="questsheading">
            	<h3>QUESTS</h3>
            </div>

             <?php				
			 $userID = $_SESSION['userID'];	
					if(isset($_POST['search'])){
					
						$searchstring = (isset($_POST['search'])) ? $_POST['search'] : "" ;
						
						echo "<h3>" . "Search results for: '" . $searchstring . "' ";
						echo "</br>";
						echo "</br>";
					}
					
					if(empty($searchstring)){
						echo "Search was empty";
					}
		
					else{
						
							$sql = "SELECT * FROM Quests WHERE Name LIKE '%$searchstring%' ORDER BY Name";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$quests = $row["Name"];
						$description = $row["Description"];
						$q_id = $row['QuestID'];
						
						
						echo "</br>";
					 	echo "<a>" . $quests ." </a>";
						echo "<p>" . $description ." </p>";
						
						echo "<div style='margin-top:-30px; margin-left:500px;'>" . "<a href='explore.php?quest=
						$q_id&action=do' >" . "Do!" . "</a>" . "</br>" . "<a href=\"JavaScript:newPopup('challenge.php?quest=
						$q_id&action=challenge')\">" . "Challenge!" . "</a>" . "</div>" ;
						
						
		
						
						
   
		
					}
					
				 
					}
	
	
	
	if(isset($_GET['action'])){
							
							$q_id = $_GET['quest'];
							
							//sql statement to 
							if(isset($_GET['action']) && $_GET['action'] == "do" ){
							//	//sql to insert to my requests
								$sql = "INSERT INTO Requests (ChallengerID , RecieverID , QuestID, Completed)
								VALUES ( '$userID' , '$userID' , '$q_id ', 0)";
								
								$result = mysql_query($sql);
							
							
							}
							
							else if(isset($_GET['action']) && $_GET['action'] == "challenge" ) {
								
								
								/*
								//sql to insert to someone elses request
								
								$sql2 = "SELECT User.Username, User.UserID FROM User INNER JOIN Friends ON User.UserID = Friends.FriendID WHERE Friends.UserID = '$userID' ";
								
								$result2 = mysql_query($sql2);
								
								echo "<div='challenge'>";
								
								
								
								echo "<select id='friends' name='dropdown'>";
								
								while($row = mysql_fetch_assoc($result2)){
									
									$name = $row['Username'];
									$id = $row['UserID'];	
											
									echo "<option value='$id'>" . $name . "</option>";
									
								}
								
								
								echo "</select>";
								
								
								echo "</div>";
								*/
							}
							
							else
							{
								//do nothing
							}
							
							 
								
						}
						else {
							//nothing
						}
						
				 
				 ?>
            
            
            
        	<div id="specifics">
          
            	
            	
            </div>
            
           
   
        </div>
        
        
        <!------------------------------------->
        
         <div id = "posts2">
        
       		
        
        	<div id="questsheading">
            
            	<h3>USERS</h3>
            	
            </div>
            
            
                 <?php
				 	
					
					
					if(isset($_POST['search'])){
					
					$searchstring = (isset($_POST['search'])) ? $_POST['search'] : "" ;
					
					echo "<h3>" . "Search results for: '" . $searchstring . "' ";
					echo "</br>";
					echo "</br>";
						
					}
					
					
					if(empty($searchstring)){
						echo "Search was empty";
					}
		
					else{
						
							$sql = "SELECT Username, UserID FROM User WHERE Username LIKE '%$searchstring%' ORDER BY Username";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$user = $row["Username"];
						$id = $row["UserID"];
					
						echo "</br>";
					 	echo "<a href=profile.php?UserID=$id>" . $user ." </a>";
						
                	
   
		
					}
					
				 
					}
	
				 
				 ?>
                 
                      
            
        	<div id="specifics">
            
            	
            	
            </div>
            
           
   
        </div>
         
        
        
           <!------------------------------------->
        
    
    </div>
    
</body>
<?php include_once "db_close.php"; ?>
</html>