<?php
	session_start();
	include_once "../config.php";
	require_once("../classes/BD.class.php");
	@BD::conn();
	
	$delete = @BD::conn()->prepare("DELETE FROM posts WHERE id = ?");
	$delete->execute(array($_POST['id']));
	
	$delete = @BD::conn()->prepare("DELETE FROM likes WHERE post_id = ?");
	$delete->execute(array($_POST['id']));
	
	$delete = @BD::conn()->prepare("DELETE FROM comments WHERE id_post = ?");
	$delete->execute(array($_POST['id']));
?>