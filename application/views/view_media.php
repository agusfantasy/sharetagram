<div ng-app="myApp" ng-controller="mediaController">

<h2><?php echo (isset($title)?$title:''); ?></h2>

<div style="display:none" id="endpoint" ><?php echo $endpoint ?></div>
<div style="display:none" id="param" ><?php echo (isset($param)?$param:'') ?></div>

    <div infinite-scroll='media.nextPage()' infinite-scroll-disabled='media.busy' infinite-scroll-distance='1'>

        <div class="row">
            <div class="thumb-cont <?php echo (ur(1)=='user') ? 'follow':'' ?>">
                <ul class="row list-inline" id="tagsul">
                    <li ng-repeat="item in media.items">
                        <div class="wrapper">
                            <div ng-show='media.view_user' class="name">
                                <a href="/user/{{ item.user_id }}/{{ item.user_name }}">
                                    {{ item.user_name }}
                                </a>
                            </div>
                            <div class="img" id="img">
                                <a href="/m/{{ item.id }}">
                                    <img class="lazy" 
                                        src="<?php echo img_path()?>loading.bax-shop.nl.gif" 
                                        ng-src="{{ item.image }}" >

                                    <div class="has-video" style="display: {{ item.has_video }}">
                                        <div class="play"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="field">
                                <div class="photo-time">{{ item.created_time }}</div>
                                <div class="like-comment">
                                    <i  ng-click="like()"  id="like" data-media-id="{{ item.id }}"
                                       data-self-id="<?php echo session('ig_id') ?>" data-isliked="{{ item.liked }}"
                                       class="fa fa-heart fa-fw" style="{{ item.like_colour }}"></i>
                                    {{ item.likes_count }}
                                    <i class="fa fa-comment fa-fw"></i> {{ item.comments_count }}
                                </div>
                                <div class="clr"></div>
                            </div>

                        </div>
                    </li>
                </ul>
                <div class="morebox" >
                    <div ng-show='media.busy'><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
                    <div ng-show="media.more_btn"><button class="btn btn-default">Load More</button></div>
                </div>
            </div>
        </div>

    </div>

</div>