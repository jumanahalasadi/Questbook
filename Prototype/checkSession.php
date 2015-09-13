<?php

function checkCookie(){
	
	if(!isset($_COOKIE["username_cookie"])) {
		return false;
	} else {
		return true;
	}


	
}


?>