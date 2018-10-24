<section class="login-block">
<div class="container">
	<div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Information</h5>
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

	<div class="row">
		<div class="col-md-4">
			<div class="login-sec">
				<h2 class="text-center">OOPS</h2>
				<div class="text-center text-second">401</div>
				<div class="text-center">The page you have requested can't authorized your credential.</div><br>
				<div class="text-center">
					<a href="<?php echo base_url(); ?>" class="btn btn-lg btn-info"><i class="fa fa-home"></i>  GO HOME</a>
				</div>
				<div class="copy-text text-center">Created with <i class="fa fa-heart"></i> by <a href="http://omyudi.com">OmYudi.com</a></div>
			</div>		
		</div>
		
		
		<div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                 <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
				<div class="carousel-inner" role="listbox">
					<div class="carousel-item active">
					  <img class="d-block img-fluid" src="<?php echo base_url(); ?>assets/images/bg-1.jpeg" alt="First slide">
					  <div class="carousel-caption d-none d-md-block">
						<div class="banner-text">
							<h2>This is Heaven</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
						</div>	
					  </div>
					</div>
					<div class="carousel-item">
					  <img class="d-block img-fluid" src="<?php echo base_url(); ?>assets/images/bg-2.jpeg" alt="Second slide">
					  <div class="carousel-caption d-none d-md-block">
						<div class="banner-text">
							<h2>This is Heaven</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
						</div>	
					  </div>
					</div>
					<div class="carousel-item">
					  <img class="d-block img-fluid" src="<?php echo base_url(); ?>assets/images/bg-3.jpeg" alt="Third slide">
					  <div class="carousel-caption d-none d-md-block">
						<div class="banner-text">
							<h2>This is Heaven</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
						</div>	
					  </div>
					</div>
				</div>	   
			</div>
		</div>
	</div>
</div>
</section>

<?php if(isset($error->status) and $error->status == true): ?>
	<?php $error_info = ''; ?>
	<?php foreach($error->info as $val): ?>
		<?php $error_info .= $val.'<br>'; ?>
	<?php endforeach; ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#modal-info .modal-body').html('<strong>'+'<?php echo $error_info; ?>'+'</strong>');
		$('#modal-info').modal('show');	
	});
	</script>	
<?php endif; ?>
