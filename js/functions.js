jQuery(function(){
	var userOnline = Number(jQuery('span.user').attr('id'));
	var clicou = [];
	
	function in_array(indice, array){
		for(var i =0; i<array.length;i++){
			if(array[i] == valor){
				return true;
			}
		}
		
		return false;
	}
	
	function add_janela(id, nome, status){
		var janelas = Number(jQuery('#chats .window').length);
		var pixels = (270+5)*janelas;
		var style = 'float:right; position:absolute; bottom:0; left:'+pixels+'px';
		
		var splitDados = id.split(":");
		var id_user = Number(splitDados[1]);
		
		var janela = '<div class="window" id="janela_'+id_user+'" style="'+style+'">';
		janela += '<div class="header_window"><a href="#" class="close">X</a> <span class="name">'+nome+'</a><span id="'+id_user+'" class="'+status+'"></span></div>';
		janela += '<div class="body"><div class="mensagens"><ul></ul></div>';
		janela += '<div class="send_message" id="'+id+'"><input type="text" name="mensagem" class="msg" id="'+id+'"/></div></div></div>';
		
		jQuery('#chats').append(janela);
	}
	
	function retorna_historico(id_conversa){
		jQuery.ajax({
			type: 'POST',
			url: 'sys/historico.php',
			data: { conversacom: id_conversa, online: userOnline },
			dataType: 'json',
			success: function(retorno){
				jQuery.each(retorno, function(i, msg){
					if(jQuery('#janela_'+msg.janela_de).length > 0){
						if(userOnline == msg.id_de){
							jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'" class="eu"><p>'+msg.mensagem+'</p></li>');
						}else{
							jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'"><div class="imgSmall"><img src="img/perfis/'+msg.fotoUser+'"/></div><p>'+msg.mensagem+'</p></li>');
						}
					}
				});
				[].reverse.call(jQuery('#janela_'+id_conversa+' .mensagens li')).appendTo(jQuery('#janela_'+id_conversa+' .mensagens ul'));
				var altura = jQuery('#janela_'+id_conversa+' .mensagens').height();
				jQuery('#janela_'+id_conversa+' .mensagens').animate({scrollTop: altura}, '500');
			},error: function(e){
				console.log(e);
			}
		});
	}
	
	jQuery('body').on('click','#users_online a',function(){
		var id = jQuery(this).attr('id');
		jQuery(this).removeClass('comecar');
		
		var status = jQuery(this).next().attr('class');
		var splitIds = id.split(':');
		var idJanela = Number(splitIds[1]);
		
		if(jQuery('#janela_'+idJanela).length == 0){
			var nome = jQuery(this).text();
			add_janela(id, nome, status);
			retorna_historico(idJanela);
		}else{
			jQuery(this).removeClass('comecar');
		}
	});
	
	jQuery('body').on('click','.header_window', function(){
		var next = jQuery(this).next();
		next.toggle(100);
	});
	
	jQuery('body').on('click', '.close', function(){
		var parent  = jQuery(this).parent().parent();
		var idParent = parent.attr('id');
		var splitParent = idParent.split('_');
		var idJanelaFechada = Number(splitParent[1]);
		
		var contagem = Number(jQuery('.window').length)-1;
		var indice = Number(jQuery('.close').index(this));
		var restamAfrente = contagem-indice;
		
		for(var i = 1; i <= restamAfrente; i++){
			jQuery('.window:eq('+(indice+i)+')').animate({left:"-=275"}, 200);
		}
		parent.remove();
		jQuery('#users_online li#'+idJanelaFechada+' a').addClass('comecar');
	});
	
	jQuery('body').on('keyup', '.msg', function(e){
		if(e.which == 13){
			var texto = jQuery(this).val();
			var id = jQuery(this).attr('id');
			var split = id.split(':');
			var para = Number(split[1]);
			jQuery.ajax({
				type: 'POST',
				url: 'sys/submit.php',
				data: { mensagem: texto, de: userOnline, para: para },
				success: function(retorno){
					if(retorno == 'ok'){
						jQuery('.msg').val('');
					}else{
						alert("Ocorreu um erro ao enviar a mensagem");
					}
				}
			});
		}
	});
	
	function verifica(timestamp, lastid, user){
		var t;
		jQuery.ajax({
			url: 'sys/stream.php',
			type: 'GET',
			data: 'timestamp='+timestamp+'&lastid='+lastid+'&user='+user,
			dataType: 'json',
			success: function(retorno){
				clearInterval(t);
				if(retorno.status == 'resultados' || retorno.status == 'vazio'){
					t = setTimeout(function(){
						verifica(retorno.timestamp, retorno.lastid, userOnline);
					},1000);
					
					if(retorno.status == 'resultados'){
						jQuery.each(retorno.dados, function(i, msg){
							if(jQuery('#janela_'+msg.janela_de).length == 0){
								jQuery('#users_online #'+msg.janela_de+' .comecar').click();
								clicou.push(msg.janela_de);
							}
							
							if(!in_array(msg.janela_de, clicou)){
								if(jQuery('.mensagens ul li#'+msg.id).length == 0 && msg.janela_de > 0){
									if(userOnline == msg.id_de){
										jQuery("#janela_"+msg.janela_de+' .mensagens ul').append('<li class="eu" id="+msg.id+"><p>'+msg.mensagem+'</p></li>');
									}else{
										jQuery("#janela_"+msg.janela_de+' .mensagens ul').append('<li id="+msg.id+"><div class="imgSmall"><img src="img/perfis/'+msg.fotoUser+'" border="0"/></div><p>'+msg.mensagem+'</p></li>');
									}
								}
							}
						});
						var altura = jQuery('.mensagens').height();
						jQuery('.mensagens').animate({scrollTop: altura}, '500');
					}
				}else if(retorno.status == 'erro'){
					alert("Ficamos confusos, atualize a página");
				}
			},error: function(retorno){
				clearInterval(t);
				t=setTimeout(function(){
					verifica(retorno.timestamp, retorno.lastid, userOnline);
				},15000);
			}
		});
	}
	
	verifica(0,0,userOnline);
});