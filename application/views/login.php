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
			<div class="row nav-tab">
				<div class="col-md-6 text-center">
					<a href="#" class="button-login btn btn-outline-primary active" role="button">LOGIN</a>
				</div>
				<div class="col-md-6 text-center">
					<a href="#" class="button-register btn btn-outline-primary" role="button">REGIS</a>
				</div>				
			</div>
			<div class="login-sec">
				<h2 class="text-center">Login Now</h2>
				<form class="login-form" method="post">
				  <div class="form-group">
					<label for="exampleInputEmail1" class="text-uppercase">Username</label>
					<input name="username" type="text" class="form-control" placeholder="" required>
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1" class="text-uppercase">Password</label>
					<input name="password" type="password" class="form-control" placeholder="" required>
				  </div>
				  
				  
				  <div class="form-check">
					<label class="form-check-label">
					  <input type="checkbox" class="form-check-input">
					  <small>Remember Me</small>
					</label>
					<button type="submit" id="login-submit" name="login-submit" class="btn btn-login float-right">Submit</button>
				  </div>
				</form>
				<div class="copy-text">Created with <i class="fa fa-heart"></i> by <a href="http://omyudi.com">OmYudi.com</a></div>
			</div>		
		
			<div class="register-sec">
				<h2 class="text-center">Register Now</h2>
				<form class="register-form" method="post">
				  <div class="form-group">
					<label for="exampleInputEmail1" class="text-uppercase">Username</label>
					<input name="username" type="text" class="form-control" placeholder="" required>
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1" class="text-uppercase">Password</label>
					<input name="password" type="password" class="form-control" placeholder="" required>
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1" class="text-uppercase">Repeat Password</label>
					<input name="password_r" type="password" class="form-control" placeholder="" required>
				  </div>			  
				  <div class="form-check">
					<button type="submit" name="register-submit" class="btn btn-login float-right">Submit</button>
				  </div>
				</form>
				<div class="copy-text">Created with <i class="fa fa-heart"></i> by <a href="http://omyudi.com">OmYudi.com</a></div>
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

<script src="<?php echo base_url(); ?>assets/js/login.js"></script>	

		
<script type="text/javascript">
$(document).ready(function(){
	//show data
	login_data('<?php echo site_url($class); ?>');	
});
</script>