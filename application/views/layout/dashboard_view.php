<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo isset($meta_title)?$meta_title:""?></title>

    <meta name="description" content="<?php echo isset($meta_description)?$meta_description:""?>" />
	<meta name="keywords" content="<?php echo  isset($meta_keyword)?$meta_keyword:"" ?>" />

	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="http://images.ak.instagram.com">
	<link rel="dns-prefetch" href="<?php echo base_url()?>static/images">

	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@sharetagram">
	<meta name="twitter:creator" content="@agusfantasy">

	<?php $fb = fb();$fb_id = $fb['id']; ?>
	<meta property="fb:app_id" content="<?php echo $fb_id; ?>" />
	<meta property="og:type"   content="sharetagram:website" />
	<meta property="og:url"    content="<?php echo current_url()?>" />
	<meta property="og:site_name" content="Sharetagram">
	<meta property="og:title" content="<?php echo isset($meta_title)?$meta_title:""?>">
	<meta property="og:description" content="<?php echo isset($meta_description)?$meta_description:""?>">
	<meta property="og:image"  content="<?php echo isset($meta_image)?$meta_image:""?>" />

	<?php $this->load->view('ga')?>

	<link rel="shortcut icon" href="<?php echo img_url()?>sharetagram.ico"/>

	<link rel="canonical" href="<?php echo current_url()?>"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <link href="<?php echo asset_path() ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="//cdn.jsdelivr.net/emojione/1.3.0/assets/css/emojione.min.css" />
    
	<?php if (ENVIRONMENT == 'production'): ?>
		<link href="<?php echo asset_path(); ?>css/style.min.css" rel="stylesheet" type="text/css" />
		<?php else: ?>
		<link href="<?php echo asset_path(); ?>css/style.css" rel="stylesheet" type="text/css" />
	<?php endif ?>
</head>

<body>
	<header><?php $this->load->view('layout/header_view');?></header>

	<?php
	$style = '';
	if (empty(ur(1))) {
		$container = 'home-container';
	} else {
		$container = 'page-container';
        if (session('ig-token') != '') {
            $style = 'style="padding-top:0;margin-top:10px;"';
			$this->load->view('user/user_self_header');
		}
	}
	?>

	<div <?php  echo $style; ?> class="<?php  echo $container;?>">
		<?php $this->load->view($content); ?>
	</div>
	
	<div class="clr"></div>
	
	<footer><?php $this->load->view('layout/footer_view'); ?></footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo asset_path(); ?>jquery_validation/dist/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?php echo asset_path(); ?>jquery-lazyload/jquery.lazyload.min.js"></script>

    <script src="//cdn.jsdelivr.net/emojione/1.3.0/lib/js/emojione.min.js"></script>

    <script src="<?php echo asset_path(); ?>js/apps/config.js"></script>
    <script src="<?php echo asset_path(); ?>js/apps/index.js"></script>

    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
    <script src="<?php echo asset_path(); ?>angular/module/ng-infinite-scroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular-sanitize.min.js"></script>

    <script src="<?php echo asset_path(); ?>angular/myApp.js"></script>
    <script src="<?php echo asset_path(); ?>angular/itemController.js"></script>
    <script src="<?php echo asset_path(); ?>angular/mediaController.js"></script>
    <script src="<?php echo asset_path(); ?>angular/userController.js"></script>
</body>
</html>