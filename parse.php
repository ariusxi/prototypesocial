<?php
	header('Access-Control-Allow-Origin: *');
	session_start();
	require_once "config.php";
	include_once("classes/BD.class.php");
	require_once "classes/Friends.php";
	@BD::conn();
	
	if(isset($_POST['tags'])){
		if($_POST['tags'] == 'addFriend'){
			$friends = new Friends;
			$friends->add($_POST['uid'],$_SESSION['id_user']);
		}
	}
?>