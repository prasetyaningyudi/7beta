var targeturl = '';

function login_data(target){
	targeturl = target;
	console.log(targeturl);
}

$('#login-submit').on('click',function(){
	var field = $(".login-form").find( "[name]" );
	var datainput='{';
	var i= 0;
	$(field).each(function(index,element){
		if($(this).is(':checkbox')){
			if($(this).is( ':checked' )){
				datainput += '"'+element.name+'"';
				datainput += ':';
				datainput += '"'+element.value+'"';
				if(i != field.length -1 ){
					datainput += ',';
				}
			}else{
				datainput += '"'+element.name+'"';
				datainput += ':';				
				datainput += '"off"';
				if(i != field.length -1 ){
					datainput += ',';
				}
			}
		}else if($(this).is(':radio')){
			if($(this).is( ':checked' )){
				datainput += '"'+element.name+'"';
				datainput += ':';
				datainput += '"'+element.value+'"';
				if(i != field.length -1 ){
					datainput += ',';
				}
			}
		}else{
			datainput += '"'+element.name+'"';
			datainput += ':';
			datainput += '"'+element.value+'"';
			if(i != field.length -1 ){
				datainput += ',';
			}
		}		
		i++;
	});
	datainput += '}';
	//console.log(datainput);

	$.ajax({
		type : "POST",
		url  : targeturl+'/login',
		dataType : "JSON",
		data : JSON.parse(datainput),
		success: function(data){
			if(data.status == true){
				var i;
				var error_info = '';
				for(i=0; i<data.info.length; i++){
					error_info += data.info[i]+'<br>';
				}
				$('#modal-info .modal-body').html('<strong>'+'error_info'+'</strong>');
				$('#modal-info').modal('show');
			}else{

			}
		}
	}); 

	return false;
});