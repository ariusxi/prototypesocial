<?php
	header('Access-Control-Allow-Origin: *');

	define('HOST','192.185.223.112');
	define('BD','brico861_escola');
	define('USER','brico861_escola');
	define('PASS','Admin00');

	class BD{
		private static $conn;
		public function __construct(){}
		
		public function conn(){
			if(is_null(self::$conn)){
				self::$conn = new PDO('mysql:host='.HOST.';dbname='.BD.'',''.USER.'',''.PASS.'');
			}
			return self::$conn;
		}
	}
	
	switch($_POST['tipo']){
		
		case "login":
	
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$dataquery = @BD::conn()->prepare("SELECT * FROM table_users WHERE username = ? AND password = ?");
			$dataquery->execute(array($username,$password));
			
			$arr = array();
			while($r = $dataquery->fetchObject()){
				array_push($arr, array("id_users" => $r->id_users, "fullname" => $r->full_name));
			}
			
			print_r(json_encode($arr));
		
		break;
		
		case "cadastrar":
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			$fullname = $_POST['fullname'];
			$telefone = $_POST['telefone'];
			
			$dataquery = @BD::conn()->prepare("INSERT INTO table_users (username,password,full_name,telefone) VALUES(?,?,?,?)");
			$dataquery->execute(array($username,$password,$fullname,$telefone));
			
			print_r(json_encode("sucesso"));
			
		break;
		
		case "cadastrar_eventos":
		
			$evento = $_POST['evento'];
			$data = $_POST['data'];
			$detalhes = $_POST['detalhes'];
			$user_check = $_POST['user_check'];
			$user_create = $_POST['user_create'];
			
			$dataquery = @BD::conn()->prepare("INSERT INTO table_eventos(evento,detalhes,data,user_check,user_create) VALUES(?,?,?,?,?)");
			$dataquery->execute(array($evento,$detalhes,$data,$user_check,$user_create));
			
			print_r(json_encode("sucesso"));
		
		break;
		
		case "listar_amigos":
		
			$session_id = $_POST['session_user'];
			
			$dataquery = @BD::conn()->prepare("SELECT * FROM table_users WHERE id_users != ?");
			$dataquery->execute(array($session_id));
			$arr = array();
			while($r = $dataquery->fetchObject()){
				$agora = date("Y-m-d H:i:s");
				$status = 'on';
				if($agora >= $r->limite){
					$status = 'off';
				}
				array_push($arr, array("id_users" => $r->id_users, "fullname" => $r->full_name, "status" => $status));
			}
			
			print_r(json_encode($arr));
		
		break;
		
		case "listar_historico":
		
			$user = $_POST['session_user'];
			
			$dataquery = @BD::conn()->prepare("SELECT * FROM `table_eventos` WHERE user_check = ? OR user_check != ? AND user_check = '' OR user_create = ? OR user_create != ? AND user_create = ''");
			$dataquery->execute(array($user,$user,$user,$user));
			$arr = array();
			while($r = $dataquery->fetchObject()){
				array_push($arr, array("id_evento" => $r->id_evento, "evento" => $r->evento, "data" => $r->data));
			}
			
			print_r(json_encode($arr));
			
		break;
		
		case "add_select":
			
			$session_user = $_POST['session_user'];
			
			$dataquery = @BD::conn()->prepare("SELECT * FROM table_users WHERE id_users != ?");
			$dataquery->execute(array($session_user));
			$arr = array();
			while($r = $dataquery->fetchObject()){
				array_push($arr, array("id" => $r->id_users, "user" => utf8_decode($r->full_name)));
			}
			
			print_r(json_encode($arr));
		
		break;
		
		case "view_evento":
		
			$id = $_POST['id'];
			
			$dataquery = @BD::conn()->prepare("SELECT * FROM table_eventos WHERE id_evento = ?");
			$dataquery->execute(array($id));
			$arr = array();
			while($r = $dataquery->fetchObject()){
				array_push($arr , array("titulo" => $r->evento, "detalhes" => $r->detalhes, "data" => $r->data));
			}
			
			print_r(json_encode($arr));
		
		break;
		
		case "insere_comentario":
		
			$user = $_POST['user'];
			$comentario = $_POST['comentario'];
			$evento = $_POST['evento'];
			
			$dataquery = @BD::conn()->prepare("INSERT INTO `table_comments`(id_evento,comentario,user) VALUES(?,?,?)");
			if($dataquery->execute(array($evento,$comentario,$user))){
				$select = @BD::conn()->prepare("SELECT full_name FROM `table_users` WHERE id_users = ?");
				$select->execute(array($user));
				$arr = array();
				while($r = $select->fetchObject()){
					array_push($arr, array("fullname" => utf8_decode($r->full_name), "comment" => $comentario));
				}
				
				print_r(json_encode($arr));
			}else{
				print_r(json_encode('no'));
			}
		
		break;
		
		case "retorna_comentarios":
		
			$id = $_POST['id'];
			
			$dataquery = @BD::conn()->prepare("SELECT * FROM `table_comments` WHERE id_evento = ?");
			$dataquery->execute(array($id));
			$arr = array();
			while($r = $dataquery->fetchObject()){
				$dataquery2 = @BD::conn()->prepare("SELECT full_name FROM table_users WHERE id_users = ?");
				$dataquery2->execute(array($r->user));
				while($d = $dataquery2->fetchObject()){
					array_push($arr, array("name" => utf8_decode($d->full_name), "comment" => $r->comentario));
				}
			}
			
			print_r(json_encode($arr));
		
		break;
	}
?>