<?php
	session_start();
	require_once "../config.php";
	include_once("../classes/BD.class.php");
	@BD::conn();
	include_once "../functions/funcoes.php";
	$id_post = (int)$_POST['post_id'];
	$numero_de_likes = retornar_likes($id_post);
	echo $numero_de_likes;
?>