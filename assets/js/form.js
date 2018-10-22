var targeturl;

function crud_data(target){
	targeturl = target;
}

//input record
$('#button-input').on('click',function(){
	$.ajax({
		type : "POST",
		url  : targeturl+'/insert',
		dataType : "JSON",
		success: function(data){
			var html = '';
			var i;
			for(i=0;i<data.fields.length;i++){
				html += '<div class="form-group row">';
				html += '<label class="col-md-2 col-form-label">'+data.fields[i].label+'</label>';
				html += '<div class="col-md-10">';
				html += fieldData(data.fields[i]);
				html += '</div>';
				html += '</div>';
			}
			$('#modal-add .modal-body').html(html);
			$('#modal-add').modal('show');
		}
	});
	return true;
});

$('#button-save').on('click',function(){
	var field = $("#form-add").find( "[name]" );
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
		url  : targeturl+'/insert',
		dataType : "JSON",
		data : JSON.parse(datainput),
		success: function(data){
			$('#modal-add').modal('hide');
			show_data(targeturl+'/list');
			if(data.status == true){
				var i;
				var error_info = '';
				for(i=0; i<data.info.length; i++){
					error_info += data.info[i]+'<br>';
				}
				$('#modal-error .modal-body').html('<strong>'+error_info+'</strong>');
				$('#modal-error').modal('show');
			}else{
				$("#form-add").trigger("reset");
			}
		}
	});

	return false;
});		

//get data for update record
$('#show-data').on('click','.item-update',function(){
	var id = $(this).attr("id");
	$.ajax({
		type : "POST",
		url  : targeturl+'/update',
		dataType : "JSON",
		data : {id:id},
		success: function(data){
			var html = '';
			var i;
			for(i=0;i<data.fields.length;i++){
				html += '<div class="form-group row">';
				if(data.fields[i].type != 'hidden'){
					html += '<label class="col-md-2 col-form-label">'+data.fields[i].label+'</label>';
				}
				html += '<div class="col-md-10">';
				html += fieldData(data.fields[i]);
				html += '</div>';
				html += '</div>';
			}
			$('#modal-update .modal-body').html(html);
			$('#modal-update').modal('show');
		}
	});
	return false;
});	

$('#button-update').on('click',function(){
	var field = $("#form-update").find( "[name]" );
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
		url  : targeturl+'/update',
		dataType : "JSON",
		data : JSON.parse(datainput),
		success: function(data){
			//console.log(data);
			$('#modal-update').modal('hide');
			show_data(targeturl+'/list');
			if(data.status == true){
				var i;
				var error_info = '';
				for(i=0; i<data.info.length; i++){
					error_info += data.info[i]+'<br>';
				}
				$('#modal-error .modal-body').html('<strong>'+error_info+'</strong>');
				$('#modal-error').modal('show');
			}else{
				
			}
		}
	});
	return false;
});	

//get data for delete record
$('#show-data').on('click','.item-delete',function(){
	var id = $(this).attr("id");
	$('#modal-delete').modal('show');
	$('[name="id"]').val(id);
});

//delete record to database
 $('#button-delete').on('click',function(){
	var id = $('#id').val();
	$.ajax({
		type : "POST",
		url  : targeturl+'/delete',
		dataType : "JSON",
		data : {id:id},
		success: function(data){
			$('#modal-delete').modal('hide');
			show_data(targeturl+'/list');
		}
	});
	return false;
});

//delete record to database
$('#show-data').on('click','.item-status',function(){
	var id = $(this).attr("id");
	$.ajax({
		type : "POST",
		url  : targeturl+'/update_status',
		dataType : "JSON",
		data : {id:id},
		success: function(data){
			show_data(targeturl+'/list');
		}
	});
	return false;
});

function fieldData(data){
	//console.log(data);
	var html = '';
	if(data.type == 'text'){
		html += '<input type="text" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.placeholder+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'email'){
		html += '<input type="email" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.placeholder+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'password'){
		html += '<input type="password" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.placeholder+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'date'){
		html += '<input type="date" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.placeholder+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'textarea'){
		html += '<textarea name="'+data.name+'" id="'+data.name+'" class="form-control" rows="4" placeholder="'+data.placeholder+'" ';					
		html += fieldClasses(data.classes);
		html += '>'+data.value+'</textarea>';
	}else if(data.type == 'hidden'){
		html += '<input type="hidden" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" ';	
		html += fieldClasses(data.classes);
		html += '></textarea>';
	}else if(data.type == 'select'){
		html += '<select name="'+data.name+'" id="'+data.name+'" class="form-control custom-select" ';	
		html += fieldClasses(data.classes);
		html += '>';
		html += '<option value="">'+data.placeholder+'</option>';
		var i;
		for(i=0;i<data.options.length;i++){
			//console.log(data.value);
			if(data.value == data.options[i].value){
				html += '<option value="'+data.options[i].value+'" selected>'+data.options[i].label+'</option>';
			}else{
				html += '<option value="'+data.options[i].value+'">'+data.options[i].label+'</option>';
			}
		}
		html += '</select>';
	}else if(data.type == 'radio'){	
		var i;
		for(i=0;i<data.options.length;i++){
			html += '<div class="form-check">';
			html += '<input class="form-check-input" type="radio" name="'+data.name+'" id="'+data.name+i+'" value="'+data.options[i].value+'" ';			
			if(data.value == data.options[i].value){
				html += 'checked>';
			}else{
				html += '>';
			}
			html += '<label class="form-check-label" for="'+data.name+i+'">';
			html += data.options[i].label;
			html += '</label>';
			html += '</div>';
		}
	}else if(data.type == 'checkbox'){	
		var i;
		for(i=0;i<data.options.length;i++){
			html += '<div class="form-check">';
			html += '<input class="form-check-input" type="checkbox" name="'+data.name+'" id="'+data.name+i+'" ';
			if(data.value == 'on'){
				html += 'checked>';
			}else{
				html += '>';
			}
			html += '<label class="form-check-label" for="'+data.name+i+'">';
			html += data.options[i].label;
			html += '</label>';
			html += '</div>';
		}
	}
	return html;
}

function fieldClasses(value){
	var required = '';
	var readonly = '';
	var disabled = '';
	if(value.includes("required") == true){
		required = 'required';
	}
	if(value.includes("readonly") == true){
		readonly = 'readonly';
	}
	if(value.includes("disabled") == true){
		disabled = 'disabled';
	}
	
	return (required + ' ' + readonly + ' ' + disabled);
}	