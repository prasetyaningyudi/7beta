function show_broadcast_data(targeturl){
	$.ajax({
		type  : 'ajax',
		url   : targeturl+'/list',
		async : true,
		dataType : 'json',
		success : function(list){
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
			var i;
			var j;
			for(i=0; i<list.body.length; i++){
				for(j=0; j<list.body[i].length; j++){
					if(list.body[i][j].classes.includes("hidden") == true){
						
					}else{
						html += list.body[i][j].value;
					}
				}
			}
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
			var i;
			var j;
			for(i=0; i<list.body.length; i++){
				for(j=0; j<list.body[i].length; j++){
					if(list.body[i][j].classes.includes("hidden") == true){
						
					}else{
						html += list.body[i][j].value;
					}
				}
			}
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
