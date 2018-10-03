<?php
	header('Access-Control-Allow-Origin: *');
	session_start();
	require_once "config.php";
	include_once('classes/BD.class.php');
	@BD::conn();
	include_once("php/selectdados.php");
	include_once('functions/funcoes.php');
	if(isset($_SESSION['id_user']) && $_SESSION['id_user'] != ""){}else{
		echo "<script>location.href='http://prototypesocial.esy.es/';</script>";
	}
	$pega_logado = @BD::conn()->prepare("SELECT * FROM users WHERE id = ?");
	$pega_logado->execute(array($_SESSION['id_user']));
	$logado = $pega_logado->fetchObject();
	check_temp($logado);
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
		<link href="css/jcrop.css" rel="stylesheet">
		<script type="text/javascript" src="js/jcrop.js"></script>
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
								<li class="active"><a href="#texto" data-toggle="tab">Meus Dados</a></li>
								<li><a href="#foto" data-toggle="tab">Mudar Foto</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="texto">
									<form action="" method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<span>Nome</span>
												<input type="text" class='form-control' id="nome" name="nome" value=""/>
											</div>
											<div class="col-md-12">
												<span>Sobrenome</span>
												<input type="text" class='form-control' id="sobrenome" name="sobrenome" value=""/>
											</div>
											<div class="col-md-12">
												<span>Email</span>
												<input type="text" class='form-control' id="email" name="email" value=""/>
											</div>
											<div class="col-md-12">
												<span>Senha</span>
												<input type="text" class='form-control' id="senha" name="senha" value=""/>
											</div>
											<div class="col-md-12">
												<span>Data de Nascimento</span>
												<input type="date" class='form-control' id="datanasc" name="datanasc" value=""/>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane" id="foto">
									<?php
										if($_SERVER['REQUEST_METHOD'] == 'POST'){
											if(isset($_POST['w'])){
												$x = (int)$_POST['x'];
												$y = (int)$_POST['y'];
												$w = (int)$_POST['w'];
												$h = (int)$_POST['h'];
												$img = $_POST['img'];
												
												$crop = crop($img,$x,$y,$w,$h);
												if($crop){
													if($logado->foto != ''){
														unlink('img/perfis/'.$logado->foto);
														$upl_foto = @BD::conn()->prepare("UPDATE users SET image = ? WHERE id = ?");
														if($upl_foto->execute(array($crop,$logado->id))){
															echo "<div class='alert alert-success'>Imagem cortada com sucesso</div>";
														}
													}else{
														$upd_foto = @BD::conn()->prepare("UPDATE users SET image = ? WHERE id = ?");
														if($upd_foto->execute(array($crop,$logado->id))){
															echo "<div class='alert alert-success'>Imagem cortada com sucesso</div>";
														}
													}
													unlink('img/perfis/'.$_SESSION['temp_img']);
													unset($_SESSION['temp_img']);
												}else{
													echo '<div class="alert alert-warning">Não foi possível fazer o crop</div>';
													unlink('img/perfis/'.$_SESSION['temp_img']);
													unset($_SESSION['temp_img']);
												}
											}elseif(isset($_POST['upl_foto'])){
												include_once "lib/WideImage.php";
												$tamanhos = getimagesize($_FILES['foto']['tmp_name']);
												if($tamanhos[0] < 500){
													echo '<div class="alert alert-warning">A imagem precisa ter no mínimo 500px de largura</div>';
												}else{
													$wide = WideImage::load($_FILES['foto']['tmp_name']);
													$resized = $wide->resize(500);
													$resize = $resized->saveToFile("img/perfis/temp_".$logado->id.".jpg");
													if(is_object($resized)){
														$_SESSION['temp_img'] = 'temp_'.$logado->id.'.jpg';
													}
												}
											}
										}
									?>
									
									<?php if(isset($_SESSION['temp_img'])): ?>
									<div class='img_crop'>
										<img src="<?php echo BASE; ?>img/perfis/<?php echo $_SESSION['temp_img']; ?>" id="target"/>
									</div>
									
									<form action="" method="post" enctype="multipart/form-data">
										<input type="hidden" id="x" name="x" value='0' class="coord"/>
										<input type="hidden" id="y" name="y" value='0' class="coord"/>
										<input type="hidden" id="w" name="w" value='160' class="coord"/>
										<input type="hidden" id="h" name="h" value='160' class="coord"/>
										<input type="hidden" name="img" value="<?php echo BASE.'img/perfis/'.$_SESSION['temp_img']; ?>"/>
										<center><input type="submit" name="crop" value="Cortar Imagem" class="btn btn-inverse"/></center>
									</form>
									<?php else: ?>
										<form action="" method="post" enctype="multipart/form-data">
											<p>
												<br><input type="file" name="foto" /><br>
												<input type="submit" class="btn btn-inverse" name="upl_foto" value="Enviar Imagem" />
											</p>
										</form>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
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
			</div>
		</div>
	</body>
</html>