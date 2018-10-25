	<div class="header">
		<div class="logo">
			<a href="<?php echo base_url(); ?>">
			<i class="fa fa-tachometer"></i>
			<span>7Beta</span>
			</a>
		</div>
		<a href="#" class="nav-trigger"><span>
		</span></a>
		<div class="navigation">
			<div class="dropdown">
				<?php if($this->session->USERNAME != null): ?>
					<a class="dropdown-toggle dropdown-head" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
						<?php echo 'Welcome, '.$this->session->USERNAME; ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top:8px">
						<p class="dropdown-header"><i class="fa fa-users"></i> Login as <?php echo $this->session->ROLE_NAME; ?></p>
						<a class="dropdown-item" href="<?php echo base_url().'profile'; ?>"><i class="fa fa-cog"></i> Profile Setting</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url().'authentication/logout'; ?>"><i class="fa fa-sign-out"></i> Sign Out</a>
					</div>
				<?php else: ?>
					<a title="login" role="button" class="dropdown-head" href="<?php echo base_url().'authentication/login'; ?>"><i class="fa fa-sign-in"> </i> Welcome, Guest</a>	
				<?php endif; ?>
			</div>
		</div>		
	</div>
	<div class="side-nav">
		<div class="logo">
			<a href="<?php echo base_url(); ?>">
			<i class="fa fa-tachometer"></i>
			<span>7Beta</span>
			</a>
		</div>
		<nav>
			<ul>
				<?php foreach ($menu as $item):?>
				<li>
					<a href="#<?php echo $item->MENU_NAME; ?>" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
					<span><i class="fa fa-<?php echo $item->MENU_ICON; ?>"></i></span>
					<span><?php echo $item->MENU_NAME; ?></span>
					</a>
					<ul class="collapse list-unstyled" id="<?php echo $item->MENU_NAME; ?>">
						<?php foreach ($sub_menu as $sub_item):?>
							<?php if($item->MENU_ORDER == substr($sub_item->MENU_ORDER, 0, 2)) : ?>
								<li>
									<a href="<?php echo $sub_item->PERMALINK; ?>">
									<span><i class="fa fa-<?php echo $sub_item->MENU_ICON; ?>"></i></span>
									<span><?php echo $sub_item->MENU_NAME; ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
