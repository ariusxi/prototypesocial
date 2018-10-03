<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$insert = @BD::conn()->prepare("INSERT INTO logs(username,ip,date_log) VALUES(?,?,NOW())");
	if($insert->execute(array($username,$ip))){
		echo "Sucesso";
	}
?>