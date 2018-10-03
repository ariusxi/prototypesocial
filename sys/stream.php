<?php
	if(isset($_GET)){
		require_once "../config.php";
		include_once("../classes/BD.class.php");
		@BD::conn();
		
		$userOnline = (int)$_GET['user'];
		$timestamp = ($_GET['timestamp'] == 0) ? time() : strip_tags(trim($_GET['timestamp']));
		$lastid = (isset($_GET['last']) && !empty($_GET['lastid'])) ? $_GET['lastid'] : 0;
		
		if(empty($timestamp)){
			die(json_encode(array('status' => 'erro')));
		}
		
		$tempoGasto = 0;
		$lastidQuery = '';
		
		if(!empty($lastid)){
			$lastidQuery = ' AND id > '.$lastid;
		}
		
		if($_GET['timestamp'] == 0){
			$verifica = @BD::conn()->prepare("SELECT * FROM mensagens WHERE lido = 0 ORDER BY id DESC");
		}else{
			$verifica = @BD::conn()->prepare("SELECT * FROM mensagens WHERE time>= $timestamp".$lastidQuery." AND lido = 0 ORDER BY id DESC");
		}
		$verifica->execute();
		$resultados = $verifica->rowCount();
		if($resultados <= 0){
			while($resultados <= 0){
				if($resultados <= 0){
					if($tempoGasto >= 30){
						die(json_encode(array('status' => 'vazio', 'lastid' => 0, 'timestamp' => time())));
						exit;
					}
					
					sleep(1);
					$verifica = @BD::conn()->prepare("SELECT * FROM mensagens WHERE time>= $timestamp".$lastidQuery." AND lido = 0 ORDER BY id DESC");
					$verifica->execute();
					$resultados = $verifica->rowCount();
					$tempoGasto += 1;
				}
			}
		}
		
		$novasMensagens = array();
		if($resultados >= 1){
			$emotions = array(':)', ':@', '8)', ':D', ':3', ':(', ';)');
			$imgs = array(
				'<img src="emotions/nice.png" width="14"/>',
				'<img src="emotions/angry.png" width="14"/>',
				'<img src="emotions/cool.png" width="14"/>',
				'<img src="emotions/happy.png" width="14"/>',
				'<img src="emotions/ooh.png" width="14"/>',
				'<img src="emotions/sad.png" width="14"/>',
				'<img src="emotions/right.png" width="14"/>'
			);
			
			while($row = $verifica->fetch()){
				$fotoUser = '';
				$janela_de = 0;
				
				if($userOnline == $row->id_de){
					$janela_de = $row->id_para;
				}elseif($userOnline == $row->id_para){
					$janela_de = $row->id_de;
					$pegaUsr = @BD::conn()->prepare("SELECT image FROM users WHERE id = ?");
					$pegaUsr->execute(array($row->id_de));
					while($usr = $pegaUsr->fetchObject()){
						$fotoUser = ($usr->image == '') ? 'default.jpg' : $usr->image;
					}
				}
				$msg = str_replace($emotions, $imgs, $row['mensagem']);
				$novasMensagens[] = array(
					'id' => $row->id,
					'mensagem' => utf8_encode($msg),
					'fotoUser' => $fotoUser,
					'id_de' => $row->id_de,
					'id_para' => $row->id_para,
					'janela_de' => $janela_de
				);
			}
		}
		$ultimaMsg = end($novasMensagens);
		$ultimoId = $ultimaMsg['id'];
		die(json_encode(array('status' => 'resultados', 'timestamp' => time(), 'lastid' => $ultimoId, 'dados' => $novasMensagens)));
	}
?>