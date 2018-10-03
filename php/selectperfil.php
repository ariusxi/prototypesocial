<?php
	$select_dados = @BD::conn()->prepare("SELECT * FROM users WHERE id = ?");
	$select_dados->execute(array($_GET['id']));
	while($dados = $select_dados->fetchObject()){
		$name_perfil = $dados->name;
		$lastname_perfil = $dados->lastname;
		$image_perfil = $dados->image;
		$email_perfil = $dados->email;
		$capa_perfil = $dados->capa;
		$data_nascimento_perfil = $dados->data_nascimento;
		$imagem_perfil = $dados->image;
	}
	$data = date("Y");
	$data_nasc = substr($data_nascimento,0,4);
	$data_nasc = $data - $data_nasc;
?>