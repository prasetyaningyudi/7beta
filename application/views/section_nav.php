	<div class="header">
		<div class="logo">
			<i class="fa fa-tachometer"></i>
			<span>7Beta</span>
		</div>
		<a href="#" class="nav-trigger"><span></span></a>
	</div>
	<div class="side-nav">
		<div class="logo">
			<i class="fa fa-tachometer"></i>
			<span>7Beta</span>
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
			
<!-- 				<li  class="active">
					<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
						<span><i class="fa fa-user"></i></span>
						<span>Main</span>
					</a>
					<ul class="collapse list-unstyled" id="homeSubmenu">
						<li>
							<a href="http://localhost/7beta/main/insert"><span><i class="fa fa-user"></i></span><span>Insert</span></a>
						</li>
						<li>
							<a href="http://localhost/7beta/main/update"><span><i class="fa fa-user"></i></span><span>Update</span></a>
						</li>
						<li>
							<a href="http://localhost/7beta/main/delete"><span><i class="fa fa-user"></i></span><span>Delete</span></a>
						</li>
					</ul>
				</li> -->
			</ul>
		</nav>
	</div>
