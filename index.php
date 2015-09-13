<?php session_start();

if (isset($_GET["logout"])){
	session_unset(); 
	session_destroy(); 	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once "db_open.php";?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>index</title>
</head>

<style>

body{
	background:#F26F0D;
}

p, h2, h3, h4{
	font-family:myriad pro;
}

h3, h4 {
	color:#3e3e40;	
}


#logoDiv{
	padding-top:5%;
	border-radius:15px;
}

#loginCenter{
	padding-top:1%;
}

#loginDiv{
	border-radius: 15px;
	color:#FFF;
	padding-top:0.5%;
	background-color:#F7B437;
	width:20%;
	text-align:center;
		padding: 1%;
}

#loginDiv p{
	padding-bottom:15px;
		padding: 5%;
}

#newUserDiv{
	border-radius:15px;
	color:#FFF;
	padding-top:0.5%;
	background-color:#F7B437;
	width:20%;
	text-align:center;
		padding: 1%;
}
#invisible
{
	
}

#aboutDiv{
	border-radius:15px;
	color:#FFF;
	background-color:#F7B437;
	padding-top:18%;
	padding-bottom:30%;
	width:100%;
	text-align:center;
}

#loginPageFooter{
	margin-top:-45px;
	color:#FFF;
	padding-top:0%;
	text-align:center;
}

#contribution{
	margin-bottom:-350px;
}

#contribution a
{
	font-size:18px;
	color:#fff;
}

#image
{
	text-align:center;
	/*width:0.5%;*/
}
#imageUp
{
	text-align:center;
}
</style>

<body>
	<a name="newQuesters2">
	<div id="logoDiv" align="center">
    	<img src="Images/logo3.fw.png" width="25%;" />
    </div>
    
    <div id="loginCenter" align="center">
   		<div id="loginDiv">   
        <h3>Continue your adventure..</h3>
        	<?php LoginInfoCheck(); ?>         
        	<form action="index.php" method="post"><br>
				<input type="text" name="username" placeholder="Username"><br>
				<input type="password" name="password" placeholder="Password"><br><br>
				<input type="submit" name="login" value="Login">
			</form>
   		</div>
    
    	<div style="height:20px;"></div> <!--separator-->
    
    	<div id="newUserDiv">
        	<?php SignupInfoCheck(); ?>
            <h4>Challenge yourself and friends with new quests daily!</h4>
            <p>It all starts here. Sign-up now for FREE!</p>
            <form action="index.php" method="post">
				<input type="text" name="newusername" placeholder="Username"><br>
                <input type="text" name="email" placeholder="Email"><br>
				<input type="password" name="newpassword" placeholder="Password"><br><br>
				<input type="submit" name="signUp" value="Sign Up">
		
			</form>
        </div>
        
        <div style="height:200px;"></div> <!--separator-->
    	<div id ="image">
      		<a href="#newQuesters"><img src="Profile/arrow1.png" alt="arrow" height="60" width="60"></a>
        </div>
        <div style="height:160px;"></div> <!--separator-->
        
        <div id="loginPageFooter">
        	<p>2014 &copy QUESTBOOK</p>
        </div>
        
    	<a name="newQuesters">
        <div id="aboutDiv">
        	
        	<div id ="imageUp">
      			<a href="#newQuesters2"><img src="Profile/arrow2.png" alt="arrow" height="60" width="60"></a>
      	    </div>
            <div style="height:15px;"></div> <!--separator-->
    		<h2>Hello New Questers!</h2>
            
                 <p>Challenge your friends and take part in trending quests.</p>
                 <p>Post photos of your quests and share them with your circle of friends.</p>
                 <p>Follow your favourite celebrities and watch them do exciting tasks.</p>
                 <p>Accumulate points, level up and make it to the Wall of Fame!</p>
                 <p>Participate in seasonal and special quests such has Halloween Scare, Santa Dress Up and more!</p>
                 <h3>It's all free! Sign up now.</h3>
                 
                 <div style="height:50px;"></div> <!--separator-->
                 <div id = "contribution">
					
				</div>
        </div>
    </div>
</body>

<?php function SignupInfoCheck()
{
// Sign up //form 2
	if(isset($_POST['signUp'])){

		$username = (isset($_POST['newusername'])) ? $_POST['newusername'] : "" ;
		$username = mysql_real_escape_string($username);
		
		//$hashed_password = (isset($_POST['newpassword'])) ? password_encrypt($_POST['newpassword']) : "" ;
		
		$password = (isset($_POST['newpassword'])) ? md5($_POST['newpassword']) : "" ;
		
		$email = (isset($_POST['email'])) ? $_POST['email'] : "" ;
		$email = mysql_real_escape_string($email);
		
		if(empty($username) || empty($password) || empty($email)){
			echo "<p>Please fill out ALL fields</p>";
		}
		else {
			//1. check if there is the same username or email
			$checkUsernameQuery = "SELECT Username FROM User WHERE Username ='". $username . "'";
			$checkUsernameResult = mysql_query ($checkUsernameQuery);
			
			$checkEmailQuery = "SELECT Email FROM User WHERE Email =". $email . "'";//Distin...
			$checkEmailResult = mysql_query ($checkEmailQuery);
			
			$matched_rows = mysql_num_rows($checkUsernameResult);
			
			//2, If query is not true create a new row
			if ($matched_rows==0)
			{
				$signupQuery = "INSERT INTO User(Username, Password, Email) VALUES ('".$username ."','". $password ."','". $email ."') ";
				$signUpResult = mysql_query ($signupQuery);
				
				echo "<p>Account created!</p>";
				
				if (!$signUpResult)
					echo "<p>No conection with user table</p>";
			}else 
			{
				echo "<p>This username or email already exists! Choose another one.</p>";
			}
		}
	}
}
 
function LoginInfoCheck()
{
	// Log in
	$login = false;
	
	if(isset($_POST['login'])){
	
		$user = (isset($_POST['username'])) ? $_POST['username'] : "" ;
		$user= mysql_real_escape_string($user);
		
		$pass = (isset($_POST['password'])) ? $_POST['password'] : "" ;
		//$pass = sha1($pass);//use sha1 or md5
		
			if(empty($user) || empty($pass)){
			
				echo "<p>Please fill out ALL fields</p>";
			}
			else {
				//$loginQuery = "SELECT Username,UserID FROM User WHERE Username ='". $user . "' AND Password ='". $pass . "'";
				$loginQuery = "SELECT Username,UserID,Password FROM User WHERE Username = '$user'";
				$loginResult = mysql_query ($loginQuery);
				
						while($row = mysql_fetch_assoc($loginResult)){
							
							$userID = $row["UserID"];
							$username = $row["Username"];
							$password = $row["Password"];
							
							$check = md5($pass);

							if ($check != $password)
								echo "<p>Username or password is incorrect</p>";
							else{
								echo "<p>Welcome ". $user . "</p>";
								$login = true;
								
								$_SESSION['userID'] = $userID;
								
								setcookie("username_cookie", $username, time()+3600);
								
								setcookie("userid_cookie", $userID, time()+3600);
								
								header("Location: homepage.php"); 
								//begin session
							}
						}
		}
	}
}
?>

<?php include_once "db_close.php"; ?>
</html>