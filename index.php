<?php 
	require 'config.php';
	session_start();

	if(isset($_SESSION['login'])){
		include 'view/user.html';
	}else{
		include 'view/login.html';
	}

?>