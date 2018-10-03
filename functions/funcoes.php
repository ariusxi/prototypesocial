<?php
	header('Access-Control-Allow-Origin: *');
	function get_artigos(){
		$_SESSION['posts_carregados'] = array();
		
		$seleciona_posts = @BD::conn()->prepare("SELECT * FROM posts ORDER BY id DESC");
		$seleciona_posts->execute();
		if($seleciona_posts->rowCount() == 0){
			echo "<h2 style='color:#ccc;cursor:context-menu;' align='center'>".utf8_encode("Não há Postagens")."</h2>";
		}
		while($dados = $seleciona_posts->fetchObject()){
			$id_user = $dados->id_user;
			$_SESSION['posts_carregados'][] = $seleciona_posts->id;
			$seleciona = @BD::conn()->prepare("SELECT name,lastname,image FROM users WHERE id = ?");
			$seleciona->execute(array($dados->id_user));
			while($dado = $seleciona->fetchObject()){
				$nome = $dado->name." ".$dado->lastname;
				$imagem = $dado->image;
			}
			echo "<div class='panel panel-default' id='postagem_".$dados->id."' style='margin-top:1%'>";
			echo "<div class='panel-body'>";
			echo "<div class='col-md-12'>";
			echo "<p><a href='perfil.php?id=".$id_user."'><img src='img/perfis/".$imagem."' class='img-perfil'/></a>&nbsp;<a href='perfil.php?id=".$id_user."'><strong>".$nome."</strong></a>";
			if($id_user == $_SESSION['id_user']){
				echo "<a class='delete' onclick='delete_post(".$dados->id.");'><i class='glyphicon glyphicon-remove'></i></a>";
			}
			echo "</p>";
			echo "<p style='font-size:10px;color:#ccc;'>".$dados->created_at."</p>";
			if($dados->tipo == "imagem"){
				echo "<p><center><img src='img/postagens/".$dados->imagem."'/ style='position:relative;width:100%;height:100%;border-radius:10px;'></center></p>";
			}elseif($dados->tipo == "texto"){
				echo "<p>".$dados->texto."</p>";
			}
			$valida = @BD::conn()->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
			$valida->execute(array($_SESSION['id_user'],$dados->id));
			if($valida->rowCount() == 1){
				echo "<p><div id='btnlike_".$dados->id."' style='display:inline'><a class='unlike' style='cursor:pointer;' onclick='un_like(".$dados->id.",".$_SESSION['id_user'].");'>Descurtir</a></div>";
			}else{
				echo "<p><div id='btnlike_".$dados->id."' style='display:inline'><a class='like' style='cursor:pointer;' onclick='add_like(".$dados->id.",".$_SESSION['id_user'].");'>Curtir</a></div>";
			}
			echo "&nbsp;<span id='post_".$dados->id."_like'>".$dados->likes."</span> gostaram disso</p>";
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
			echo "<div class='panel panel-default' id='postagem_".$dados->id."' style='margin-top:1%'>";
			echo "<div class='panel-body'>";
			echo "<div class='col-md-12'>";
			echo "<p><a href='perfil.php?id=".$id_user."'><img src='img/perfis/".$imagem."' class='img-perfil'/></a>&nbsp;<a href='perfil.php?id=".$id_user."'><strong>".$nome."</strong></a>";
			if($id_user == $_SESSION['id_user']){
				echo "<a class='delete' onclick='delete_post(".$dados->id.");'><i class='glyphicon glyphicon-remove'></i></a>";
			}
			echo "</p>";
			echo "<p style='font-size:10px;color:#ccc;'>".$dados->created_at."</p>";
			if($dados->tipo == "imagem"){
				echo "<p><center><img src='img/postagens/".$dados->imagem."'/ style='position:relative;width:100%;height:100%;border-radius:10px;'></center></p>";
			}elseif($dados->tipo == "texto"){
				echo "<p>".$dados->texto."</p>";
			}
			$valida = @BD::conn()->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
			$valida->execute(array($_SESSION['id_user'],$dados->id));
			if($valida->rowCount() == 1){
				echo "<p><div id='btnlike_".$dados->id."' style='display:inline'><a class='unlike' style='cursor:pointer;' onclick='un_like(".$dados->id.",".$_SESSION['id_user'].");'>Descurtir</a></div>";
			}else{
				echo "<p><div id='btnlike_".$dados->id."' style='display:inline'><a class='like' style='cursor:pointer;' onclick='add_like(".$dados->id.",".$_SESSION['id_user'].");'>Curtir</a></div>";
			}
			echo "&nbsp;<span id='post_".$dados->id."_like'>".$dados->likes."</span> gostaram disso</p>";
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
	
	function get_notifications(){
		$query = @BD::conn()->prepare("SELECT * FROM notifications WHERE user_to = ?");
		$query->execute(array($_SESSION['id_user']));
		
		if($query->rowCount() == 0){
			echo "<li class='request' style='display:block;padding:10px;color:#ccc;'>".utf8_encode("Não há notificações")."</li>";
		}else{
			while($dados = $query->fetchObject()){
				$user = @BD::conn()->prepare("SELECT * FROM users WHERE id = ?");
				$user->execute(array($dados->user_send));
				
				$fetch_user = $user->fetchObject();
				
				$id_user = $fetch_user->id;
				$firstname = $fetch_user->name;
				$lastname = $fetch_user->lastname;
				$image = $fetch_user->image;
				if($dados->type == "comment"){
					echo "<li class='request' style='display:block;padding:10px;color:#ccc;'>".utf8_encode("<p><img src='img/perfis/".$image."' class='img-perfil'/>&nbsp;<strong>".$firstname." ".$lastname."</strong> comentou uma postagem sua.</p>")."</li>";
				}elseif($dados->type == "liked"){
					echo "<li class='request' style='display:block;padding:10px;color:#ccc;'>".utf8_encode("<p><img src='img/perfis/".$image."' class='img-perfil'/>&nbsp;<strong>".$firstname." ".$lastname."</strong> curtiu uma postagem sua.</p>")."</li>";
				}
			}
		}
	}
	
	function verificar_clicado($id_post,$id_user){
		$id_post = (int)$id_post;
		$id_user = (int)$id_user;
		
		$verificar = @BD::conn()->prepare("SELECT like_id FROM likes WHERE user_id = ? AND post_id = ?");
		$verificar->execute(array($id_user,$id_post));
		
		return ($verificar->rowCount() >= 1) ? true : false;
	}
	
	function adicionar_like($id_post,$id_user){
		$id_post = (int)$id_post;
		$id_user = (int)$id_user;
		
		$atualizar_likes_post = @BD::conn()->prepare("UPDATE posts SET likes = likes+1 WHERE id = ?");
		$atualizar_likes_post->execute(array($id_post));
		
		if($atualizar_likes_post){
			$inserir_like = @BD::conn()->prepare("INSERT INTO likes(user_id,post_id) VALUES(?,?)");
			$inserir_like->execute(array($id_user,$id_post));
			if($inserir_like){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function retornar_likes($id_post){
		$id_post = (int)$id_post;
		
		$selecionar_num_likes = @BD::conn()->prepare("SELECT id,likes FROM posts WHERE id = ?");
		$selecionar_num_likes->execute(array($id_post));
		
		$_SESSION['likes_carregados'] = array();
		
		$fetch_likes = $selecionar_num_likes->fetchObject();
		
		$_SESSION['likes_carregados'] = $fetch_likes->id;
		
		return $fetch_likes->likes;
	}
	
	function un_like($id_post,$id_user){
		$delete = @BD::conn()->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
		if($delete->execute(array($id_user,$id_post))){
			$update = @BD::conn()->prepare("UPDATE posts SET likes = likes-1 WHERE id = ?");
			if($update->execute(array($id_post))){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function get_solicitacoes(){
		$request = @BD::conn()->prepare("SELECT * FROM friends WHERE user_one = ? AND friendship_official = '0'");
		$request->execute(array($_SESSION['id_user']));
		
		if($request->rowCount() > 0){
			while($fetch = $request->fetchObject()){
				$user_two = $fetch->user_two;
				$user = @BD::conn()->prepare("SELECT * FROM users WHERE id = ?");
				$user->execute(array($user_two));
				
				$fetch_user = $user->fetchObject();
				
				$id_user = $fetch_user->id;
				$firstname = $fetch_user->name;
				$lasttname = $fetch_user->lastname;
				$image = $fetch_user->image;
				
				echo "<li class='request' style='display:block;padding:10px;color:#ccc;'>".utf8_encode("<p><img src='img/perfis/".$image."' class='img-perfil'/>&nbsp;<strong>".$firstname." ".$lasttname."</strong> lhe enviou uma solicitação de amizade&nbsp;</p><p><button class='friendBtn accept btn btn-secondary' style='color:#000;'>Aceitar</button>&nbsp;<button class='friendBtn ignore btn btn-secondary' style='color:#000;'>Recusar</button></p>")."</li>";
			}
		}else{
			echo "<li class='request' style='display:block;padding:10px;color:#ccc;'>".utf8_encode("Não há solicitações")."</li>";
		}
	}
	
	function get_solicitacoes_mobile(){
		$request = @BD::conn()->prepare("SELECT * FROM friends WHERE user_one = ? AND friendship_official = '0'");
		$request->execute(array($_SESSION['id_user']));
		
		if($request->rowCount() > 0){
			while($fetch = $request->fetchObject()){
				$user_two = $fetch->user_two;
				$user = @BD::conn()->prepare("SELECT * FROM users WHERE id = ?");
				$user->execute(array($user_two));
				
				$fetch_user = $user->fetchObject();
				
				$id_user = $fetch_user->id;
				$firstname = $fetch_user->name;
				$lasttname = $fetch_user->lastname;
				$image = $fetch_user->image;
				
				echo "<div class='list-group'>";
				echo "<div class='list-group-item request'>";
				echo "<img src='img/perfis/".$image."' class='img-perfil'/>";
				echo "<p class='list-group-item-heading'><strong>".$firstname." ".$lasttname."</strong> ".utf8_encode("lhe enviou uma solicitação de amizade")."</p>";
				echo "<p class='list-group-item-text'><button class='friendBtn accept btn btn-secondary' style='color:#000;'>Aceitar</button>&nbsp;<button class='friendBtn ignore btn btn-secondary' style='color:#000;'>Recusar</button></p>";
				echo "</div>";
				echo "</div>";
			}
		}else{
			echo "<center>".utf8_encode("Não há solicitações")."</center>";
		}
	}
	
	function crop($img,$x,$y,$w,$h){
		$w_final = $h_final = 160;
		$jpeg_quality = 90;
		
		$src = $img;
		$img_r = imagecreatefromjpeg($src);
		$dst_r = imagecreatetruecolor($w_final,$h_final);
		
		imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$w_final,$h_final,$w,$h);
		
		$novo_nome = md5(uniqid(rand(), true)).".jpg";
		imagejpeg($dst_r,'uploads/'.$novo_nome, $jpeg_quality);
		if(file_exists('uploads/'.$novo_nome)){
			return $novo_nome;
		}else{
			return false;
		}
	}
	
	function check_temp($logado){
		if(!isset($_SESSION['temp_img'])){
			if(file_exists('uploads/temp_'.$logado->id.'.jpg')){
				unlink('uploads/temp_'.$logado->id.'.jpg');
			}
		}
	}
?>