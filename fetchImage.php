<?php

// page loads and does not cache because AJAX cannot uncache the image
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
//is imageID valid and ready to be used
	if(isset($_REQUEST['imageID']))
	{
		
		include 'db_open.php';
		
		$sqlImage = "SELECT MediaTitle, MediaType, CreatorID, QuestID, Likes, Date FROM Post WHERE PostID = 29";
		$resultImage = mysql_query($sqlImage);
		
		if($resultImage){
		
			if(mysql_num_rows($resultImage) == 1)
			{
				$rowData = mysql_fetch_assoc($resultImage);
				
				
				$imgtype = $rowData['MediaType'];
				$imgfile = "Uploads/{$rowData['MediaTitle']}";
				$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
				
				
				//use these to open the file
				
				echo "<img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' height='300' width='300'/>"; 
				
				echo "<br/><center>{$rowData['MediaTitle']}</center><br/>\n";
					
			}
		
			
		}
		
		
		
		
		include 'db_close.php';
		
		
	}
	?>