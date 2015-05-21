<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container" style="padding: 10px;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="nav-brand" href="<?php echo base_url()?>" title="Sharetagram">
                <img alt="Sharetagram Logo" src="<?php echo img_path() ?>sharetagram-logo-new-white.png">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a <?php if(ur(1)=='about'){echo "class='active'";} ?> href="<?php echo base_url()?>about">About</a></li>
                <li><a <?php if(ur(1)=='popular'){echo "class='active'";} ?> href="/popular" >Popular</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <?php
                $value ='';
                if (ur(1)=='search') {
                    $value = urldecode(ur(2));
                }

                ?>
                <div class="form-group has-feedback">
                    <input maxlength="100" type="text" name="keyword"
                           class="form-control" id="keyword"
                           value="<?php echo isset($value)?$value:"";?>" onkeypress="return pressEnter(event)" placeholder="Search for users or hastags">
                    <button id="nav-search-btn" class="nav-search-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </form>
			
			<?php
				$user_id = session('ig_id');
				$user_name = session('ig_username');
			?>
			
			<?php if($user_id==''):?>
				<form class="navbar-form navbar-right">
					<a href="/auth/login/?url=<?php echo current_url()?>" class="btn btn-success">
						<i class="fa fa-instagram fa-fw"></i> &nbsp; Sign in with Instagram
					</a>				
				</form>
			<?php else: ?>
				<ul class="nav navbar-nav navbar-right">						
					<li class="dropdown">	
						<a href="#" class="dropdown-toggle" 
							data-toggle="dropdown" role="button" aria-expanded="false" style="padding: 0;" >
							<img width="50" height="auto" alt="" src="<?php echo session('ig_avatar'); ?>"> 
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo "/user/$user_id/$user_name" ?>" >My Profile</a></li>
							<li><a href="<?php echo "/auth/logout/?url=". current_url() ?>">Logout</a></li>
						</ul>
					</li>
				</ul>
            <?php endif; ?>           
        </div><!--/.navbar-collapse -->
    </div>
</nav>
