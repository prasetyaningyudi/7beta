<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>
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
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
	
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
	<!--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>	
</head>
<body>