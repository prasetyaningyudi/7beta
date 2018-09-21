<div class="main-content">
	<div class="title">
		Analytics
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
				<div class="container-fluid mt-4">