<?php
    header('Access-Control-Allow-Origin: *');  
	$email = 'brazhuman@brazhuman.com';
	$assunto = 'Contato Brazhuman';
	$mensagem = $_POST['message'];
	$header = '';

	if(mail($email,$assunto,$mensagem,'De: '.$_POST['email']) && mail('brazhuman@email.com',$assunto,$mensagem,'De: '.$_POST['email'])){
        print_r(json_encode($_POST['email']));
    }else{
        print_r(json_encode('no'));
    }
?>			