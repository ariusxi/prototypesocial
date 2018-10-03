<?php
	session_start();
	require_once "config.php";
	include_once("classes/BD.class.php");
	@BD::conn();
	date_default_timezone_set("America/Sao_Paulo");
	
	if($_SESSION['id_user'] != ""){
		echo "<script>location.href='http://prototypesocial.esy.es/painel.php';</script>";
	}else{}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Prototype</title>
		<meta charset="utf-8"/>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/npm.js"></script>
		<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="icon" href="img/favicon.ico" type="image/x-icon" />
		<style>
			.img{
				margin-top:7%;
			}
			body{
				background-image:url('img/welcome.jpg');
			}
			.footer-text{
				color:#fff;
				bottom:0;
				left:0;
				position:fixed;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="col-md-12">
					<div class="col-md-3">
						<a href="http://prototypesocial.esy.es/"><img src="img/logo.png" class="img"/></a>
					</div>
					<div class="col-md-2">&nbsp;</div>
					<div class="col-md-7">
						<?php
							if(isset($_POST['acao']) && $_POST['acao'] == 'logar'):
								$email = strip_tags(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING));
								$password = strip_tags(filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING));
								
								$seleciona = @BD::conn()->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
								$seleciona->execute(array($email,$password));
								if($seleciona->rowCount() != 0){
									$fetch = $seleciona->fetchObject();
									$status = $fetch->status;
									if($status != 1){
										echo "<script>alert('Conta Indisponivel, por favor ative sua conta')</script>";
									}else{
										$agora = date('Y-m-d H:i:s');
										$limite = date('Y-m-d H:i:s', strtotime('+2 min'));
										
										$update = @BD::conn()->prepare("UPDATE users SET horario = ?, limite = ? WHERE id = ?");
										if($update->execute(array($agora,$limite,$fetch->id))){
											$_SESSION['id_user'] = $fetch->id;
											echo '<script>location.href="painel.php"</script>';
										}
									}
								}else{
									echo "<script>alert('Email ou Senha Incorretos')</script>";
								}
							endif;
						?>
						<form action="" method="post" enctype="multipart/form-data">
							<div class="col-md-4">
								<div class="input-group" style="margin-top:3.5%;">
									<span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" id="email" name="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group" style="margin-top:3.5%;">
									<span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-asterisk"></i></span>
									<input type="password" id="password" name="password" class="form-control" placeholder="Senha" aria-describedby="basic-addon1">
								</div>
							</div>
							<div class="col-md-4">
								<input type="hidden" name="acao" value="logar"/>
								<input type="submit" value="Login" class="btn btn-inverse"  style="margin-top:3.5%;width:100%;"/>
							</div>
							<br><br>
						</form>
					</div>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">Informações</div>
							<div class="panel-body">
								<img src="img/imgcad.jpg" width="100%" height="100%">
								<p>
									No prototype você pode conectar-se com seus amigos,<br>
									postar fotos e videos, compartilhar o que quiser.
								</p>
								<br>
								<br>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">Cadastre-se</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<?php
											if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'):
												
												$curl = curl_init();
												
												curl_setopt_array($curl,[
													CURLOPT_RETURNTRANSFER => 1,
													CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
													CURLOPT_POST => 1,
													CURLOPT_POSTFIELDS => [
														'secret' => '6LeX9w0TAAAAAPOfDn14TFoi4QXUyf8dTBjAmrQc',
														'response' => $_POST['g-recaptcha-response'],
													],
												]);
												
												$response = json_decode(curl_exec($curl));
												
												if(!$response->success){
													echo "<script>alert('Por favor, faça o captcha')</script>";
												}else{
													$name = strip_tags(filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING));
													$lastname = strip_tags(filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_STRING));
													$email1 = strip_tags(filter_input(INPUT_POST,'email1',FILTER_SANITIZE_STRING));
													$email2 = strip_tags(filter_input(INPUT_POST,'email2',FILTER_SANITIZE_STRING));
													if($email1 != $email2){
														echo "<script>alert('Os emails que você digitou não estão batendo');location.href='index.php'</script>";
													}else{
														$link = str_replace(" ","_",$name);
														$link = $link.".".substr($_POST['data'],0,1);
														
														$email = strip_tags(filter_input(INPUT_POST,'email1',FILTER_SANITIZE_STRING));
														
														$arquivo = $_FILES['image']['name'];
														$type = explode('.',$arquivo);
														$type = end($type);
														
														if($_FILES['image']['name'] != ""){
															if(($type == "jpg") || ($type == "png") || ($type == "jpeg")){
																$destino = "img/perfis/".$_FILES['image']['name'];
																move_uploaded_file($_FILES['image']['tmp_name'],$destino);
																$password = $_POST['password'];
																$data = $_POST['data'];
																$inserir = @BD::conn()->prepare("INSERT INTO users(name,lastname,image,capa,email,password,data_nascimento,link,status) VALUES(?,?,?,?,?,?,?,?,0)");
																if($inserir->execute(array($name,$lastname,$arquivo,"capa_padrao.jpg",$email,$password,$data,$link))){
																	echo "<script>alert('Cadastro Efetuado com Sucesso, por favor confirme seu email')</script>";
																	
																	$assunto = "Prototype - Ative sua Conta";
																	$mensagem = "Ative sua conta clicando no link: http://prototypesocial.esy.es/confirm.php?u=".$link."";
																	$header = "prototypesocial@noreply.com";
																	
																	mail($email,$assunto,$mensagem,$header);
																}
															}else{
																echo "<script>alert('Formato de Imagem Inválido');</script>";
															}
														}else{
															$password = $_POST['password'];
															$data = $_POST['data'];
															$inserir = @BD::conn()->prepare("INSERT INTO users(name,lastname,image,capa,email,password,data_nascimento,link,status) VALUES(?,?,?,?,?,?,?,?,0)");
															if($inserir->execute(array($name,$lastname,"default.jpg","capa_padrao.jpg",$email,$password,$data,$link))){
																echo "<script>alert('Cadastro Efetuado com Sucesso, por favor confirme seu email')</script>";
																
																$assunto = "Prototype - Ative sua Conta";
																$mensagem = "Ative sua conta clicando no link: http://prototypesocial.esy.es/confirm.php?u=".$link."";
																$header = "prototypesocial@noreply.com";
																
																mail($email,$assunto,$mensagem,$header);
															}
														}
													}
												}
											endif;
										?>
										<form action="" method="post" enctype="multipart/form-data">
											<div class="col-md-12">
												<label>Imagem</label>
												<input type="file" id="image" name="image" />
												<br>
											</div>
											<div class="col-md-12">
												<input type="text" id="name" name="name" class="form-control" placeholder="Nome"/>
											</div>
											<div class="col-md-12">
												<br>
												<input type="text" id="lastname" name="lastname" class="form-control" placeholder="Sobrenome"/>
											</div>
											<div class="col-md-12">
												<br>
												<input type="text" id="email1" name="email1" class="form-control" placeholder="Email"/>
											</div>
											<div class="col-md-12">
												<br>
												<input type="text" id="email2" name="email2" class="form-control" placeholder="Insira Novamente seu Email"/>
											</div>
											<div class="col-md-12">
												<br>
												<input type="password" id="password" name="password" class="form-control" placeholder="Insira sua senha"/>
											</div>
											<div class="col-md-12">
												<br>
												<label>Data de Nascimento</label>
												<input type="date" id="data" name="data" class="form-control" placeholder="Data de Nascimento"/>
											</div>
											<div class="col-md-12">
												<br>
												<div class="g-recaptcha" data-sitekey="6LeX9w0TAAAAALmpMbRefT8C6bu9zAukbpSS3jQJ"></div>
											</div>
											<div class="col-md-12">
												<br>
												<input type="hidden" name="acao" value="cadastrar"/>
												<input type="submit" class="btn btn-default" value="Cadastrar"/>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="footer-text">
				© 2015 Todos os Direitos Reservados
			</div>
		</div>
	</body>
</html>