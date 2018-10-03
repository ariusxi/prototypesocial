<?php
	session_start();
	require_once "../config.php";
	include_once("../classes/BD.class.php");
	@BD::conn();
	$load = htmlentities(strip_tags($_POST['load'])) * 2;
	
	$query = @BD::conn()->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT ".$load.",2");
	$query->execute();
	
	echo "<script>alert('".$query->rowCount()."');</script>";
?>