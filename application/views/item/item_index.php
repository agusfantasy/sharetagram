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
                <i class="fa fa-heart fa-lg"></i>
                <span id="like-count" class="count" ><b><?php echo $likes->count ?></b> Like</span>
                <div ng-hide="like_data" class="row">
                    <ul>
                        <?php foreach ($likes->data as $row): ?>
                            <li id="<?php echo $row->id; ?>">
                                <a href="<?php echo site_url("/user/$row->id/$row->username") ?>">
                                    <?php echo $row->username ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                        <div class="clr"></div>
                    </ul>
                </div>
                <div ng-hide="like_view_all" class="link-click-all" ng-click="likes()" > &gt; VIEW ALL  </div>
                <div ng-show='like_loading'><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
                <div class="row">
                    <ul>
                        <li ng-repeat="row in like_rows">
                            <a href="/user/{{ row.id }}/{{ row.username }}">
                                {{ row.username }}
                            </a>

                        </li>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>

            <div class="comment">

                <span class="comment-sp sprite" style="margin-top: 5px;"></span>
                <span class="count"><b><?php echo $comments->count?></b>  Comment </span>

                <div ng-hide="comment_data">
                    <ul>
                        <?php $n = 0; ?>
                        <?php foreach($comments->data as $row): ?>
                            <?php  $n++; ?>
                            <?php if ($n<6): ?>
                                <li>
                                    <div class="row">
                                        <div class="pull-left">
                                            <img alt="<?php echo $row->from->username ?>" width="30" height="auto" src="<?php echo $row->from->profile_picture; ?>">
                                        </div>
                                        <div class="pull-right" style="width: 88%;">
                                            <span class="pull-left">
                                                <a title="<?php echo $row->from->username; ?>"
                                                   href="<?php echo "/user/{$row->from->id}/{$row->from->username}" ?>">
                                                    <?php echo $row->from->username ?>
                                                </a>
                                            </span>
                                            <span class="comment-time"><?php echo humanTiming($row->created_time) ?></span>
                                            <br>
                                            <?php echo $row->text; ?>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </div>

                <?php if ($comments->count > 5): ?>
                    <div ng-hide="comment_view_all" class="link-click-all" ng-click="comments()" > &gt; VIEW ALL  </div>
                <?php endif ?>

                <div ng-show="comment_loading"><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
                <div class="row">
                    <ul>
                        <li ng-repeat="row in comment_rows">
                            <div class="row">
                                <div class="pull-left">
                                    <img alt="" width="30" height="auto" src="{{ row.from.profile_picture }}">
                                </div>
                                <div class="pull-right" style="width: 88%;">
                                    <span class="pull-left">
                                        <a title="{{ row.from.username }}" href="/user/{{ row.from.id }}/{{ row.from.username }}">
                                            {{ row.from.username }}
                                        </a>
                                    </span>
                                    <span class="comment-time">{{ row.created_time }}</span>
                                    <br>
                                    {{ row.text }}
                                </div>
                            </div>
                            <div class="clr"></div>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
	<div class="clr"></div>
</div>

<?php //$this->load->view('my_facebook_js'); ?>