$(".insert").hide();
function show_data(targeturl){
	$.ajax({
		type  : 'ajax',
		url   : targeturl+'/list',
		async : true,
		dataType : 'json',
		success : function(list){
			if(list.insertable == false){
				$(".insert").hide();
			}else{
				$(".insert").show();
			}
			var html = '';
			html +=	'<div class="button-filter button-toolbar" id="button-filter" style="float:right;text-align:center;font-size:15px">';
			html +=	'<a href="javascript:void(0);" title="filter">';
			html +=	'<i style="font-size: 16px;" class="fa fa-filter"></i><br>FILTER';
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
					$("#filter-sidebar").css( "visibility", "visible" );					
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
				if(list.editable == true || list.deletable == true || list.statusable == true){
					if(i==0){
						html += '<td class="align-middle text-center font-weight-bold" rowspan="'+list.header.length+'" colspan="3">Action';
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
					if(list.statusable == true){
						html += '<td class="text-center font-weight-bold">';
						html += '<a class="item-status" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="edit status"><i style="font-size: 16px;" class="fa fa-check"></i></a>';
						html += '</td>';
					}					
					if(list.editable == true){
						html += '<td class="text-center font-weight-bold">';
						html += '<a class="item-update" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="edit"><i style="font-size: 16px;" class="fa fa-pencil"></i></a>';
						html += '</td>';
					}
					if(list.deletable == true){
						html += '<td class="text-center font-weight-bold">';
						html += '<a class="item-delete" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="delete"><i style="font-size: 16px;" class="fa fa-trash"></i></a>';
						html += '</td>';
					}								
				}					
				html += '</tr>';
			}					
			html += '</tbody>';
			html += '</table>';		
			$('#show-data').html(html);
			
			if(list.pagination != null && list.pagination != '' && list.pagination != false){
				var limit = list.pagination[0];
				var offset = list.pagination[1];
				var total = list.pagination[2];
				var iterasi = Math.ceil(total/limit);
				console.log(iterasi);
				console.log(total/limit);
				console.log(limit);
				
				html = '<nav aria-label="pagination-example">';
				html +=	'<ul class="pagination justify-content-center">';
				
				if(offset == '0'){
					html +=	'<li class="page-item disabled"><a numb="" class="page-link">Prev</a></li>';
				}else{
					html +=	'<li class="page-item"><a numb="'+(offset/limit)+'" class="page-link">Prev</a></li>';
				}					
				
				for(var i = 0; i<iterasi; i++){
					if(offset/limit == i){
						html +=	'<li class="page-item active"><a numb="'+(i+1)+'" class="page-link">'+(i+1)+'</a></li>';
					}else{
						html +=	'<li class="page-item"><a numb="'+(i+1)+'" class="page-link">'+(i+1)+'</a></li>';
					}
				}
				if((total - offset) <= limit){
					html +=	'<li class="page-item disabled"><a class="page-link">Next</a></li>';
				}else{
					html +=	'<li class="page-item"><a numb ="'+(offset/limit+2)+'" class="page-link">Next</a></li>';
				}	
				
				html +=	'</ul>';
				html +=	'</nav>';
				$('.mypagination').html(html);
				

				$('a.page-link').click(function() {
					console.log();
					var cur_offset = ($(this).attr('numb') - 1) * limit;
					show_data_pagination(targeturl, cur_offset, false);
				});
				
				$('#button-submit-filter').on('click',function(){
					show_data_pagination(targeturl, offset, true);
					return false;
				});	
				
			}else{
				$('#button-submit-filter').on('click',function(){
					show_data_pagination(targeturl, false, true);
					return false;
				});					
			}
			var html = '';
			$('.title-info').html(html);
		}
	});
	
}

function show_data_pagination(targeturl, offset, from_filter){
	var datainput='{';	
	if(from_filter == true){
		var field = $("#form-filter").find( "[name]" );
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
		if(offset != false){
			datainput += ',"offset":'+offset+',';
			datainput += '"submit":"sumbit"';			
		}
	}else{
		if(offset != false){
			datainput += '"offset":'+offset+',';
			datainput += '"submit":"sumbit"';			
		}
	}
	
	datainput += '}';

	$.ajax({
		type : "POST",
		url  : targeturl+'/list',
		dataType : "JSON",
		data : JSON.parse(datainput),
		success: function(list){
			if(list.insertable == false){
				$(".insert").hide();
			}else{
				$(".insert").show();
			}
			var html = '';
			html +=	'<div class="button-filter button-toolbar" id="button-filter" style="float:right;text-align:center;font-size:15px">';
			html +=	'<a href="javascript:void(0);" title="filter">';
			html +=	'<i style="font-size: 16px;" class="fa fa-filter"></i><br>FILTER';
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
					$("#filter-sidebar").css( "visibility", "visible" );					
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
					if(list.statusable == true){
						html += '<td class="text-center font-weight-bold">';
						html += '<a class="item-status" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="edit status"><i style="font-size: 16px;" class="fa fa-check"></i></a>';
						html += '</td>';
					}					
					if(list.editable == true){
						html += '<td class="text-center font-weight-bold">';
						html += '<a class="item-update" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="edit"><i style="font-size: 16px;" class="fa fa-pencil"></i></a>';
						html += '</td>';
					}
					if(list.deletable == true){
						html += '<td class="text-center font-weight-bold">';
						html += '<a class="item-delete" id="'+list.body[i][0].value+'" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="delete"><i style="font-size: 16px;" class="fa fa-trash"></i></a>';
						html += '</td>';
					}							
				}					
				html += '</tr>';
			}					
			html += '</tbody>';
			html += '</table>';
			$('#show-data').html(html);
			
			
			if(list.pagination != null && list.pagination != '' && list.pagination != false){
				var limit = list.pagination[0];
				var offset = list.pagination[1];
				var total = list.pagination[2];
				var iterasi = Math.ceil(total/limit);		
				
				html = '<nav aria-label="pagination-example">';
				html +=	'<ul class="pagination justify-content-center">';
				
				if(offset == '0'){
					html +=	'<li class="page-item disabled"><a numb="" class="page-link">Prev</a></li>';
				}else{
					html +=	'<li class="page-item"><a numb="'+(offset/limit)+'" class="page-link">Prev</a></li>';
				}					
				
				for(var i = 0; i<iterasi; i++){
					if(offset/limit == i){
						html +=	'<li class="page-item active"><a numb="'+(i+1)+'" class="page-link">'+(i+1)+'</a></li>';
					}else{
						html +=	'<li class="page-item"><a numb="'+(i+1)+'" class="page-link">'+(i+1)+'</a></li>';
					}
				}
				if((total - offset) <= limit){
					html +=	'<li class="page-item disabled"><a class="page-link">Next</a></li>';
				}else{
					html +=	'<li class="page-item"><a numb ="'+(offset/limit+2)+'" class="page-link">Next</a></li>';
				}	
				
				html +=	'</ul>';
				html +=	'</nav>';
				$('.mypagination').html(html);
				

				$('a.page-link').click(function() {
					if(from_filter == true){
						var cur_offset = ($(this).attr('numb') - 1) * limit;
						show_data_pagination(targeturl, cur_offset, true);
					}else{
						var cur_offset = ($(this).attr('numb') - 1) * limit;
						show_data_pagination(targeturl, cur_offset, false);						
					}
				});
				
	
				
			}else{

			}
			
			if(from_filter == true){
				var html = '';
				var j = 0
				var myArray = [];
				for(i=0;i<list.filters.length;i++){
					if(list.filters[i].value != '' && list.filters[i].value != null){
						if(list.filters[i].type == 'select'){
							for(var k = 0; k<list.filters[i].options.length; k++){
								//console.log(list.filters[i].options[k].value);
								if(list.filters[i].options[k].value == list.filters[i].value){
									myArray.push('<span class="text-body">'+list.filters[i].label+' : </span><span class=".text-secondary">'+list.filters[i].options[k].label+'</span>');
								}
							}
						}else{
							myArray.push('<span class="text-body">'+list.filters[i].label+' : </span><span class=".text-secondary">'+list.filters[i].value+'</span>');
						}
						j++;
					}
				}
				if(j > 1){
					html +=	'<span class="text-dark">'+j+' Filters <i class="fa fa-caret-right"></i></span> ';
				}else{
					html +=	'<span class="text-dark">A Filter <i class="fa fa-caret-right"></i></span> ';
				}
				html += ''+myArray.join(', ');
				$('.title-info').html(html);
			}			
			
		}
	});
}


/* $('#button-submit-filter').on('click',function(){
	var field = $("#form-filter").find( "[name]" );
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
					$("#filter-sidebar").css( "visibility", "visible" );					
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
}); */

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

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