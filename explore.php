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
    <title>Explore</title>

    <!---------    Javascript       -------->
    <script type="text/javascript">
    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url,'popUpWindow','height=400,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,status=yes')
    }
	
	function alertuser(string){
		alert(string);
	}
    </script>
    
    </head>
    <body>
    
    <!--------   Header + Logo + etc. STARTS HERE   --------->
    <div id="topPage">
        <div id="cornerLogo"> <a href="homepage.php"> <img src="Images/logo2.png" width="217px" 
                onmouseover="this.src='Images/logo2_hover.png'  "
                onmouseout="this.src='Images/logo2.png'  "
                onmousedown="this.src='Images/logo2_hover.png'  "/></a> 
        </div>
		
        <div id="profileTab"><a href="profile.php" style="text-decoration:none">
        	<h3>MY PROFILE</h3>
        </a></div>
		<div id="exploreTabActive"><a href="explore.php" style="text-decoration:none">
        	<h3>EXPLORE</h3>
        </a></div>
        <div id="requestsTab"><a href="requests.php" style="text-decoration:none">
        	<h3>REQUESTS</h3>
        </a></div>
      
      	<div id="logoutName">
          
        <!-----      Logged in       ------>
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
</div>

<div id="logoutButton"> <a href="index.php?logout=true" style="text-decoration:none">
    <h1>Log Out</h1>
</a> </div>

</div>
<!--------   Header + Logo + etc. ENDS HERE   --------->

<!----------     Side Menu STARTS HERE    ------------->
<div id="settings"> <img src="Images/seticon.png" width="30px;" /> </div>
    <div id = "sidebar">
      <div id="profile">
        <div id = "picture">
          <?php	
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

<div id="Messages"> <a href="profile.php?show=messages" style="text-decoration:none">
	<h2>Messages</h2>
</a></div>
<div id="Circle"> <a href="profile.php?show=circle" style="text-decoration:none">
    <h2>Circle</h2>
</a></div>
<div id="CompletedQuests" > <a href="profile.php?show=completed" style="text-decoration:none">
    <h2>Completed Quests</h2>
</a></div>
</div>
<!----------     Side Menu ENDS HERE    ------------->

<div id="searchbar">
  <form action="explore.php" method="post">
    <input type="text" name="searchtext" size="60" placeholder="Search..." required="required" />
    <input type="submit" name="search" value="Search" />
  </form>
</div>

<div id = "wrapper"> <!-------------------   Wrapper Div STARTS here    ------------------> 
    <div id="heading">
  	  <h1>Wall of Fame</h1>
	</div>
	<div id = "explorediv1"> <!---------   Search Quests Div STARTS here    -------------->
        <div id="exploredivone">
            <h3>QUESTS</h3>
            
            <div id="dropdown" style="margin-top:-250px; margin-left:-400px;">
                <form action="explore.php" method="post">
                	<h2>Filter by 
                    <select name="difficulties" onchange="this.form.submit()">
                    	<option value="Diff">Difficulty:</option>
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                    </select>
                    <input type="submit" name="submit" value="Go!">
                    </h2>
                </form>
            </div>
        </div>
        <div id="exploredivinfo">
        <?php
            $userID = $_SESSION['userID'];
			$difficulties = 0;
			$searchstring = 0;
			
            if(isset($_POST['search'])){
                $searchstring = (isset($_POST['searchtext'])) ? $_POST['searchtext'] : "" ;
                echo "<h3>" . "Search results for: '" . $searchstring . "'</h3>";
            }
			else if(isset($_POST['difficulties'])){
				$difficulties = (isset($_POST['difficulties'])) ? $_POST['difficulties'] : "" ;
				
				if($difficulties != 'Diff')
					echo "<h3>" . "Search results for: '" . $difficulties . "'</h3>";
            }

			if($difficulties)
			{
				if($difficulties == 'Diff')
				{
					//nothing
				}
				else
				{
					if($difficulties == 'Easy')
					{
						$sql = "SELECT * FROM Quests WHERE Points < 100";
						$sqlRes = mysql_query($sql);
					}
					else if($difficulties == 'Medium')
					{
						$sql = "SELECT * FROM Quests WHERE Points >= 100 AND Points < 600";
						$sqlRes = mysql_query($sql);
					}
					else if($difficulties == 'Hard')
					{
						$sql = "SELECT * FROM Quests WHERE Points >= 600";
						$sqlRes = mysql_query($sql);
					}				
				
					while($row = mysql_fetch_assoc($sqlRes)){
						$quests = $row["Name"];
						$description = $row["Description"];
						$q_id = $row['QuestID'];
						
						$points = $row['Points'];
						
						if($points < 100)
						{
							$difficulty = 'Easy';
						}
						else if($points >= 100 && $points < 600)
						{
							$difficulty = 'Medium';
						}
						else if($points >= 600)
						{
							$difficulty = 'Hard';
						}
						
						echo "</br>";
						echo "<a style='font-weight: bold; font-size:large;'>" . $quests . " </a>";
						echo "<p style='font-size:medium;'>" . $description . " </p>";
						echo "Difficulty: " . $difficulty . " </p>";
						echo "<div style='margin-top:-30px; margin-left:500px;'>" . "<a href='explore.php?quest=
						$q_id&action=do' style='text-decoration:none; color:#cb6019; font-weight:bold; font-size:large; border:thin;'  >" . "Do!" . "</a>" . "</br>" . "<a href=\"JavaScript:newPopup('challenge.php?quest=
						$q_id&action=challenge')\" style='text-decoration:none; color:#cb6019; font-weight:bold;  font-size:large; ' >" . "Challenge!" . "</a>" . "</div>" ;
						echo "<hr>";
					}
				}
			}
            else{
                $sql = "SELECT * FROM Quests WHERE Name LIKE '%$searchstring%' ORDER BY Name";
                $result = mysql_query($sql);
                while($row = mysql_fetch_assoc($result)){
                    $quests = $row["Name"];
                    $description = $row["Description"];
                    $q_id = $row['QuestID'];
					
					$points = $row['Points'];
					
					if($points < 100)
					{
						$difficulty = 'Easy';
					}
					else if($points >= 100 && $points < 600)
					{
						$difficulty = 'Medium';
					}
					else if($points >= 600)
					{
						$difficulty = 'Hard';
					}
					
                    echo "</br>";
                    echo "<a style='font-weight: bold; font-size:large;'>" . $quests . " </a>";
                    echo "<p style='font-size:medium;'>" . $description . " </p>";
					echo "Difficulty: " . $difficulty . " </p>";
                    echo "<div style='margin-top:-30px; margin-left:500px;'>" . "<a href='explore.php?quest=
                    $q_id&action=do' style='text-decoration:none; color:#cb6019; font-weight:bold; font-size:large; border:thin;'  >" . "Do!" . "</a>" . "</br>" . "<a href=\"JavaScript:newPopup('challenge.php?quest=
                    $q_id&action=challenge')\" style='text-decoration:none; color:#cb6019; font-weight:bold;  font-size:large; ' >" . "Challenge!" . "</a>" . "</div>" ;
                    echo "<hr>";
                }
            }
            
            if(isset($_GET['action'])){
                $q_id = $_GET['quest'];
                //sql statement to 
                if(isset($_GET['action']) && $_GET['action'] == "do" ){
					//Check if the user has done that quest
					$check = mysql_query("SELECT ID FROM Requests WHERE QuestID = $q_id AND RecieverID = $userID");
					$donethisbefore = mysql_num_rows($check);
					
					if ($donethisbefore){
						?>
                        
                       <script>  alert('Error: You already have this requested: Cannot do it again!'); </script>
                 
						<?php
					}
					else {	
					//sql to insert to my requests
					$sql = "INSERT INTO Requests (ChallengerID , RecieverID , QuestID, Completed)VALUES ( '$userID' , '$userID' , '$q_id ', 0)";
					$result = mysql_query($sql);
					}
				}
            }
            else {
                //do nothing
            }
        ?>
        </div>
    </div>
    <!---------   Search Quests Div ENDS here    -------------->
      
    <!---------   Search Users Div STARTS here    -------------->
    <div id = "explorediv2"> 
        <div id="exploredivtwo">
          <h3>USERS</h3>
        </div>
        <div id="exploredivinfo">
        <?php
            if(isset($_POST['search'])){
                $searchstring = (isset($_POST['searchtext'])) ? $_POST['searchtext'] : "" ;
                echo "<h3>" . "Search results for: '" . $searchstring . "' ";
                echo "</br>";
            }
                        
            if(empty($searchstring)){
                echo "<h3>Search was empty</h3>";
            }
            else{
                $sql = "SELECT Username, UserID FROM User WHERE Username LIKE '%$searchstring%' ORDER BY Username";
                $result = mysql_query($sql);	
                $rows = mysql_num_rows($result);
                while($row = mysql_fetch_assoc($result)){
                    $user = $row["Username"];
                    $id = $row["UserID"];
                    echo "</br>";
                    echo "<a href=profile.php?UserID=$id style='text-decoration:none; color:black; '>" . $user ." </a>";
                    echo "<hr>";
                }
            }
        ?>
        </div>
    </div>
    <!-------------------   Users Quests Div ENDS here    ------------------>
     
    <!-----------------   All QUESTS Div STARTS here    -------------------->  
    <div id = "explorediv3"> 
        <div id="exploredivthree">
            <h3>ALL QUESTS</h3>
        </div>
        <div id="exploredivinfo">
        <?php
            $sql = "SELECT * FROM Quests";/* ORDER BY Date DESC*/
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)){
                $q_id = $row['QuestID'];
				
				$points = $row['Points'];
					
				if($points < 100)
				{
					$difficulty = 'Easy';
				}
				else if($points >= 100 && $points < 600)
				{
					$difficulty = 'Medium';
				}
				else if($points >= 600)
				{
					$difficulty = 'Hard';
				}
				
                echo "</br>";
                echo "<table>";
                echo "<a style='font-weight: bold; font-size:large;'>" . $row["Name"] ." </a>";
                echo "<p style='font-size:medium;'>" . $row["Description"] ." </p>";
				echo "Difficulty: " . $difficulty . " </p>";
                echo "<p><div style='margin-top:-30px; margin-left:500px;'>" . "<a href='explore.php?quest=
                                    $q_id&action=do' style='text-decoration:none; color:#cb6019; font-weight:bold; font-size:large; border:thin;' >" . "Do!" . "</a>" . "</br>" . "<a href=\"JavaScript:newPopup('challenge.php?quest=$q_id&action=challenge')\" style='text-decoration:none; color:#cb6019; font-weight:bold; font-size:large; border:thin;'>" . "Challenge!" . "</a>" . "</div></p>" ;
                echo "</table>";
                echo "<hr>";
				
				       echo "</br>";
       
           
				
				
            }
        ?>
        </div>
    </div> <!----------------   All QUESTS Div ENDS here    ----------------> 
</div> <!-------------------   Wrapper Div STARTS here    ------------------> 

</body>
<?php include_once "db_close.php"; ?>
</html>