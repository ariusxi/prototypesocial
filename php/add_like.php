<?php
	session_start();
	require_once "../config.php";
	include_once("../classes/BD.class.php");
	@BD::conn();
	include_once "../functions/funcoes.php";
	$id_post = (int)$_POST['post_id'];
	$id_user = (int)$_SESSION['id_user'];
	
	if(!verificar_clicado($id_post,$id_user)){
		if(adicionar_like($id_post,$id_user)){
			echo "sucesso";
		}else{
			echo "erro";
		}
	}else{
		echo "erro";
	}
?>