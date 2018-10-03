<?php
	if($_GET['u'] != ""){
		session_start();
		session_start();
		require_once "config.php";
		include_once("classes/BD.class.php");
		@BD::conn();
		
		$atualiza = @BD::conn()->prepare("UPDATE users SET status = 1 WHERE link = ?");
		$atualiza->execute(array($_GET['u']));
		
		$seleciona = @BD::conn()->prepare("SELECT * FROM users WHERE link = ?");
		$seleciona->execute(array($_GET['u']));
		while($dados = $seleciona->fetchObject()){
			$_SESSION['id_user'] = $dados->id;
		}
		
		echo "<script>alert('Conta ativada com sucesso');location.href='painel.php';</script>";
	}
?>