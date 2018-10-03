$(function(){
	$(document).on('click','.friendBtn',function(){
		var $this = $(this);
		var type = $this.data('type');
		
		switch(type){
			case 'addfriend':
				var id = $this.data('uid');
				
				if(id != ""){
					$.post('http://prototypesocial.esy.es/parse.php',{
						tags: 'addFriend',
						uid: id
					},function(data){
						var obj = jQuery.parseJSON(data);
						
						if(obj.code != 1){
							$this.text(obj.msg);
							$this.attr('disabled','disabled');
						}else{
							alert('Problema com sistema:'+obj.msg);
						}
					});
				}
			break;
		}
	});
});
