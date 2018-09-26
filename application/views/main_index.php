<div class="main-content">
	<div class="container-fluid">
	<div class="title row align-items-center">
		<div class="col-6">
			Breadcrum
		</div>		
		
		<div class="col-6 text-right font-weight-bold">
			<div class="button-input" id="button-input" style="float:right;text-align:center;font-size:16px"><a href="javascript:void(0);" data-toggle="modal" data-target="#modal_add" title="add"><i style="font-size: 18px;" class="fa fa-plus"></i><br>ADD</a></div>
		</div>	
	</div>	
	</div>	
		
	<div class="main">
		<div class="widget">
			<div class="title">
				<?php 
					if(isset($subtitle)){
						echo ucwords(strtolower($subtitle)).' ';
					}else{
						echo '';
					} 
					if(isset($title)){
						echo ucwords(strtolower($title));
					}else{
						echo 'Untitled';
					}
				?>			
			</div>
			<div class="chart">
				<div class="container-fluid mt-4 pb-4" id="show_data">

				</div>
			</div>
		</div>
	</div>	
</div>

        <!-- MODAL ADD -->
            <form method="post" id="form_add" novalidate> 
            <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add <?php if(isset($title)){	echo ucwords(strtolower($title));}?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input role="button" type="submit" id="btn_save" name="submit" class="btn btn-primary" value="submit">
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL ADD-->
		
        <!-- MODAL UPDATE -->
            <form method="post" id="form_update">
            <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update <?php if(isset($title)){	echo ucwords(strtolower($title));}?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
				  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input role="button" type="submit" id="btn_update" name="submit" class="btn btn-primary" value="submit">
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL ADD-->		
		
		<!--MODAL DELETE-->
         <form>
            <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete <?php if(isset($title)){	echo ucwords(strtolower($title));}?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                       <strong>Are you sure to delete this record?</strong>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="id" id="id" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <input role="button" type="submit" id="btn_delete" name="submit" class="btn btn-danger" value="submit">
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL DELETE-->		
		
		<!--MODAL DELETE-->
         <form>
            <div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error <?php if(isset($title)){	echo ucwords(strtolower($title));}?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                       
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="id" id="id" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL DELETE-->		

<script type="text/javascript">
    $(document).ready(function(){
        show_product(); //call function show all product
        
        //function show all product
        function show_product(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url($class.'/list')?>',
                async : true,
                dataType : 'json',
                success : function(list){
                    var html = '';
					html += '<table class="table'+tableClasses(list.classes)+'" id="mydata">';
					html += '<thead>';
					var i;
					var j;
					for(i=0; i<list.header.length; i++){
						html += '<tr>';
						for(j=0; j<list.header[i].length; j++){
							html += '<td class="align-middle '+ textClasses(list.header[i][j].classes)+ '" ';     
							if(list.header[i][j].rowspan != null){
								html += 'rowspan="'+list.header[i][j].rowspan+'" ';	
							}
							if(list.header[i][j].colspan != null){
								html += 'colspan="'+list.header[i][j].colspan+'" ';	
							}							
							html += '>';
							html += list.header[i][j].value;
							html += '</td>';
						}
						if(list.editable == true || list.deletable == true){
							if(i==0){
								html += '<td class="align-middle text-center font-weight-bold" rowspan="'+list.header.length+'" colspan="2">Action';
								html += '</td>'; 
							}
						}
						html += '</tr>';
					}
					html += '</thead>';
					html += '<tbody>';
					var i;
					var j;
					for(i=0; i<list.body.length; i++){
						html += '<tr>';
						for(j=0; j<list.body[i].length; j++){
							if(list.body[i][j].classes.includes("hidden") == true){
								
							}else{
								html += '<td class="'+ textClasses(list.body[i][j].classes) +'"';
								if(list.body[i][j].rowspan != null){
									html += 'rowspan="'+list.body[i][j].rowspan+'" ';	
								}
								if(list.body[i][j].colspan != null){
									html += 'colspan="'+list.body[i][j].colspan+'" ';	
								}
								html += '>';
								html += list.body[i][j].value;
								html += '</td>';
							}
						}
						if(list.body.length == 1 & list.body[i][0].classes.includes("empty") == true){
							
						}else{
							if(list.editable == true){
								html += '<td class="text-center font-weight-bold">';
								html += '<a class="item-update" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="modal" data-target="#modal_edit" title="edit"><i style="font-size: 16px;" class="fa fa-pencil"></i></a>';
								html += '</td>';
							}
							if(list.deletable == true){
								html += '<td class="text-center font-weight-bold">';
								html += '<a class="item-delete" id="'+list.body[i][0].value+'" href="javascript:void(0);" title="delete"><i style="font-size: 16px;" class="fa fa-trash"></i></a>';
								html += '</td>';
							}								
						}					
						html += '</tr>';
					}					
					html += '</tbody>';
					html += '</table>';
                    $('#show_data').html(html);
                }
            });
			
        }
		
		
		//get data for input record
         $('#button-input').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url($class.'/insert')?>",
                dataType : "JSON",
                success: function(data){
					console.log(data.fields);
					var html = '';
					var i;
					for(i=0;i<data.fields.length;i++){
						html += '<div class="form-group row">';
						html += '<label class="col-md-2 col-form-label">'+data.fields[i].label+'</label>';
						html += '<div class="col-md-10">';
						
						if(data.fields[i].type == 'text'){
							html += '<input type="text" name="'+data.fields[i].name+'" id="'+data.fields[i].name+'" class="form-control" placeholder="'+data.fields[i].label+'" ';					
							html += fieldClasses(data.fields[i].classes);
							html += '>';
						}
						
						html += '</div>';
						html += '</div>';
					}
					$('#modal_add .modal-body').html(html);
                    $('#modal_add').modal('show');
                }
            });
            return false;
        });			
		
        $('#btn_save').on('click',function(){
			var abc = $("#form_add").find( "[name]" );
			var datainput='{';
			var i= 0;
			$(abc).each(function(index,element){
				if(i != 0){
					datainput += ',';
				}
				datainput += '"'+element.name+'"';
				datainput += ':';
				datainput += '"'+element.value+'"';
				i++;
			});
			datainput += '}';
			console.log(datainput);

			var nama = $('#nama').val();
			var alamat = $('#alamat').val();
			var submit = $('#btn_save').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url($class.'/insert')?>",
                dataType : "JSON",
				data : JSON.parse(datainput),
                success: function(data){
					console.log(data);
                    $('#modal_add').modal('hide');
                    show_product();
					if(data.status == true){
						var i;
						var error_info = '';
						for(i=0; i<data.info.length; i++){
							error_info += data.info[i]+'<br>';
						}
						$('#modal_error .modal-body').html('<strong>'+error_info+'</strong>');
						$('#modal_error').modal('show');
					}else{
						$("#form_add")[0].reset();
					}
                }
            });
            return false;
        });	
		
		//get data for delete record
        $('#show_data').on('click','.item-update',function(){
            var id = $(this).attr("id");
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url($class.'/update')?>",
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
						
						if(data.fields[i].type == 'text'){
							html += '<input type="text" name="'+data.fields[i].name+'" id="'+data.fields[i].name+'" value="'+data.fields[i].value+'" class="form-control" placeholder="'+data.fields[i].label+'" ';					
							html += fieldClasses(data.fields[i].classes);
							html += '>';
						}else if(data.fields[i].type == 'hidden'){
							html += '<input type="hidden" name="'+data.fields[i].name+'" id="'+data.fields[i].name+'" value="'+data.fields[i].value+'" class="form-control" ';					
							html += fieldClasses(data.fields[i].classes);
							html += '>';
						}
						
						html += '</div>';
						html += '</div>';
					}
					$('#modal_update .modal-body').html(html);
                    $('#modal_update').modal('show');
                }
            });
            return false;
        });		
		
        $('#btn_update').on('click',function(){
			var abc = $("#form_update").find( "[name]" );
			var datainput='{';
			var i= 0;
			$(abc).each(function(index,element){
				if(i != 0){
					datainput += ',';
				}
				datainput += '"'+element.name+'"';
				datainput += ':';
				datainput += '"'+element.value+'"';
				i++;
			});
			datainput += '}';
			console.log(datainput);
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url($class.'/update')?>",
                dataType : "JSON",
				data : JSON.parse(datainput),
                success: function(data){
					console.log(data);
                    $('#modal_update').modal('hide');
                    show_product();
					if(data.status == true){
						var i;
						var error_info = '';
						for(i=0; i<data.info.length; i++){
							error_info += data.info[i]+'<br>';
						}
						$('#modal_error .modal-body').html('<strong>'+error_info+'</strong>');
						$('#modal_error').modal('show');
					}else{
						//$("#form_add")[0].reset();
					}
                }
            });
            return false;
        });			

		//get data for delete record
        $('#show_data').on('click','.item-delete',function(){
            var id = $(this).attr("id");
            $('#modal_delete').modal('show');
            $('[name="id"]').val(id);
        });
 
        //delete record to database
         $('#btn_delete').on('click',function(){
            var id = $('#id').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url($class.'/delete')?>",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                    $('#modal_delete').modal('hide');
                    show_product();
                }
            });
            return false;
        });		
		
		function tableClasses(value){
			var tabled='';
			if(value.includes("striped") == true){
				tabled += ' table-striped';
			}
			if(value.includes("bordered") == true){
				tabled += ' table-bordered';
			}
			if(value.includes("hover") == true){
				tabled += ' table-hover';
			}
			return tabled;
		}
		
		
		function fieldClasses(value){
			var required;
			if(value.includes("required") == true){
				required = 'required';
			}else{
				required = '';
			}
			
			return required;
		}
		
		function textClasses(value){
			var fontweight;
			var fontitalic;
			var texttransform;
			var textalign;	
			
			if(value.includes("bold") == true){
				fontweight= 'font-weight-bold';
			}else if(value.includes("light") == true){
				fontweight= 'font-weight-light';
			}else if(value.includes("normal") == true){
				fontweight= 'font-weight-normal';
			}else{
				fontweight= 'font-weight-normal';
			}
			
			if(value.includes("italic") == true){
				fontitalic= 'font-italic';
			}else{
				fontitalic= '';
			}
			
			if(value.includes("uppercase") == true){
				texttransform= 'text-uppercase';
			}else if(value.includes("lowercase") == true){
				texttransform= 'text-lowercase';
			}else if(value.includes("capitalize") == true){
				texttransform= 'text-capitalize';
			}else{
				texttransform= '';
			}			
			
			if(value.includes("align-left") == true){
				textalign= 'text-left';
			}else if(value.includes("align-center") == true){
				textalign= 'text-center';
			}else if(value.includes("align-right") == true){
				textalign= 'text-right';
			}else{
				textalign= 'text-left';
			}

			return (fontweight+ ' ' + fontitalic + ' ' + texttransform + ' ' + textalign);
		}
		
	});
</script>