<?php session_start();


if (isset($_GET["logout"])){
session_unset(); 
session_destroy(); 	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once "db_open.php"; ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
	<title>index</title>

    
    
</head>

<style>

body{
	background:#F26F0D;
}

p{
	font-family:myriad pro;
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
}

#loginDiv p{
	padding-bottom:15px;
}

#newUserDiv{
	border-radius: 15px;
	color:#FFF;
	padding-top:0.5%;
	background-color:#F7B437;
	width:20%;
	text-align:center;
}

#loginPageFooter{
	color:#FFF;
	padding-top:5%;
	text-align:center;
}



</style>
<body>
	<div id="logoDiv" align="center">
    	<img src="Images/logo3.fw.png" width="25%;" />
    </div>
    
    <div id="loginCenter" align="center">
   		<div id="loginDiv">
        	<form action="index.php" method="post"><br>
				<input type="text" name="username" placeholder="Username"><br>
				<input type="password" name="password" placeholder="Password"><br><br>
				<input type="submit" name="login" value="Login"><br><br>
			</form>
   		</div>
    
    <div style="height:20px;"></div> <!--separator-->
    
    	<div id="newUserDiv">
    		<p>New? Sign Up Here! :)</p>
            <form action="index.php" method="post">
				<input type="text" name="newusername" placeholder="Username"><br>
                <input type="text" name="email" placeholder="Email"><br>
				<input type="password" name="newpassword" placeholder="Password"><br><br>
				<input type="submit" name="signUp" value="Sign Up"><br><br />
			</form>
        </div>
        
        <div id="loginPageFooter">
        	<p>2014 &copy QUESTBOOK</p>
        </div>
    </div>
</body>
<?php // Sign up //form 2

	
	if(isset($_POST['signUp'])){

		$username = (isset($_POST['newusername'])) ? $_POST['newusername'] : "" ;
		$username = mysql_real_escape_string($username);
		
		$password = (isset($_POST['newpassword'])) ? $_POST['newpassword'] : "" ;
		//$password = sha1($password);//use sha1 or md5
		
		$email = (isset($_POST['email'])) ? $_POST['email'] : "" ;
		$email = mysql_real_escape_string($email);
		
		
		if(empty($username) || empty($password) || empty($email)){
		
			echo "Please fill out ALL fields";
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
				$signupQuery = "
					INSERT INTO User (
						Username, 
						Password, 
						Email) 
					VALUES (
						'".$username ."',
						'". $password ."',
						'". $email ."') ";
				$signUpResult = mysql_query ($signupQuery);
				echo "Account created!";
				if (!$signUpResult)
					echo "no conection with user table";
			}else 
			{
				echo "This username or email already exists! Choose another one.";
			}
		}
	}
?>

<?php 
// Log in

$login = false;


if(isset($_POST['login'])){

	$user = (isset($_POST['username'])) ? $_POST['username'] : "" ;
	$user= mysql_real_escape_string($user);
	
	$pass = (isset($_POST['password'])) ? $_POST['password'] : "" ;
	//$pass = sha1($pass);//use sha1 or md5

	
		if(empty($user) || empty($pass)){
		
			echo "Please fill out ALL fields";
		}
		
		else {

			$loginQuery = "
				SELECT Username,UserID FROM 
					User 
				WHERE 
					Username 
				='". 
					$user . "' 
				AND
					Password
				='".
					$pass . "'";
			$loginResult = mysql_query ($loginQuery);
			
			
			
					while($row = mysql_fetch_assoc($loginResult)){
						
						$userID = $row["UserID"];
						$username = $row["Username"];
						
					}
					
			$matched_rows = mysql_num_rows($loginResult);
			
			
			if ($matched_rows==0)
				echo "Username or password is incorrect";
			else{
				echo "Welcome ". $user;
				$login = true;
				
				$_SESSION['userID'] = $userID;
				
				setcookie("username_cookie", $username, time()+3600);
				
				setcookie("userid_cookie", $userID, time()+3600);
				
				header("Location: homepage.php"); 
				//begin session
			}
				 
		
	}
		
}
?>


	<?php include_once "db_close.php"; ?>
</html>