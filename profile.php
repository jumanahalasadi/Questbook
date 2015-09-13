<?php
	session_start();
	include_once "checkSession.php";
	
	if (checkCookie() == true){
		$userID = $_SESSION['userID'];
	}
	else 
		header("Location: profile.php"); 
	
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once "db_open.php"; ?>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
    <title>Profile</title>
    <style>
    /* THIS IS FOR THE POP UP "LIGHTBOX" */
    .black_overlay {
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 1001;
        -moz-opacity: 0.8;
        opacity: .80;
        filter: alpha(opacity=80);
    }
    .white_content {
        text-align: center;
        display: none;
        position: absolute;
        top: 25%;
        left: 40%;
        width: 20%;
        height: 10%;
        padding: 16px;
        border: 16px solid orange;
        background-color: white;
        z-index: 1002;
        overflow: auto;
    }
    </style>
    </head>
    <body>
  
    <script>
	function comment(postid){
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
			}	
		};
		
		oXMLHttp2.send(null);
		var status = document.getElementById(postid).style.visibility;
		if (status == "visible"){
				document.getElementById(postid).style.visibility = "hidden";
		}
	}
	function closecomment(postid){
	document.getElementById(postid).style.visibility = "hidden";		
	}

	function sendcomment(postid){
		
		//create variable to store the message //get form input by ID	
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
			if(xmlHttp.readyState == 4){
				if(xmlHttp.status == 200) {
					alert("Message Posted");	
					closecomment(postid);
				}
			}
		};
	//send content string
	xmlHttp.send(txt);

	function like(postid){
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
	}		
	}
	
	function uploadMessages()
	{
		var MessageData = "uMessages="+document.getElementById("textItem").value;	
		var text = document.getElementById("textItem").value
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("get", "uploadMessages.php?text=" + text, true);
		xmlHttp.onreadystatechange = function()
		{
			if(xmlHttp.readyState == 4)
			{
				if(xmlHttp.status == 200)
				{
					displayMessages(xmlHttp.responseText);
					document.getElementById("textItem").value = '';
				}
				else
				{
					//alert("Oh no, an error occured");
				}	
			}
		};
		xmlHttp.send(null);	
	}
	
	function displayMessages(sText)
	{
		var divNews = document.getElementById("ChatFeed");
		divNews.innerHTML = sText;	
	}
	
	fetchMessages();
	setInterval("fetchMessages()", 500);
	
	function fetchMessages()
	{
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("get", "fetchMessages.php", true);	
		xmlHttp.onreadystatechange = function()
		{
			if (xmlHttp.readyState == 4)
			{
				if(xmlHttp.status == 200)
				{
					displayMessages(xmlHttp.responseText);
				}
				else
				{
					//alert("Oh no, an error occured");
				}
			}
		};
		
		xmlHttp.send(null);
	}
	
	/////////////////////Javascript like
	
	function UpdateLikes(postid)
	{	
		var xmlHttp = new XMLHttpRequest();	
		var div = "Post" + postid;
		xmlHttp.open("get", "UpdateLikes.php?postid="+postid, true);
		xmlHttp.onreadystatechange = function()
		{
			if(xmlHttp.readyState == 4) //state 4 data recieved
			{
				if(xmlHttp.status == 200)
				{
					document.getElementById(div).innerHTML = xmlHttp.responseText;
				}
				else {  
				}		
			}
			else if(xmlHttp.readyState > 1) { 
				//alert('loading');
			}

		};
		xmlHttp.send(null);
	};
	
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
		<div id="cornerLogo"> <a href="homepage.php"><img src="Images/logo2.png" width="217px" /> </div>
      	<div id="profileTabActive"><a href="profile.php" style="text-decoration:none">
        	<h3>MY PROFILE</h3>
        </a></div>
      	<div id="exploreTab"><a href="explore.php" style="text-decoration:none">
        	<h3>EXPLORE</h3>
        </a></div>
      	<div id="requestsTab"><a href="requests.php" style="text-decoration:none">
        	<h3>REQUESTS</h3>
        </a></div>
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
				echo "<h2>" . $user . "</h2>";/////////////
			?>
    	</div>
  </div>
  <div id="logoutButton"> <a href="index.php?logout=true" style="text-decoration:none">
		<h1>Log Out</h1>
  </a> </div>
</div>
<div id="settings"> <img src="Images/seticon.png" width="30px;" /> </div>
	<div id = "sidebar">
		<div id="profile">
  			<div id = "picture">
    			<?php
					//IF ON ANOTHER PERSONS PROFILE PAGE
					$userID = $_SESSION['userID'];
					if(isset($_GET['UserID']))
					{
						$userID = $_GET['UserID']; //anotherpersons profile
					}
					
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
								//copy($rowData2,"Photos/".$rowData2['MediaTitle']);
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
				//IF ON ANOTHER PERSONS PROFILE PAGE
				$userID = $_SESSION['userID'];
				if(isset($_GET['UserID']))
				{
					$userID = $_GET['UserID']; //anotherpersons profile
				}
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
	<?php  		 
		//IF NOT ON ANOTHER PERSONS PROFILE PAGE
		if(!isset($_GET['UserID']))
		{
			$loggedInUserID = $_SESSION['userID'];
        	echo "<div id='Messages'>" .
       		"<a href='profile.php?show=settings' style='text-decoration:none'> <h2>Profile Settings   <img src='Images/edit.png' width='20px;'/></h2></a>" .
       " </div> ";
	   		echo "<div id='Messages'>" .
			"<a href='profile.php?show=messages' style='text-decoration:none'> <h2>Messages</h2> </a>" .
			"</div>";
			echo  "<div id='Circle'>" . 
       		 "<a href='profile.php?show=circle' style='text-decoration:none'><h2>Circle</h2> </a>" .
        "</div>"; 
			echo "<div id='CompletedQuests'>";
			echo "<a href='profile.php?show=completed' style='text-decoration:none;'><h2>Completed Quests</h2></a>";
			echo " </div>";
		}
		else {  // on someone elses profile
			$userID = $_GET['UserID'];
			$id = $_GET['UserID'];
			echo "<div id='Messages'>"
					. "<a href='profile.php?UserID=$id&show=message' style='text-decoration:none;'><h2>Message</h2></a>" .
						"</div>" .
							
						"<div id='Circle'>";
						echo " <a href='profile.php?UserID=$id&show=circle' style='text-decoration:none;'><h2>Circle</h2></a>";	
						echo "</div>";
						echo "
						<div id='Follow'>
							 <a href = 'javascript:void(0)' onclick = 'FollowUser()' style='text-decoration:none;'><h2>Follow</h2></a>
							 ";
						?>
						<script>
							 function FollowUser()
							 {
								document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';				
								<?php
									$friend = $_GET['UserID']; //the other guy
									$_SESSION["otherUserID"] = $friend;
									$userID = $_SESSION['userID'];//your own profile name
									$check = mysql_query("SELECT FriendID FROM Friends WHERE UserID = $userID AND FriendID = $friend ");
									$count  = mysql_num_rows($check);
										if(!$count)
											$resultInsert = mysql_query("INSERT INTO Friends (UserID, FriendID) VALUES ('$userID', '$friend')");
										if(!$resultInsert) //if error
											echo mysql_error();
										?> 
							 		}
								</script>
								<?php
									echo " </div> " .
									"<div id='CompletedQuests'>";
									$id = $_GET['UserID'];
									echo " <a href='profile.php?UserID=$id&show=completed' style='text-decoration:none;'><h2>Completed Quests</h2></a>";
									echo " </div>";
								}
								?>
    						</div>
   		    			<div id="WrapperTop">
					</div>
    				<div id = "wrapper">
    					<div id="light" class="white_content">
        					<h2 style="color:black;" >You are now following <?php echo $user ?></h2><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><p style="color:black;">Close</p></a>
        				</div>
						<div id="fade" class="black_overlay"></div> 
    						<?php  
								if(!isset($_GET['show'])){ 
									$userID = $_SESSION['userID'];
	 								if (isset($_GET['UserID'])){
		 								$userID = $_GET['UserID'];
									}
									$ID = (int) $userID;
									$sql = "
										SELECT 
											Post.PostID, 
											Post.CreatorID, 
											Post.Text, 
											Post.Date, 
											Post.Likes, 
											User.Username 
										FROM Post 
										INNER JOIN User ON 
											Post.CreatorID = User.UserID 
										WHERE Post.CreatorID = $ID ORDER BY Post.Date  DESC";
									$resultQuery = mysql_query($sql); 
									while($rowData = mysql_fetch_assoc($resultQuery))
									{
										$p_ID = $rowData['PostID'];
										?>
        								<div id = "postsPROFILE">
       										<div id="username">
            									<h1><?php 
												 if (isset($_GET['UserID'])){
													 $userID = $_GET['UserID'];
												 }
												$sql = "SELECT Username FROM User WHERE UserID = $userID ";
												$result = mysql_query($sql);
												while($row = mysql_fetch_assoc($result))
												{		
													$user = $row["Username"];
													echo "<h3>" . $user ." </h3>";
												}?></h1>
            									<!--<img src="Images/namebar.png" width="138%" />-->
          									</div>
											<div id="questname">
												<h1><?php 
												$userID = $_SESSION['userID'];
												$ID = (int) $userID;
												$questname = "
													SELECT 
														Quests.Name, 
														Quests.QuestID, 
														Requests.ChallengerID, 
														Requests.QuestID, 
														Post.PostID 
													FROM Quests 
													INNER JOIN 
														Requests ON Quests.QuestID = Requests.QuestID 
													INNER JOIN 
														Post ON Post.QuestID = Requests.QuestID 
													WHERE 
														Requests.RecieverID = $ID AND Post.PostID = $p_ID"; 
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
													if (isset($_GET['UserID']))
													{
														$userID = $_GET['UserID'];
													}
													$postID = $rowData['PostID'];
													$sqlImage = "SELECT PostID, MediaTitle, MediaType, Width, Height FROM Post ";
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
                                                        <h1>ReQuested By: <?php echo $rowData['Username']; ?></h1>
                                                        <h2>Date: <?php echo $rowData['Date']; ?></h2>
                                                    </div>
            
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
                                            <div id="space"></div><!--separator-->
        									<?php } ?>
            								<?php } ?><!---- GOING TO OTHER PAGES ----> 
          									<?php  if(isset($_GET['show']) && $_GET['show'] == 'circle'){ 
											include 'circle.php';
										}?>
        								<?php  if(isset($_GET['show']) && $_GET['show'] == 'completed'){ 
		 								include 'CompletedQuests.php';
		 							}?>
         							<?php if(isset($_GET['show']) && $_GET['show'] == 'settings'){
			  						include 'editprofile.php';
			  					}?>
                                <?php  if(isset($_GET['show']) && $_GET['show'] == 'messages'){
										
										//$friendid = $_SESSION["otherUserID"];
										$sql = mysql_query("SELECT DISTINCT User.Username, Message.SenderID
											 FROM Message
											 INNER JOIN User 
											 ON Message.SenderID = User.UserID
											 WHERE Message.RecieverID = $userID");	
										
										if(!$sql)
											echo mysql_error();
										else
										{
											while($rowSelect = mysql_fetch_assoc($sql))
											{
												$userSelect = $rowSelect['SenderID'];
												echo "Go to existing chat with: <a href='profile.php?UserID=". $rowSelect['SenderID'] ."&show=message'>" . $rowSelect['Username'] . "</a>";
												echo "</br>";	
													
												
											}
										}
											
										
										
		 							}?>
                                    
								<?php if(isset($_GET['show']) && $_GET['show'] == 'message'){
			  					$LoggedInUser = $_SESSION['userID'];
								$OtherGuy = $_GET['UserID']; //anotherpersons profile
								$_SESSION['UserID'] = $OtherGuy;
								?>
			              		<p>Latest Messages</p>
    							<div id = "ChatFeed"></div>
                                    <p>Message: <input type ="text" id ="textItem" name= 'message' value=""/></p>
                                    <p><input type="submit" value="Send" onClick="uploadMessages()"/></p>
									 <?php 
			  						}?>
								</div>	
   								<?php //update likes
								if (!isset($_GET['show'])){ 
									$getpostid = mysql_query("SELECT PostID FROM Post WHERE CreatorID = $userID");
									$i = 0;
									while ($row5 = mysql_fetch_assoc($getpostid)) {
										$pid = $row5['PostID'];
										$array_posts[$i] = $pid;
										$i++;
									}
									$i--;
								}
							?>
							<script> 
							<?php for($counter=0; $counter<=$i; $counter++){ 
								echo "setInterval('UpdateLikes($array_posts[$counter])', 2000);";
								}
					  		?>
							</script>	
    
</body>
<?php include_once "db_close.php"; ?>
</html>