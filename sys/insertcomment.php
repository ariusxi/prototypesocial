<?php
	session_start();
	require_once "../config.php";
	include_once("../classes/BD.class.php");
	@BD::conn();
	
	$comment = $_POST['comment'];
	$post = $_POST['post'];
	
	$seleciona = @BD::conn()->prepare("SELECT name,lastname,image FROM users WHERE id = ?");
	$seleciona->execute(array($_SESSION['id_user']));
	while($dado = $seleciona->fetchObject()){
		$nome = $dado->name." ".$dado->lastname;
		$imagem = $dado->image;
	}
	
	$inserir = @BD::conn()->prepare("INSERT INTO comments(id_post,id_user,comment,created_at) VALUES(?,?,?,NOW())");
	$inserir->execute(array($post,$_SESSION['id_user'],$comment));
	
	echo "<div class='comentario'><p><a href='perfil.php?id=".$_SESSION['id_user']."'><img src='img/perfis/".$imagem."' class='img-perfil'/></a>&nbsp;<strong><a href='perfil.php?id=".$_SESSION['id_user']."'><span>".$nome."</span></a></strong>&nbsp;".$comment."</p></div>";
?>