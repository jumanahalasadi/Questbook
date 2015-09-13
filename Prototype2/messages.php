
<?php
//session_start();
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

<?php include_once "db_open.php"; ?>


<?php
 
 $userID = $_SESSION['userID'];
$sql = "SELECT Message.MessageID, Message.Text, Message.SenderID, Message.RecieverID FROM Message INNER JOIN User ON Message.MessageID = User.UserID WHERE Message.RecieverID = $userID";
$resultQuery = mysql_query($sql);
 
?>
        <div id="heading">
        	<h1>Wall of Fame</h1>
        </div>
         
        <!------------------------------------->
        <div id = "postsREQUESTS">
        	<div id="questsheading">
            	<h3>MESSAGES</h3>
            </div>

        	<div id="messageboxes">
             
        <!-----------------NEW-------------------->
             
  <script>
  
  function uploadMessages()
	{
		var MessageData = "uMessages="+document.getElementById("textItem").value;	
		
		document.getElementById("textItem").value = '';
		
		var xmlHttp = new XMLHttpRequest();
		<!-- change the file name -->
		xmlHttp.open("post", "uploadMessage.php", true);
		
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.setRequestHeader("Content-length", MessageData.length);
		xmlHttp.setRequestHeader("Connection", "close");
		
		xmlHttp.onreadystatechange = function ()
		{
			if(xmlHttp.readyState == 4)
			{
				if(xmlHttp.status == 200)
				{
					/*alert("Message Posted");*/
				}
				else
				{
					alert("Oh no, an error occured");
				}
			}
		};
		xmlHttp.send(MessageData);
	}
  
  </script>       
  
  <!--------------------END OF NEW STUFF--->        
			<?php 
			
			$userID = $_SESSION['userID'];
			$counter = 0;
			$messageNumber = 0;
			while($rowData = mysql_fetch_assoc($resultQuery))
			{	
				$messageNumber++;
				echo $messageNumber;
			?>
			
			<a href="messages.php?msg=<?php $counter; ?>">
            <?php
			
			echo "Message from " . $rowData['SenderID']. "</br>";
			?>
            
			</a>
            <?php
			echo "</br>"; 
			
			if (isset($_GET["msg"])){
				
				if ($counter)
				?>
				<?php echo $rowData['Text'] . "</br>"; ?> 
				<?php	
				
				
			}
			
			//end of while loop
			}

			?>
            
            <form method='post'>
            <?php
            echo "<select name='MessageID'>";
$resultSelect = mysql_query("SELECT GroupID FROM Groups WHERE GroupID > 0");

if(!$resultSelect)
	echo mysql_error();

else

{	
	
	while($rowSelect = mysql_fetch_assoc($resultSelect))
	{	
		$id = $rowSelect['GroupID'];  
		echo "<option value='$id' >".$rowSelect['GroupID']."</option>";
		echo "</br>";	
			
	}
}
?>
      </select>
            
            
            
            
            
             <p> Reply:
    <input type="text" id="textItem" name="message" value=""/>
  </p>
  <p>
    <input type="submit" value="Send" name="sendMessage" onClick="uploadMessages()"/>
  </p>    
        </form>    
            
            
            
            </div>
          
          
          <!--  
            <div style="padding:15px;">
    <table>
        <form action="index.php" method='post'>
            <tr>
                <td><input type='text' name='ReplyMessage' value=''/></td>        
                <td><input type='submit' name='NewUser' value='Reply'/></td>
             </tr>
        </form>
      </table>
 </div>
 -->
        </div>
        
        
        <!------------------------------------->\
<?php include_once "db_close.php"; ?>