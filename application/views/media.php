<div ng-app="myApp" ng-controller="MediaController">

    <div infinite-scroll='media.nextPage()' infinite-scroll-disabled='media.busy' infinite-scroll-distance='1'>

        <div class="row">
            <div class="thumb-cont follow">
                <ul class="row list-inline" id="tagsul">
                    <li ng-repeat="item in media.items">
                        <div class="wrapper">
                            <div class="img" id="img">
                                <a href="/m/{{ item.id }}">
                                    <img class="lazy" src="/images/loading.bax-shop.nl.gif" ng-src="{{ item.image }}" >
                                    <div class="has-video" style="display: {{ item.has_video }}">
                                        <div class="play"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="field">
                                <div class="photo-time">{{ item.created_time }}</div>
                                <div class="like-comment">
                                    <i id="like" data-media-id="{{ item.id }}"
                                       data-self-id="<?php echo session('ig-id') ?>" data-isliked="{{ item.liked }}"
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
                </div>
            </div>
        </div>

    </div>

</div>