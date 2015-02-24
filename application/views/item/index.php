<div class="item">
    <div class="row">
        <div class="left col-md-8">
            <div class="item-media">
                <div class="item-media-mg"><?php echo $img_video; ?></div>
            </div>
            <div class="item-caption"><?php echo $caption;?></div>
            <div class="item-time"><?php echo $created_time ?></div>
            <div class="item-share">
                <div class="fb-icon-32" id="fb-share"></div>
                <div class="twitter-icon-32" id="twitter-share" alt="Share to Twitter"> </div>
                <div class="gplus-32" onclick="googlePlus()" ></div>
                <div class="tumblr-32" onclick="tumblrShare()"></div>
            </div>
            <div class="clr"></div>
        </div>

        <div class="right col-md-4">

            <div class="user">
                <span class="img"><img alt="<?php echo $username; ?>" src="<?php echo $user_pp; ?>"></span>

                <div class="name">
                    <h4 style="margin:0">
                        <a title="<?php echo $username; ?>"
                           href="<?php echo site_url("user/$user_id/$username") ?>"><?php echo $username; ?></a>
                    </h4>
                    <?php echo $user_fullname ?>
                </div>
                <div class="clr"></div>
            </div>

            <div class="tags">
                <div class="row">
                    <div class="col-md-1">
                        <div class="blue-tag-24"></div>
                    </div>
                    <div class="col-md-10">
                        <ul>
                            <?php foreach($tags as $row): ?>
                                <li><a href='<?php echo site_url("tag/$row")?>'><?php echo $row ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="clr"></div>
            </div>

            <div class="likes">
                <div id="click_like" data-act="" class="icon-like"  ></div>
                <span id="like-count" style="margin-left: 14px; font-size: 16px;"><?php echo $likes_count?> </span> Like
                <div class="row">
                    <ul class="col-md-11 col-md-offset-1">
                        <?php foreach ($likes_data as $row): ?>
                            <li id="<?php echo $row->id; ?>">
                                <a href="<?php echo site_url("user/$row->id/$row->username") ?>">
                                    <?php echo $row->username ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                        <div class="clr"></div>
                    </ul>
                </div>
                <div class="link-click-all" id="view-like" > > View All </div>
                <div class="clr"></div>
            </div>

            <div class="comment">

                <div class="comment-sp" style="float: left; margin-top: 5px;"></div>
                <div style="font-size: 16px; margin-left: 20px;"><?php echo $comments_count?>  Comment </div>

                <ul>
                    <?php $n = 0; ?>
                    <?php foreach($comments_data as $row): ?>
                        <?php  $n++; ?>
                        <?php if ($n<6): ?>
                            <li>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img alt="" width="30" height="auto" src="<?php echo $row->from->profile_picture; ?>">
                                    </div>
                                    <div class="col-md-10">
                                        <div>
                                            <a title="<?php echo $row->from->username; ?>"
                                               href="<?php echo site_url('user/'.$row->from->id.'/'.$row->from->username) ?>">
                                                <?php echo $row->from->username ?>
                                            </a>
                                            <span class="comment-time"><?php echo humanTiming($row->created_time) ?></span>
                                        </div>
                                        <div><?php echo $row->text; ?></div>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>

                <?php if ($comments_count > 5): ?>
                    <div class="link-click-all" id="view-comment" > > View All </div>
                <?php endif ?>

            </div>
        </div>
    </div>
	<div class="clr"></div>
</div>

<?php $this->load->view('my_facebook_js'); ?>