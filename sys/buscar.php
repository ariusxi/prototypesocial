<?php
	session_start();
	require_once "../config.php";
	include_once("../classes/BD.class.php");
	@BD::conn();
	
	$get = strip_tags($_GET['q']);
	
	$string = @BD::conn()->prepare("SELECT * FROM users WHERE name LIKE '%$get%' OR lastname LIKE '%$get%'");
	$string->execute();
	
	if($string->rowCount() == 0){
		echo '<a href="#" class="fechar" onclick="remove_res();" color="#000"><i class="glyphicon glyphicon-remove"></i></a>';
		echo "<p>Não foram encontrados resultados</p>";
	}else{
		$num = $string->rowCount();
		echo '<a href="#" class="fechar" onclick="remove_res();" color="#000"><i class="glyphicon glyphicon-remove"></i></a>';
		while($dados = $string->fetchObject()){
?>
		<a href="perfil.php?id=<?php echo $dados->id; ?>"><div>
			<img src="img/perfis/<?php echo $dados->image; ?>" class="img-perfil"/>
			<span><?php echo $dados->name." ".$dados->lastname; ?></span>
		</div></a>
<?php
		}
	}
?>