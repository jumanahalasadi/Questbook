<?php
//CHECK IF USER IS LOGGED IN
	session_start();
 	include_once "checkSession.php";	
	if (checkCookie() == true){
		$userID = $_SESSION["userID"];
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
   </head>
<body>

<script>

//ajax 


	//DISPLAY COMMENTS
	function comment(postid)
	{	
		var oXMLHttp2 = new XMLHttpRequest();
		if(oXMLHttp2 == null) return(null);	
			
		//set up the connection
		var cURL = "comment.php?id=" + postid;
		oXMLHttp2.open("get", cURL, true);	
		oXMLHttp2.onreadystatechange = function()
		{
			if(oXMLHttp2.readyState == 4) //state 4 data recieved
			{
				if(oXMLHttp2.status == 200)
				{
					document.getElementById(postid).style.visibility = "visible";
					document.getElementById(postid).innerHTML = oXMLHttp2.responseText;
				}
				else {  
				
				}
			}
			else if(oXMLHttp2.readyState > 1) { 
				//alert('loading');
			}
		};
		oXMLHttp2.send(null);
		var status = document.getElementById(postid).style.visibility;
		if (status == "visible")
		{
			document.getElementById(postid).style.visibility = "hidden";
		}
	}
	
	//CLOSE COMMENT DIV
	function closecomment(postid)
	{
		document.getElementById(postid).style.visibility = "hidden";		
	}
	
	//UPLOAD COMMENT
	function sendcomment(postid)
	{
		var txt = "msg="+document.getElementById("textp" +postid).value + "&id=" + postid; //recieve and store it
		document.getElementById("textp" +postid).value = ''; //empty it 
	
		//Start ajaxing
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("post", "uploadcomment.php", true); 
		
		//Some header stuff
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.setRequestHeader("Content-length", txt.length);
		xmlHttp.setRequestHeader("Connection", "close");
			
		//on state change
		xmlHttp.onreadystatechange = function () 
		{
			if(xmlHttp.readyState == 4)
			{
				if(xmlHttp.status == 200) 
				{
					alert("Message Posted");	
					closecomment(postid);				
				}								
			}
		};
		//send content string
		xmlHttp.send(txt);
	};
	
	//UPDATING LIKES OF POSTS ON THE PAGE EVERY 2 SECONDS
	function UpdateLikes(postid)
	{	
	
		
		var xmlHttp = new XMLHttpRequest();
		//if(xmlHttp == null) return(null);	
		
		var div = "Post" + postid;
		
		
		xmlHttp.open("get", "UpdateLikes.php?postid="+postid, true);
		
		xmlHttp.onreadystatechange = function()
		{
			if(xmlHttp.readyState == 4) //state 4 data recieved
			{
				if(xmlHttp.status == 200)
				{
					//alert(xmlHttp.responseText);
					document.getElementById(div).innerHTML = xmlHttp.responseText;
					//alert('done');
				}
				else {  
				}
				
			}
			
			else if(xmlHttp.readyState > 1) { 
				//alert('loading');
			}
			
			
		};
		
		//oXMLHttp2.send(null);
		xmlHttp.send(null);
	};
	
	//SENDING LIKES OF POSTS 
	function like(postid)
	{
		
		var xmlHttp = new XMLHttpRequest();
	
		xmlHttp.open("get", "likes.php?id="+postid, true);
		
		xmlHttp.onreadystatechange = function()
		{
			if(xmlHttp.readyState == 4) //state 4 data recieved
			{
				if(xmlHttp.status == 200)
				{
					
					document.getElementById('likeNumber').innerHTML = xmlHttp.responseText;
					
				}
				else {  
			
				}
			}
			else if(xmlHttp.readyState > 1) { 
				
			}
		};
		
		xmlHttp.send(null);
	};
</script>

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
			//Displaying logout information such as user logged in and log out button
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
                 <?php
				 
				 //Displaying profile picture!
					$sqlImage = "SELECT ProfilePic, ProfileType FROM User ";
                    $sqlImage .= "WHERE UserID=$userID";
                    $resultImage = mysql_query($sqlImage);
                    if($resultImage)
                    {
                        if(mysql_num_rows($resultImage) == 1)
                        {
                            $rowData2 = mysql_fetch_assoc($resultImage);      
                            $imgtype = $rowData2['ProfileType'];
                            $imgfile = "Profile/{$rowData2['ProfilePic']}";
							$imgname = $rowData2['ProfilePic'];
  
							if ($imgtype == NULL)
							{
								$imgtype = 'image/jpeg';
                          		$imgfile = "Profile2/thumbnails_profilePic.jpg";							
								$imgname = "profilePic.jpg";
								$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
								echo "<img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' '/>";
							}
							else
							{
								//http://stackoverflow.com/questions/9650572/resize-image-php
								$new_images = "thumbnails_".$imgname;
								$height=105; //*** Fix Width & Heigh (Autu caculate) ***//
								$size=GetimageSize($imgfile);
								$width=round($height*$size[0]/$size[1]);
								$images_orig = ImageCreateFromJPEG($imgfile);
								$photoX = ImagesX($images_orig);
								$photoY = ImagesY($images_orig);
								$images_fin = ImageCreateTrueColor($width, $height);
								ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
								ImageJPEG($images_fin,"Profile2/".$new_images);
								$imgfile = "Profile2/".$new_images;
								$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
								echo "<img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' '/>";
							}
                            ImageDestroy($images_orig);
                            ImageDestroy($images_fin);
                        }
                    }
				?>
			</div>
            
            <div id="profileInfo">
                 <?php
				 	//Displaying username, level and friends!
					$userID = $_SESSION['userID'];	
				 	$sql = "SELECT Username, Level FROM User WHERE UserID =  $userID ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result))
					{
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
   
    <div id="WrapperTop"> </div>
    
    <div id = "wrapper">
    	<!-- FAME -->
    	<div id = "wall">
       		<div id="heading">
        		<h1>Wall of Fame</h1>
       		</div>  
           	
            <div id = "slideshow" style="left: 10px; top: -20px; height:414px; width:1150px; overflow-x:scroll;  align:center; ">
			
			<?php
			//SLIDESHOW OF TOP POSTS BASED ON LIKES
				$sqlimage = "
					SELECT 
						Post.MediaTitle, 
						Post.MediaType, 
						Post.CreatorID, 
						Post.QuestID, 
						Post.Text, 
						Post.PostID, 
						Post.Likes, 
						Post.Date , 
						Quests.Name, 
						Quests.QuestID , 
						User.UserID, 
						User.Username
					FROM 
						Post 
					INNER JOIN Quests
					ON Quests.QuestID = Post.QuestID
					INNER JOIN User
					ON User.UserID = Post.CreatorID
					WHERE Post.Likes > 3 LIMIT 5  ";
				$resultImage = mysql_query($sqlimage);

				while($rowData2 = mysql_fetch_assoc($resultImage))
				{
					$imgtype = $rowData2['MediaType'];
					$imgfile = "Uploads/{$rowData2['MediaTitle']}";						
					if ($imgtype == "audio/mp3")
					{	
					}
					else
					{
						//http://stackoverflow.com/questions/9650572/resize-image-php
						$new_images = "thumbnails_".$rowData2['MediaTitle'];
						$height=300; //*** Fix Width & Heigh (Autu caculate) ***//
						$size=GetimageSize($imgfile);
						$width=round($height*$size[0]/$size[1]);					
						if ($imgtype == "image/jpeg")
							$images_orig = ImageCreateFromJPEG($imgfile);
						else
							$images_orig = ImageCreateFromPNG($imgfile);
											
						$photoX = ImagesX($images_orig);
						$photoY = ImagesY($images_orig);
						$images_fin = ImageCreateTrueColor($width, $height);
						ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
						
						if ($imgtype == "image/jpeg")
							ImageJPEG($images_fin,"Photos/".$new_images);
						else
							ImagePNG($images_fin,"Photos/".$new_images);
						
						$imgfile = "Photos/".$new_images;
						$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
					?>
					<div style:center;>
					<?php
						echo "<center style = color:white>{$rowData2['Name']}</center>\n" ; ?>
						<h2>Done By: <?php echo "<center style = color:white>{$rowData2['Username']}</center>";
						echo "<center><img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' </center>";
					?>
				</div>
				<div style:center;>
					<?php
						echo "<br/><center style = color:white>{$rowData2['Text']}</center><br/>\n";
					?>
                   
                    <hr />
					</div>
					
					<?php
						ImageDestroy($images_orig);
						ImageDestroy($images_fin);
					}
				}						
				//use these to open the file			
				//echo "<img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "'/>"; 		
			?>
		</div>
	</div>
	<div id="space"></div>
        <?php
			$userID = $_SESSION['userID']; 
			if (isset($_GET['UserID'])){
				$userID = $_GET['UserID'];
			}

			//DISPLAYING ALL POSTS OF FRIENDS
			
			//GETTING FRIENDS
			$UserFriends = mysql_query("SELECT DISTINCT FriendID FROM Friends WHERE UserID = $userID");			
			$ID = (int) $userID;
	
			$i = 0;
			while($friend = mysql_fetch_assoc($UserFriends))
			{
				$array_friends[$i] =  $friend['FriendID'];
				$i++;
			}  
			
			//DISPLAYING POST OF FRIEND 
			$sql = "SELECT DISTINCT * FROM Post WHERE CreatorID = ";
			for ($j = 0; $j < $i; $j++)
			{ 
				if ($j + 1 == $i)
				{
					$sql .= "$array_friends[$j] ";
				}
				else
					$sql .= "$array_friends[$j] OR CreatorID = ";
			}
			$sql .= "ORDER BY Post.Date DESC";
			$resultQuery = mysql_query($sql);
		if($resultQuery) {
			while($rowData = mysql_fetch_assoc($resultQuery))
			{ 
				$creator_id = $rowData['CreatorID'];
				$p_ID = $rowData['PostID'];
				//////intializing value
				$_SESSION['PostID'] = $p_ID;		
		?>
       	
        <!--POSTS-->
       	<div id = "postsHOME">
       		<div id="username">
            	<h1><?php 
					if (isset($_GET['UserID']))
					{
						$userID = $_GET['UserID'];
					}
				
					$userID = $_SESSION['userID'];
					$sql = "SELECT Username FROM User WHERE UserID = $creator_id ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result))
					{
						$user = $row["Username"];
					 	echo "<h3>" . $user ." </h3>";
					}
				?></h1>
            </div>
        
        	<div id="questname">
            	<h1><?php 
					if (isset($_GET['UserID']))
					 {
						 $userID = $_GET['UserID'];
					 }
				
					$userID = $_SESSION['userID'];
					$ID = (int) $userID;
					$questname = "
						SELECT DISTINCT 
							Quests.Name, 
							Quests.QuestID, 
							Requests.ChallengerID, 
							Requests.QuestID, 
							Post.PostID 
						FROM 
							Quests 
						INNER JOIN Requests ON Quests.QuestID = Requests.QuestID 
						INNER JOIN Post ON Post.QuestID = Requests.QuestID 
						WHERE Requests.RecieverID = $ID AND Post.PostID = $p_ID"; 
					$QuestQuery = mysql_query($questname);
	
					while($row = mysql_fetch_assoc($QuestQuery))
					{	
						$q = $row["Name"];
						echo "<h3>" . $q ." </h3>";
					}
				?></h1>
            </div>
            
			<div id="postText">
            	<br /><br /><br />
            	<div id="container">          
				<?php 
					if (isset($_GET['UserID'])){
						$userID = $_GET['UserID'];
	 				}
                    
                    $postID = $rowData['PostID'];
                    $sqlImage = "SELECT DISTINCT PostID, MediaTitle, MediaType, Width, Height FROM Post ";
                    $sqlImage .= "WHERE PostID=$postID";
                    $resultImage = mysql_query($sqlImage);
                    if($resultImage)
                    {
                        if(mysql_num_rows($resultImage) == 1)
                        {
                            $rowData2 = mysql_fetch_assoc($resultImage);
                            $postid = $rowData2['PostID'];
                            $imgtype = $rowData2['MediaType'];
                            $imgfile = "Uploads/{$rowData2['MediaTitle']}";
							
							if ($imgtype == "audio/mp3")
							{	
								echo"<a href='".$imgfile."'>Listen to my audio!</a><br>";
							}
							else
							{
								//http://stackoverflow.com/questions/9650572/resize-image-php
								$new_images = "thumbnails_".$rowData2['MediaTitle'];
								$height=300; //*** Fix Width & Heigh (Autu caculate) ***//
								$size=GetimageSize($imgfile);
								$width=round($height*$size[0]/$size[1]);
								
								if ($imgtype == "image/jpeg")
									$images_orig = ImageCreateFromJPEG($imgfile);
								else
									$images_orig = ImageCreateFromPNG($imgfile);
								
								$photoX = ImagesX($images_orig);
								$photoY = ImagesY($images_orig);
								$images_fin = ImageCreateTrueColor($width, $height);
								
								ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
								if ($imgtype == "image/jpeg")
									ImageJPEG($images_fin,"Photos/".$new_images);
								else
									ImagePNG($images_fin,"Photos/".$new_images);
								
								$imgfile = "Photos/".$new_images;
								$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
								echo "<img align='right' src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' style='padding-left:10px;'/>";
								
								ImageDestroy($images_orig);
								ImageDestroy($images_fin);
							}
                        }
                    }
                    ?>
               
                    <?php echo $rowData['Text']; ?>
                    <!-- http://www.smashingmagazine.com/2009/10/19/the-mystery-of-css-float-property/ -->
               			<div class="clearfix"></div> </div>
               				<br/>
            			</div>
            
        				<div id="specifics">
            				<h1>ReQuested By: 
							<?php
								$resultoo = mysql_query("SELECT Requests.ChallengerID FROM Requests INNER JOIN Post ON Post.QuestID = Requests.QuestID WHERE Post.PostID = $postid");
								$challenger = mysql_fetch_assoc($resultoo);
								$cid = $challenger['ChallengerID'];
								$sqlc = "SELECT Username FROM User WHERE UserID = $cid ";
								$resultc = mysql_query($sqlc);
								$rowc = mysql_fetch_assoc($resultc);
								$cuser = $rowc["Username"];
							 	echo $cuser; 
							?></h1>
               				<h2>Date: <?php echo $rowData['Date']; ?></h2>
            			</div>
                        
           			<!------ Like Button ---------->
            		 <div id ="like">
                <a href='javascript:void(0)' onClick='like(<?php echo $postid ?>)'><img src="Images/like.png" width="38%" /></a>
                
                <div id="likeNumber">
                
                	<div id="<?php
					
					$divid = (string) "Post" . $postID;
					echo $divid; 
					
					?>">
               
						<?php 
							echo $rowData['Likes'];
						?>
                    </div>
                    
                </div>
                
            </div>
           			<div id ="comments"> 
                		<a href ="javascript:void(0)" onClick='comment(<?php echo $postid ?>)'><img src="Images/comments.png" width="38%" /></a>
                		<div id="<?php echo $postid ?>" style="background-color:#424242; color:white; height:300px; width:500px; visibility:hidden; overflow:scroll;"> Hiiiiiiii </div>
            		</div>
				</div>
        		<div id="space"></div>
        			
					<?php } ?>    
                    
                    	<?php } ?>    

            	</div>
     
                    
    <?php //UPDATING LIKES
	 
	$UserFriends = mysql_query("SELECT DISTINCT FriendID FROM Friends WHERE UserID = $userID");			
			$ID = (int) $userID;
	
			$i = 0;
			while($friend = mysql_fetch_assoc($UserFriends)) //ARRAY OF FRIENDS
			{
				$array_friends[$i] =  $friend['FriendID'];
				$i++;
			}  
			
			$sql = "SELECT DISTINCT * FROM Post WHERE CreatorID = "; //ARRAY OF POSTS ON THE PAGE
			for ($j = 0; $j < $i; $j++)
			{ 
				if ($j + 1 == $i)
				{
					$sql .= "$array_friends[$j] ";
				}
				else
					$sql .= "$array_friends[$j] OR CreatorID = ";
			}
			$sql .= "ORDER BY Post.Date DESC";
			$resultQuery = mysql_query($sql);
		
			$i = 0;
			
			if($resultQuery){
			while($rowData = mysql_fetch_assoc($resultQuery))
			{ 
				$pid = $rowData['PostID'];
				
				$array_posts[$i] = $pid;
				
				$i++;
			}
			
			}
			$i--;

	?>

 	<script>  //calling the update likes function every 2 seconds for EVERY post id
		
		<?php 
		
			for($counter=0; $counter<=$i; $counter++){ 
						
			//echo "UpdateLikes($array_posts[$counter]);"; //pass the post div like id
							
				echo "setInterval('UpdateLikes($array_posts[$counter])', 2000);";						
							
			}
		?>
							
	</script>	
                
    		</body>
                    
<?php include_once "db_close.php"; ?>
</html>