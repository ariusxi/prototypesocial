<?php
    header('Access-Control-Allow-Origin: *');  
	$email = 'brazhuman@brazhuman.com';
	$assunto = 'Contato Brazhuman';
	$mensagem  = nl2br("
		==============================
		Contato brazhuman
		==============================
		De: ".$_POST['email']."
		Assunto: Contato Brazhuman
		Mensagem: ".$_POST['message']."
	");
	$header = '';

	if(mail($email,$assunto,$mensagem,'De: '.$_POST['email']) && mail('brazhuman@email.com',$assunto,$mensagem,'De: '.$_POST['email'])){
        print_r(json_encode('ok'));
    }else{
        print_r(json_encode('no'));
    }
?>			