<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo (isset($title)) ? $title :"Inventory System for Akmatro." ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="<?php echo base_url(); ?>my-assets/js/admin_js/jquery-2.0.0.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>my-assets/js/admin_js/jquery-ui-1.9.1.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>my-assets/js/admin_js/jquery-calculation.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>my-assets/js/admin_js/jquery.validate.min.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>my-assets/js/admin_js/jquery-ui-1.9.1.custom/css/smoothness/jquery-ui.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>my-assets/css/admin_css/admin_template.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/ico/favicon.png">
</head>
<body>
	<div class="container" style="min-height:550px;">
		<?php $this->load->view('include/admin_header')?>
			{msg_content}
			{content}
	</div><!-- end div #wrapper -->	
	<?php $this->load->view('include/admin_footer') ?>
	 <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>my-assets/js/admin_js/all_customized_ajax.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>my-assets/js/admin_js/others.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jqBootstrapValidation.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-tooltip.js"></script>
	
</body>
</html>