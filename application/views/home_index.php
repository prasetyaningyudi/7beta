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
		
				</div>			
			</div>	
		</div>	
		</div>
		
		<div class="main main-home container-fluid">
			<div class="widget-home">
				<div class="title-home title-info font-weight-light">
		
				</div>
				
				<div id="show-data">
			
				</div>	
				<div class="mypagination" aria-label="navigation">

				</div>					
<!--				
				<div class="alert alert-light row home-list" role="alert">
					<div class="col-1 home-list-date text-center">
						<div class="home-list-date-date">24</div><div class="home-list-date-year text-capitalize">NOV 2018</div>
					</div>
					<div class="col-11">
						<h4 class="alert-heading">Well done!</h4>
						<hr>
						<p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
						<p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
					</div>
				</div>
-->		
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

<script src="<?php echo base_url(); ?>assets/js/broadcast.js"></script>	
<script src="<?php echo base_url(); ?>assets/js/form.js"></script>	

		
<script type="text/javascript">
$(document).ready(function(){
	//show data
	show_broadcast_data('<?php echo site_url($class); ?>');	
	crud_data('<?php echo site_url($class); ?>');		
});
</script>	



	