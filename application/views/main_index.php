<div class="wrapper">
	<div class="main-content">
		<div class="container-fluid">
		<div class="title row align-items-center">
			<div class="col-6" style="font-size:20px">
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
			
			<div class="col-6 text-right font-weight-bold">
				<div class="filters">
	
				</div>		
			
				<div class="insert">
					<div class="button-input button-toolbar" id="button-input" style="float:right;text-align:center;font-size:15px">
					<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add" title="add">
						<i style="font-size: 16px;" class="fa fa-plus"></i><br>ADD
					</a>
					</div>			
				</div>			
			</div>	
		</div>	
		</div>
		
		<div class="main">
			<div class="widget">
				<div class="title title-info font-weight-light">
		
				</div>
				
				<div class="chart">
					<div class="container-fluid mt-4 pb-4" id="show-data">
					</div>
					<div class="mypagination" aria-label="navigation">

					</div>					
				</div>
			</div>	
		</div>	
	</div>

	<div id="filter-sidebar">
		<div id="filter-content">
			<div class="filter-dialog">	
				<form method="post" id="form-filter"> 
				<div class="filter-header row align-middle">
					<div class="col-10 filter-title">Filter Data</div>
					<button type="button" class="col-2 close button-filter-close">
					  <span aria-hidden="true">&times;</span>
					</button>				
				</div>	
				<div class="filter-body">
				
				</div>	
				<div class="filter-footer row align-middle">
					<div class="col-6">
						<input role="button" type="reset" id="button-reset" name="reset" class="btn-block btn btn-outline-secondary" value="reset">
					</div>					
					<div class="col-6">
						<input role="button" type="submit" id="button-submit-filter" name="submit" class="btn-block btn btn-outline-primary align-right" value="submit">
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>		
</div>		

<!-- MODAL ADD -->
<form method="post" id="form-add"> 
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
		<input role="button" type="reset" id="button-reset" name="reset" class="btn btn-secondary" value="reset">
		<input role="button" type="submit" id="button-save" name="submit" class="btn btn-primary" value="submit">
	  </div>
	</div>
  </div>
</div>
</form>
<!--END MODAL ADD-->

<!-- MODAL UPDATE -->
<form method="post" id="form-update">
<div class="modal fade" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
		<input role="button" type="submit" id="button-update" name="submit" class="btn btn-primary" value="submit">
	  </div>
	</div>
  </div>
</div>
</form>
<!--END MODAL UPDATE-->		

<!--MODAL DELETE-->
 <form>
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
			<input role="button" type="submit" id="button-delete" name="submit" class="btn btn-danger" value="submit">
		  </div>
		</div>
	  </div>
	</div>
	</form>
<!--END MODAL DELETE-->		

<!--MODAL 	ERROR-->
 <form>
	<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<!--END MODAL ERROR-->

			
<script src="<?php echo base_url(); ?>assets/js/table.js"></script>	
<script src="<?php echo base_url(); ?>assets/js/form.js"></script>	

		
<script type="text/javascript">
$(document).ready(function(){
	//show data
	show_data('<?php echo site_url($class); ?>');	
	//insert update delete data
	crud_data('<?php echo site_url($class); ?>');	
});
</script>



	