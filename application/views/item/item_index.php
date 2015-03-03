<div class="item">
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

            <div class="item-time"><?php echo $created_time ?></div>
            <div class="item-location"><?php echo $location ?></div>

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
                <i class="fa fa-heart fa-lg"></i>
                <span id="like-count" class="count" ><b><?php echo $likes->count ?></b> Like</span>
                <div class="row">
                    <ul>
                        <?php foreach ($likes->data as $row): ?>
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

                <span class="comment-sp sprite"></span>
                <div class="count"><b><?php echo $comments->count?></b>  Comment </div>

                <ul>
                    <?php $n = 0; ?>
                    <?php foreach($comments->data as $row): ?>
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

                <?php if ($comments->count > 5): ?>
                    <div class="link-click-all" id="view-comment" > > View All </div>
                <?php endif ?>

            </div>
        </div>
    </div>
	<div class="clr"></div>
</div>

<?php //$this->load->view('my_facebook_js'); ?>