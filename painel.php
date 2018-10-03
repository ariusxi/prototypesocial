<?php
	header('Access-Control-Allow-Origin: *');
	session_start();
	require_once "config.php";
	include_once("classes/BD.class.php");
	@BD::conn();
	header('Access-Control-Allow-Origin: *');
	include_once("php/selectdados.php");
	include_once("functions/funcoes.php");
	if($_SESSION['id_user'] != ""){}else{
		echo "<script>location.href='http://prototypesocial.esy.es/';</script>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Prototype</title>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="stylesheet" href="css/fonts.css">
		<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
		<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<link href="css/chat.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" href="img/favicon.ico" type="image/x-icon" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/busca.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<style>
			.hidden{
				display:none;
			}
		</style>
	</head>
	<body>
		<div id="nav">
			<img src="img/menu.png" class="icon" onclick="mostra_contatos()"/>
			<div id="nav_wrapper">
				<img src="img/logo.png" class="logo"/>
				<div class='icons'>
					<ul>
						<li><a href="#"><i class="material-icons">perm_identity</i></a>
							<ul>
								<?php get_solicitacoes(); ?>
							</ul>
						</li><li>
						<a href="#"><i class="material-icons">chat_bubble</i></a></li><li>
						<a href="#"><i class="material-icons">settings_applications</i></a>
							<ul>
								<li><a href="minha-conta.php">Configurações</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="contatos">
			<span class='user' id='<?php echo $_SESSION['id_user']; ?>'></span>
			<div class='space_contatos'></div>
			<aside id="users_online">
				<ul>
					<?php
						$pegaUsuarios = @BD::conn()->prepare("SELECT * FROM users WHERE id != ?");
						$pegaUsuarios->execute(array($_SESSION['id_user']));
						while($row = $pegaUsuarios->fetchObject()){
							$foto = ($row->image == '') ? 'default.jpg' : $row->image;
							$blocks = explode(',',$row->blocks);
							$agora = date('Y-m-d H:i:s');
							if(!in_array($_SESSION['id_user'],$blocks)){
								$status = 'on';
								if($agora >= $row->limite){
									$status = 'off';
								}
					?>
						<li id="<?php echo $row->id; ?>" data-toggle="popover" data-content="<center><div class='imgSmall'><img src='img/perfis/<?php echo $row->image; ?>'/></div><h5 style='float:left;'><?php echo $row->name." ".$row->lastname; ?></center>">
							<div class="imgSmall"><img src="img/perfis/<?php echo $row->image; ?>"/></div>
							<h5><a href="#" id="<?php echo $_SESSION['id_user'].':'.$row->id; ?>" class="comecar"><?php echo $row->name." ".$row->lastname; ?></a></h5>
							<span id="<?php echo $row->id; ?>" class="status <?php echo $status; ?>"></span>
						</li>
					<?php
						}}
					?>
				</ul>
			</aside>
		</div>
		<aside id="chats">
			
		</aside>
		<div class="container main">
			<div class="row">
				<div class="col-md-9">
					<div class='space'>
						<br><br><br>
					</div>
					<div class="panel panel-default" style="margin-top:1%;">
						<div class="panel-body">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#texto" data-toggle="tab">Texto</a></li>
								<li><a href="#foto" data-toggle="tab">Foto</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="texto">
									<form action="" method="post" enctype="multipart/form-data">
										<br>
										<div class="form-group">
											<textarea class="form-control" rows="5" id="text" name="text"></textarea>
										</div>
										<input type="hidden" name="acao" value="posta_texto">
										<input type="submit" name="post_text" value="Postar" class="btn btn-inverse"/>
									</form>
								</div>
								<div class="tab-pane" id="foto">
									<form action="" method="post" enctype="multipart/form-data">
										<input type="file" id="imagem" name="imagem" style="display:none;"/>
										<br>
										<div class="col-sm-2 col-md-2">
											<a href="#" class="thumbnail"><img src="img/icon_imagem.png" alt="" id="uploadpreview" onclick="abrefile()" style="background-position:center;"></a>
										</div>
										<div class="col-md-12">
											<input type="hidden" name="acao" value="posta_imagem">
											<input type="submit" name="post_image" value="Postar" class="btn btn-inverse"/>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<?php
						if(isset($_POST['acao']) && $_POST['acao'] == 'posta_texto'):
							$texto = strip_tags(filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING));
							$inserir = @BD::conn()->prepare("INSERT INTO posts(id_user,texto,tipo,created_at) VALUES(?,?,?,NOW())");
							$inserir->execute(array($_SESSION['id_user'],$texto,"texto"));
							echo "<script>location.href='painel.php'</script>";
						elseif(isset($_POST['acao']) && $_POST['acao'] == 'posta_imagem'):
							$arquivo = $_FILES['imagem']['name'];
							$type = explode('.',$arquivo);
							$type = end($type);
							
							if(($type == "jpg") || ($type == "png") || ($type == "jpeg")){
								$destino = "img/postagens/".$_FILES['imagem']['name'];
								move_uploaded_file($_FILES['imagem']['tmp_name'],$destino);
								$inserir = @BD::conn()->prepare("INSERT INTO posts(id_user,imagem,tipo,created_at) VALUES(?,?,?,NOW())");
								$inserir->execute(array($_SESSION['id_user'],$arquivo,"imagem"));
								echo "<script>location.href='painel.php'</script>";
							}else{
								echo "<script>alert('Formato de Imagem Inválido');</script>";
							}
						endif;
					?>
				</div>
				<div class="col-md-3">
					<div class='space2'>
						<br><br><br>
					</div>
					<div class="panel panel-default" style="margin-top:3%;">
						<p class="name"><img src="img/perfis/<?php echo $imagem; ?>" class="img-perfil"/>&nbsp;<?php echo $name." ".$lastname; ?></p>
						<form action="" method="get" enctype="multipart/form-data" id="formulario">
							<p class="list-group-item"><input type="text" name="q" id="q" class="form-control" placeholder="Procurar por uma pessoa" onkeyup="busca();" onkeydown="mostra_res();"/></p>
						</form>
						<div id="resultado">
							<div style="clear:both;"></div>
						</div>
						<a href="painel.php" class="list-group-item"><i class="glyphicon glyphicon-home"></i>&nbsp;Página Inicial<span class="badge">42</span></a>
						<a href="perfil.php?id=<?php echo $_SESSION['id_user']; ?>" class="list-group-item"><i class="glyphicon glyphicon-user"></i>&nbsp;Perfil</a>
						<a href="#" class="list-group-item"><i class="glyphicon glyphicon-comment"></i>&nbsp;Mensagens</a>
						<!--<a href="#" class="list-group-item"><i class="glyphicon glyphicon-book"></i>&nbsp;Amigos</a>-->
					</div>
				</div>
				<div class="col-md-9">
					<div class="posts">
						<?php get_artigos(); ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	function abrefile(){
		$("#imagem").click();
	}
	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e){
				$("#uploadpreview").attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imagem").change(function(){
		readURL(this);
	});
</script>