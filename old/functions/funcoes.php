<?php
	function get_artigos(){
		$seleciona_posts = @BD::conn()->prepare("SELECT * FROM posts ORDER BY id DESC");
		$seleciona_posts->execute();
		if($seleciona_posts->rowCount() == 0){
			echo "<h2 style='color:#ccc;cursor:context-menu;' align='center'>".utf8_encode("Não há Postagens")."</h2>";
		}
		while($dados = $seleciona_posts->fetchObject()){
			$id_user = $dados->id_user;
			$seleciona = @BD::conn()->prepare("SELECT name,lastname,image FROM users WHERE id = ?");
			$seleciona->execute(array($dados->id_user));
			while($dado = $seleciona->fetchObject()){
				$nome = $dado->name." ".$dado->lastname;
				$imagem = $dado->image;
			}
			echo "<div class='panel panel-default' style='margin-top:1%'>";
			echo "<div class='panel-body'>";
			echo "<div class='col-md-12'>";
			echo "<p><a href='perfil.php?id=".$id_user."'><img src='img/perfis/".$imagem."' class='img-perfil'/></a>&nbsp;<a href='perfil.php?id=".$id_user."'><strong>".$nome."</strong></a></p>";
			echo "<p style='font-size:10px;color:#ccc;'>".$dados->created_at."</p>";
			if($dados->tipo == "imagem"){
				echo "<p><center><img src='img/postagens/".$dados->imagem."'/ style='position:relative;width:100%;height:100%;border-radius:10px;'></center></p>";
			}elseif($dados->tipo == "texto"){
				echo "<p>".$dados->texto."</p>";
			}
			echo "<div id='comentarios'>";
			echo utf8_encode("<input type='text' class='form-control comentario' id='".$dados->id."' value='' style='margin-top:1%;' placeholder='Escreve o seu comentário' maxlength='255'/>");
			echo "<div id='post_".$dados->id."'>";
			$seleciona_comments = @BD::conn()->prepare("SELECT * FROM comments WHERE id_post = ?");
			$seleciona_comments->execute(array($dados->id));
			while($comments = $seleciona_comments->fetchObject()){
				$seleciona_user = @BD::conn()->prepare("SELECT name,lastname,image FROM users WHERE id = ?");
				$seleciona_user->execute(array($comments->id_user));
				while($user = $seleciona_user->fetchObject()){
					$nome_c = $user->name." ".$user->lastname;
					$imagem_c = $user->image;
				}
				echo "<div class='comentario'><p><a href='perfil.php?id=".$comments->id_user."'><img src='img/perfis/".$imagem_c."' class='img-perfil'/></a>&nbsp;<strong><a href='perfil.php?id=".$comments->id_user."'><span>".$nome_c."</span></a></strong>&nbsp;".$comments->comment."</p></div>";
			}
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}
	}
	function get_artigos_user(){
		$seleciona_posts = @BD::conn()->prepare("SELECT * FROM posts WHERE id_user = ? ORDER BY id DESC");
		$seleciona_posts->execute(array($_GET['id']));
		if($seleciona_posts->rowCount() == 0){
			echo "<h2 style='color:#ccc;cursor:context-menu;' align='center'>".utf8_encode("Não há Postagens")."</h2>";
		}
		while($dados = $seleciona_posts->fetchObject()){
			$id_user = $dados->id_user;
			$seleciona = @BD::conn()->prepare("SELECT name,lastname,image FROM users WHERE id = ?");
			$seleciona->execute(array($dados->id_user));
			while($dado = $seleciona->fetchObject()){
				$nome = $dado->name." ".$dado->lastname;
				$imagem = $dado->image;
			}
			echo "<div class='panel panel-default' style='margin-top:1%'>";
			echo "<div class='panel-body'>";
			echo "<div class='col-md-12'>";
			echo "<p><a href='perfil.php?id=".$id_user."'><img src='img/perfis/".$imagem."' class='img-perfil'/></a>&nbsp;<a href='perfil.php?id=".$id_user."'><strong>".$nome."</strong></a></p>";
			echo "<p style='font-size:10px;color:#ccc;'>".$dados->created_at."</p>";
			if($dados->tipo == "imagem"){
				echo "<p><center><img src='img/postagens/".$dados->imagem."'/ style='position:relative;width:100%;height:100%;border-radius:10px;'></center></p>";
			}elseif($dados->tipo == "texto"){
				echo "<p>".$dados->texto."</p>";
			}
			echo "<div id='comentarios'>";
			echo utf8_encode("<input type='text' class='form-control comentario' id='".$dados->id."' value='' style='margin-top:1%;' placeholder='Escreve o seu comentário' maxlength='255'/>");
			echo "<div id='post_".$dados->id."'>";
			$seleciona_comments = @BD::conn()->prepare("SELECT * FROM comments WHERE id_post = ?");
			$seleciona_comments->execute(array($dados->id));
			while($comments = $seleciona_comments->fetchObject()){
				$seleciona_user = @BD::conn()->prepare("SELECT name,lastname,image FROM users WHERE id = ?");
				$seleciona_user->execute(array($comments->id_user));
				while($user = $seleciona_user->fetchObject()){
					$nome_c = $user->name." ".$user->lastname;
					$imagem_c = $user->image;
				}
				echo "<div class='comentario'><p><a href='perfil.php?id=".$comments->id_user."'><img src='img/perfis/".$imagem_c."' class='img-perfil'/></a>&nbsp;<strong><a href='perfil.php?id=".$comments->id_user."'><span>".$nome_c."</span></a></strong>&nbsp;".$comments->comment."</p></div>";
			}
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}
	}
?>