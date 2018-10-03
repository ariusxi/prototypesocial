<?php
	require_once "../config.php";
	include_once("../classes/BD.class.php");
	@BD::conn();
	include_once "../functions/funcoes.php";
	$id_post = (int)$_POST['post_id'];
	$id_user = (int)$_POST['user_id'];
	
	if(un_like($id_post,$id_user)){
		echo "sucesso";
	}else{
		echo "erro";
	}
?>