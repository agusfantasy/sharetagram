<div class="home-banner">
        <h1>Sharetagram is Instagram web viewer </h1>
        <form>
            <div class="form-group" >
                <input class="form-control" id="home-keyword" maxlength="100" type="text" placeholder="Search for users or hastags">
                <button id="home-search-btn">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </form>
        <h2> Share Instagram photo or video to everyone! </h2>
        <p>
            Get your total number of likes received, your most liked photos ever, number of likes and comments per photo,
            your follower and more
        </p>
</div>

<div class="value">

    <div class="row">
        <div class="col-md-12">
            <h1>Instagram made more comfortable</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6sty col-md-2">
            <div class="values-view"></div>
            <p>View photos<br>&amp; videos</p>
        </div>
        <div class="col-xs-6 col-md-2">
            <div class="values-love"></div>
            <p>Like photos<br>&amp; videos</p>
        </div>
        <div class="col-xs-6 col-md-2">
            <div class="values-star"></div>
            <p>Popular photos<br>&amp; videos</p>
        </div>
        <div class="col-xs-6 col-md-2">
            <div class="values-photo-ofyou"></div>
            <p>Photos<br>of You</p>
        </div>
        <div class="col-xs-6 col-md-2">
            <div class="values-follow"></div>
            <p>Follow / Unfollow<br>people</p>
        </div>
    </div>

    <div class="row signin">
        <?php if ($this->session->userdata('instagram-user-id') == '') :  ?>
            <a id="signin_ig" href="<?php echo base_url() . 'auth/login'; ?>?url=<?php echo current_url() ?>"
               class="bouton bt-instagram">
                <i class="fa fa-instagram fa-fw"></i> 
                Sign in with Instagram
            </a>
        <?php endif ?>
    </div>

</div>