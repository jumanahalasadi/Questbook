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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	<title>Homepage</title>
    
    <style>
		
		
	</style>
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
       		<a href="profile.php?show=messages" style="text-decoration:none"> <h2>Messages</h2> </a>
        </div>
        
        <div id="Circle">
       		 <a href="profile.php?show=circle" style="text-decoration:none"><h2>Circle</h2> </a>
        </div>
        
        <div id="CompletedQuests" >
       		 <a href="profile.php?show=completed" style="text-decoration:none"> <h2>Completed Quests</h2></a>
        </div>
    
    </div>
   
    <div id="WrapperTop">
    		
    </div>
    
    <div id = "wrapper">
    	<div id = "wall">
       		
 	 	</div>
        
        <div id="heading">
         <h1>Wall of Fame</h1>
         </div>
         
        
        
<div id = "slideshow" style="left: 425px; top: 250px; position: absolute">

<script language="javascript" type="text/javascript">
<!-- Begin
// Set slideShowSpeed (milliseconds)
var slideShowSpeed = 800;
// Duration of crossfade (seconds)
var crossFadeDuration = 7;
// Specify the image files
var Pic = new Array();
// to add more images, just continue
// the pattern, adding to the array below

Pic[0] = 'Images/slide1.jpg'
Pic[1] = 'Images/slide2.jpg'
Pic[2] = 'Images/slide3.jpg'
Pic[3] = 'Images/slide4.jpg'

// do not edit anything below this line
var t;
var j = 0;
var p = Pic.length;
var preLoad = new Array();
for (i = 0; i < p; i++) {
preLoad[i] = new Image();
preLoad[i].src = Pic[i];
}
function runSlideShow() {
if (document.all) {
document.images.SlideShow.style.filter="blendTrans(duration=0)";
document.images.SlideShow.style.filter="blendTrans(duration=crossFadeDuration)";
document.images.SlideShow.filters.blendTrans.Apply();
}
document.images.SlideShow.src = preLoad[j].src;
if (document.all) {
document.images.SlideShow.filters.blendTrans.Play();
}
j = j + 1;
if (j > (p - 1)) j = 0;
t = setTimeout('runSlideShow()', slideShowSpeed);
}
window.onload=runSlideShow;
//  End -->
</script>

<center>

<tr>
<td id="VU" height=190 width=330><img src="http://www.htmlbestcodes.com/images/toad.jpg" name='SlideShow' width=1138 height=310 margin-left=300 ></td>
</tr>
</table>
</center>
</div>


		<?php
			$posts = mysql_query("SELECT Post.MediaType, Post.MediaTitle, Post.Text, Post.Date, Post.CreatorID, User.Username FROM Post INNER JOIN User ON Post.CreatorID=User.UserID");
			
			
			while($row = mysql_fetch_assoc($posts)){
						
						$homepost = $row["MediaType"];
						$text = $row["Text"];
						$date = $row["Date"];
						$requested = $row["Username"];
						$title = $row["MediaTitle"];
						$media = $row["MediaType"];
						$text = $row["Text"];
						
						
					 	echo "<h3>" . $homepost . $text . " </h3>";
                	
                 		//echo "<h1>" . "Level: " . $lvl . "</h1>";
						
					}
		?>
        
        <div id = "posts">
        
       		<div id="username">
            	 <img src="Images/namebar.png" width="138%" />
                 <h2><?php echo $user ?></h2>
            </div>
        
        	<div id="questname">
            
            <h2><?php echo $title ?></h2>
            	
            </div>
            
             <?php echo $media . "Message:" .$text ?>
            
        	<div id="specifics">
            
            	<h1>Date:<?php echo $date ?></h1>
                <h2>ReQuested By:<?php echo $requested ?></h2>
            	
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