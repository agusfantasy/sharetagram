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
                <img alt="Sharetagram Logo" src="<?php echo base_url()?>images/sharetagram-logo-new-white.png">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a <?php if(ur(1)=='about'){echo "class='active'";} ?> href="<?php echo base_url()?>about">About</a></li>
                <li><a <?php if(ur(1)=='popular'){echo "class='active'";} ?> href="<?php echo base_url()?>popular" >Popular</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <?php
                $value ='';
                if (ur(1)=='search'){
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
            <form class="navbar-form navbar-right">
                <?php
                $user_id = $this->session->userdata('instagram-user-id');
                $user_name = $this->session->userdata('instagram-username');
                ?>
                <?php if(!$this->session->userdata('instagram-user-id')):?>
                    <a href="<?php echo site_url('auth/login');?>?url=<?php echo current_url()?>" class="btn btn-success">
                        <i class="fa fa-instagram fa-fw"></i> &nbsp; Sign in with Instagram
                    </a>
                <?php else: ?>
                    <div class="avatar">
                        <img alt="" src="<?php echo $this->session->userdata('instagram-profile-picture'); ?>">
                    </div>
                    <div style="display:none" class="triagle-up"></div>
                    <div style="display:none" class="ui-tooltip-content" id="profile">
                        <ul>
                            <li><a href="<?php echo site_url("user/$user_id/$user_name") ?>">View Profile</a></li>
                            <li><a href="<?php echo site_url("auth/logout/?url=" . current_url()) ?>">Logout</a></li>
                            <div class="clr"></div>
                        </ul>
                    </div>
                <?php endif; ?>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>