function show_data(targeturl){
	$.ajax({
		type  : 'ajax',
		url   : targeturl+'/list',
		async : true,
		dataType : 'json',
		success : function(list){
			var html = '';
			html +=	'<div class="button-filter button-toolbar" id="button-filter" style="float:right;text-align:center;font-size:16px">';
			html +=	'<a href="javascript:void(0);" title="filter">';
			html +=	'<i style="font-size: 18px;" class="fa fa-filter"></i><br>FILTER';
			html +=	'</a>';
			html +=	'</div>';
			if(list.filters != null){
				$('.filters').html(html);
				
				var html = '';
				var i;
				for(i=0;i<list.filters.length;i++){
					html += '<div class="form-group">';
					html += '<label class="">'+list.filters[i].label+'</label>';
					html += '<div class="">';
					html += fieldData(list.filters[i]);
					html += '</div>';
					html += '</div>';
				}
				$('.filter-body').html(html);				
				
			}

			var expanded = false;
			$("#button-filter, .button-filter-close").click(function () {
				if (expanded = !expanded) {
					$("#filter-content").show();
					$("#filter-sidebar").css( "z-index", 999 );
					$("#filter-content").animate({ "margin-right": "0" }, 500);
				} else {
					$("#filter-content").hide();
					$("#filter-content").animate({ "margin-right": "-100%" }, 400);
					$("#filter-sidebar").css( "z-index", -1 );
				}
			});
			
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
						html += '<a class="item-update" id="'+list.body[i][0].value+'" href="javascript:void(0);" title="edit"><i style="font-size: 16px;" class="fa fa-pencil"></i></a>';
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
			$('#show-data').html(html);
		}
	});
	
}

$('#button-submit-filter').on('click',function(){
	var field = $("#form-filter").find( "[name]" );
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
	console.log(datainput);
	$.ajax({
		type : "POST",
		url  : targeturl+'/list',
		dataType : "JSON",
		data : JSON.parse(datainput),
		success: function(list){
			var html = '';
			html +=	'<div class="button-filter button-toolbar" id="button-filter" style="float:right;text-align:center;font-size:16px">';
			html +=	'<a href="javascript:void(0);" title="filter">';
			html +=	'<i style="font-size: 18px;" class="fa fa-filter"></i><br>FILTER';
			html +=	'</a>';
			html +=	'</div>';
			if(list.filters != null){
				$('.filters').html(html);
				
				var html = '';
				var i;
				for(i=0;i<list.filters.length;i++){
					html += '<div class="form-group">';
					html += '<label class="">'+list.filters[i].label+'</label>';
					html += '<div class="">';
					html += fieldData(list.filters[i]);
					html += '</div>';
					html += '</div>';
				}
				$('.filter-body').html(html);				
				
			}

			$("#filter-content").hide();
			$("#filter-content").animate({ "margin-right": "-100%" }, 400);
			$("#filter-sidebar").css( "z-index", -1 );
			
			var expanded = false;
			$("#button-filter, .button-filter-close").click(function () {
				if (expanded = !expanded) {
					$("#filter-content").show();
					$("#filter-sidebar").css( "z-index", 999 );
					$("#filter-content").animate({ "margin-right": "0" }, 500);
				} else {
					$("#filter-content").hide();
					$("#filter-content").animate({ "margin-right": "-100%" }, 400);
					$("#filter-sidebar").css( "z-index", -1 );
				}
			});
			
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
						html += '<a class="item-update" id="'+list.body[i][0].value+'" href="javascript:void(0);" title="edit"><i style="font-size: 16px;" class="fa fa-pencil"></i></a>';
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
			$('#show-data').html(html);
		}
	});
	return false;
});

function tableClasses(value){
	var table='';
	if(value.includes("striped") == true){
		table += ' table-striped';
	}
	if(value.includes("bordered") == true){
		table += ' table-bordered';
	}
	if(value.includes("hover") == true){
		table += ' table-hover';
	}
	return table;
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