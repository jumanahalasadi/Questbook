<?php
include_once("db_open.php");

$cgrp = (isset($_REQUEST['ugrp'])) ? $_REQUEST['ugrp'] : "N/A";  //checks if superglobal is set, terniary statement. if it is SET cNews to the superglobal, if not say N/A

//insert data into the database using the now() sql function for the date.
$resultInsert = mysql_query("INSERT INTO Groups (GroupName) VALUES ('$cgrp')");
$groupidresult = mysql_query("SELECT Username FROM User WHERE UserID = $userID");

				//insert data into the database using the now() sql function for the date.
				$resultInsert = mysql_query("INSERT INTO Friends (FriendID) VALUES ('$cgrp')");
				
				if(!$resultInsert) //if error
					echo mysql_error();
				?>
				 <script>
				 
				  alert ("You are now following this user!");
				 document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';				
			 </script> 

<?php
include_once("db_close.php");
?>


				
				<?php
				/*
				$userID = $_GET['UserID']; //the other guy

				 //	$sql = "SELECT Username, Level FROM User WHERE UserID = $userID";
					//$result = mysql_query($sql);
					
					//while($row = mysql_fetch_assoc($result))
					//{						
					//	$user = $row["Username"];
					//}
				 
				 
				// $groupidresult = mysql_query("SELECT GroupID FROM Groups WHERE GroupName = '$cgrp'");
				
				$cgrp = (isset($_REQUEST['ugrp'])) ? $_REQUEST['ugrp'] : "N/A";
				 
				$groupidresult = mysql_query("SELECT Username FROM User WHERE UserID = $userID");

				//insert data into the database using the now() sql function for the date.
				$resultInsert = mysql_query("INSERT INTO Friends (FriendID) VALUES ('$cgrp')");
				//$groupname = mysql_query("INSERT INTO ChatUsers (GroupID) VALUES ('$groupidresult')");
				if(!$resultInsert) //if error
					echo mysql_error();*/
				 ?>
				