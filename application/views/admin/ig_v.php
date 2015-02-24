<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
footer{
	margin-top:50px;
	text-align:center;
}
</style>
</head>
<body>
	
	<h1><a href="<?php echo base_url()?>">
		<img src="<?php echo base_url();?>images/sharetagram-logo.png">
	</a>Sharetagram CMS</h1>
	<div>
		<a href='<?php echo site_url('admin/ig/info')?>'>Info</a> |
		<a href='<?php echo site_url('admin/ig/contest')?>'>Contest </a> |
		<a href='<?php echo site_url('admin/ig/contest_user')?>'>Contest User</a> |
		<a href='<?php echo site_url('admin/ig/media')?>'>Media </a> |
		<a href='<?php echo site_url('admin/ig/voter')?>'>Voter </a> |
		<a href='<?php echo site_url('admin/ig/user')?>'>User </a> 		
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
	<footer>
		<a title="About Us" href="<?php echo site_url('about')?>"> About Us </a> &nbsp;&nbsp;
		<a title="Privacy Policy" href="<?php echo site_url('privacy')?>">Privacy Policy</a> &nbsp;&nbsp;
		<a title="Terms of Service" href="<?php echo site_url('tos')?>" href="#">Terms of Service</a> &nbsp;&nbsp;
		&copy; <?php echo date("Y") ?> Sharetagram CMS
	</footer>

</body>
</html>
