<?php
	$select_dados = @BD::conn()->prepare("SELECT * FROM users WHERE id = ?");
	$select_dados->execute(array($_SESSION['id_user']));
	while($dados = $select_dados->fetchObject()){
		$username = $dados->username;
		$name = $dados->name;
		$lastname = $dados->lastname;
		$image = $dados->image;
		$email = $dados->email;
		$capa = $dados->capa;
		$data_nascimento = $dados->data_nascimento;
		$imagem = $dados->image;
	}
	$data = date("Y");
	$data_nasc = substr($data_nascimento,0,4);
	$data_nasc = $data - $data_nasc;

?>