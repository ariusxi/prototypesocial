<?php
	class Friends{
		static public function renderFriendShip($user_one, $user_two, $type){
			if(!empty($user_one) && !empty($user_two)){
				global $db;
				
				switch($type){
					case'isThereRequestPending':
						$query = @BD::conn()->prepare("SELECT * FROM friends WHERE user_one = ? AND user_two = ? AND friendship_official = '0' OR user_one = ? AND user_two = ? AND friendship_official = '0'");
						$query->execute(array($user_one,$user_two,$user_two,$user_one));
						
						return $query->rowCount();
					break;
					
					case 'isThereFriendShip':
						$query = @BD::conn()->prepare("SELECT * FROM friends WHERE user_one = ? AND user_two = ? AND friendship_official = '1' OR user_one = ? AND user_two = ? AND friendship_official = '1'");
						$query->execute(array($user_one,$user_two,$user_two,$user_one));
						
						return $query->rowCount();
					break;
				}
			}
		}
		
		static public function add($uid,$user_two){
			if(!empty($uid) && !empty($user_two)){
				global $db;
				$response = array();
				
				$uid = (int) $uid;
				$user_two = (int) $user_two;
				
				if($uid != $user_two){
					$f = new Friends;
					$check = $f->renderFriendShip($uid,$user_two,'isThereFriendShip');
					
					if($check == 0){
						$insert = @BD::conn()->prepare("INSERT INTO friends VALUES('',?,?,'0',NOW())");
						$insert->execute(array($uid,$user_two));
						
						$response['code'] = 0;
						$response['msg'] = "Solicitação Enviada";
						echo json_encode($response);
						return false;
					}else{
						$response['code'] = 0;
						$response['msg'] = "Usuários já são amigos";
						echo json_encode($response);
						return false;
					}
				}else{
					$response['code'] = 0;
					$response['msg'] = "Você não pode ser amigo de você mesmo";
					echo json_encode($response);
					return false;
				}
			}
		}
	}
?>