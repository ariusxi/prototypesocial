$('#q').attr('autocomplete','off');

var c = 0;

function mostra_res(){
	var texto  = document.getElementById("q");
	var res = document.getElementById("resultado");
	
	if(texto != ""){
		res.style.display="block";
	}
}
function remove_res(){
	var res = document.getElementById("resultado");
	var texto = document.getElementById("q");
	
	res.style.display="none";
	texto.value = "";
}
function add_like(id_post,id_user){
	var likes = $("#post_"+id_post+"_like").text();
	$("#post_"+id_post+"_like").html('<img src="img/load.gif"/>');
	$.post('sys/add_like.php',{post_id: id_post,},function(data){
		if(data == 'sucesso'){
			get_like(id_post);
			$("#btnlike_"+id_post+"").html('<a class="unlike" style="cursor:pointer;" onclick="un_like('+id_post+','+id_user+');">Descurtir</a>');
		}else{
			alert('Você já curtiu esse post');
			$("#post_"+id_post+"_like").text(likes);
		}
	});
}

function get_like(id_post){
	$.post('sys/get_like.php',{ post_id: id_post},function(valor){
		$("#post_"+id_post+"_like").text(valor);
	});
}

function un_like(id_post,id_user){
	var likes = $("#post_"+id_post+"_like").text();
	$("#post_"+id_post+"_like").html('<img src="img/load.gif"/>');
	$.post("sys/un_like.php",{ post_id:id_post, user_id: id_user }, function(data){
		if(data == "sucesso"){
			$("#btnlike_"+id_post+"").html('<a class="like" style="cursor:pointer;" onclick="add_like('+id_post+','+id_user+');">Curtir</a>');
			get_like(id_post);
		}else{
			alert('Houve algum erro');
		}
	})
}

function mostra_contatos(){
	var contatos = document.getElementById('contatos');
	if(c == 0){
		c = 1;
		$("#contatos").fadeIn();
	}else{
		c = 0;
		$("#contatos").fadeOut();
	}
}

function openAjax(){
	var ajax;
	
	try{
		ajax = new XMLHttpRequest();
	}catch(erro){
		try{
			ajax = new ActiveXObject("Msxl2.XMLHTTP");
		}catch(ee){
			try{
				ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
				ajax = false;
			}
		}
	}
	return ajax;
}

$(".delete").on('click',function(){
	var id = $(this).attr('id');
	
	alert(id);
})

function busca(){
	if(document.getElementById){
		var termo = document.getElementById('q').value;
		var exibeResultado = document.getElementById('resultado');
		
		if(termo !== "" && termo !== null && termo.length >= 3){
			var ajax = openAjax();
			
			ajax.open("GET","sys/buscar.php?q="+termo,true);
			ajax.onreadystatechange = function(){
				if(ajax.readyState == 1){
					exibeResultado.innerHTML = '<p>Carregando Resultados...</p>';
				}
				if(ajax.readyState == 4){
					if(ajax.status == 200){
						var resultado = ajax.responseText;
						resultado = resultado.replace(/\+g/," ");
						resultado = unescape(resultado);
						exibeResultado.innerHTML = resultado;
					}else{
						exibeResultado.innerHTML = '<p>Houve algum erro na requisição</p>';
					}
				}
			}
			ajax.send(null);
		}
	}
}

function delete_post(id){
	$("#postagem_"+id+"").fadeOut();
	$.post("sys/delete.php",{
		id: id
	})
}

$(function(){
	$('body').delegate('.comentario','keydown',function(e){
		var campo = $(this);
		var comment = campo.val();
		var post = campo.attr('id');
		var exibeResultado = document.getElementById("comentarios");
		
		if(e.keyCode == 13){
			if(comment !== '' && comment !== null){
				$.post("sys/insertcomment.php",
					{
						comment: comment,
						post: post
					},function(data){
						$('#post_'+post+'').append(data);
						$("#"+post+"").val("");
					}
				);
			}
		}
	})
	$("#users_online ul li").hover(function(){
		var id = $(this).attr('id');
		$('[data-toggle="popover"]').popover({
			html: true,
			trigger: 'hover',
			placement: 'right'
		});
	});
});

$(document).on('click','.friendBtn',function(){
	var $this = $(this);
	var type = $this.data(type);
	
	switch(type){
		case 'addfriend':
			alert('clicado')
		break;
	}
});

$(function(){
	var $menu = $(".main-content .menu");
	var $tabContent = $('.main-content .content');
	$menu.find("li").bind('click',function(){
		$menu.find('li').removeClass('active');
		$(this).addClass('active');
		
		var tabId = $(this).attr('id');
		
		$tabContent.fadeOut('fast');
		setTimeout(function(){
			$('.content.'+tabId).fadeIn('normal');
		},300);
	});
});

$('#target').Jcrop({
	aspectRadio: 1,
	minSize: [160,160],
	setSelect: [0,0,160,160],
	onChange: showCoords,
	onSelect: showCoords
});
function showCoords(c){
	$("#x").val(c.x);
	$("#y").val(c.y);
	$("#w").val(c.w);
	$("#h").val(c.h);
}

/*$(document).on('click','.likeListener',function(){
	var id = $(this).attr('id');
	var type = $(this).data('type');
	var thiss = $(this);
	
	if(type == 'like'){
		$("#"+id+"like").addClass("hidden");
		$("#"+id+"liked").removeClass("hidden");
	}else if(type == 'unlike'){
		$("#"+id+"liked").addClass("hidden");
		$("#"+id+"like").removeClass("hidden");
	}
});*/
