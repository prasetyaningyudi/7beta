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
		if(i != 0){
			datainput += ',';
		}
		datainput += '"'+element.name+'"';
		datainput += ':';
		datainput += '"'+element.value+'"';
		i++;
	});
	datainput += '}';

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
				$("#form-add")[0].reset();
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
		if(i != 0){
			datainput += ',';
		}
		datainput += '"'+element.name+'"';
		datainput += ':';
		datainput += '"'+element.value+'"';
		i++;
	});
	datainput += '}';
	$.ajax({
		type : "POST",
		url  : targeturl+'/update',
		dataType : "JSON",
		data : JSON.parse(datainput),
		success: function(data){
			console.log(data);
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

function fieldData(data){
	var html = '';
	if(data.type == 'text'){
		html += '<input type="text" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.label+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'email'){
		html += '<input type="email" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.label+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'password'){
		html += '<input type="password" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.label+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'date'){
		html += '<input type="date" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" placeholder="'+data.label+'" ';					
		html += fieldClasses(data.classes);
		html += '>';
	}else if(data.type == 'textarea'){
		html += '<textarea name="'+data.name+'" id="'+data.name+'" class="form-control" rows="4" placeholder="'+data.label+'" ';					
		html += fieldClasses(data.classes);
		html += '>'+data.value+'</textarea>';
	}else if(data.type == 'hidden'){
		html += '<input type="hidden" name="'+data.name+'" id="'+data.name+'" value="'+data.value+'" class="form-control" ';	
		html += fieldClasses(data.classes);
		html += '></textarea>';
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