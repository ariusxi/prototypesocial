<?php
	if(isset($_POST['acao']) && $_POST['acao'] == 'posta_texto'):
		$inserir = @BD::conn()->prepare("INSERT INTO posts(id_user,texto,tipo,created_at) VALUES(?,?,?,NOW())");
		$inserir->execute(array($_SESSION['id_user'],$_POST['text'],"texto"));
	elseif(isset($_POST['acao']) && $_POST['acao'] == 'posta_imagem'):
		$destino = "img/postagens/".$_FILES['imagem']['name'];
		$arquivo = $_FILES['imagem']['name'];
		move_uploaded_file($_FILES['imagem']['tmp_name'],$destino);
		$inserir = @BD::conn()->prepare("INSERT INTO posts(id_user,imagem,tipo,created_at) VALUES(?,?,?,NOW())");
		$inserir->execute(array($_SESSION['id_user'],$arquivo,"imagem"));
	endif;
?>