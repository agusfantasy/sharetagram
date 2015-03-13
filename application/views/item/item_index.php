<div class="item"  ng-app="myApp" ng-controller="itemController">
    <div class="row">
        <div class="left col-md-8">
            <div class="item-media">
                <div class="item-media-mg">
                    <?php if ($type == 'image') : ?>
                        <img class="img-responsive" src="<?php echo $media->data->images->standard_resolution->url?>">
                    <?php else : ?>
                        <video controls>
                            <source src="<?php echo $media->data->videos->standard_resolution->url ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif ?>
                </div>
            </div>

            <div class="item-caption"><?php echo $caption ?></div>

            <div class="item-time pull-left" > <i class="fa fa-calendar fa-fw"></i> <?php echo $created_time ?> </div>

            <div class="item-share pull-right">
                <div class="fb-icon-32" onclick="facebookShare()" ></div>
                <div class="twitter-icon-32" onclick="twitterShare()" > </div>
                <div class="gplus-32" onclick="googlePlus()" ></div>
                <div class="tumblr-32" onclick="tumblrShare()"></div>
            </div>

            <div class="clr"></div>
        </div>

        <div class="right col-md-4">
            <div class="user">
                <span class="img">
                    <img alt="<?php echo $user->username; ?>"
                         src="<?php echo $user->profile_picture ?>">
                </span>

                <div class="name">
                    <h4 style="margin:0">
                        <a title="<?php echo $user->username; ?>"
                           href="<?php echo site_url("user/$user->id/$user->username") ?>"><?php echo $user->username; ?></a>
                    </h4>
                    <?php echo $user->full_name ?>
                </div>
                <div class="clr"></div>
            </div>

            <div class="tags">
                <div class="row">
                    <span class="blue-tag-24 sprite"></span>
                    <ul>
                        <?php foreach($tags as $k => $row): ?>
                            <li><a href='<?php echo site_url("tag/$row")?>'><?php echo $row ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>

            <div class="likes">
                <?php $this->load->view('item/item_likes'); ?>
            </div>

            <div class="comment">
                <?php $this->load->view('item/item_comments'); ?>  
            </div>
        </div>
    </div>
	<div class="clr"></div>
</div>

<?php //$this->load->view('my_facebook_js'); ?>