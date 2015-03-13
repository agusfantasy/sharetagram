<div ng-app="myApp" ng-controller="TagController">

    <div infinite-scroll='tag.nextPage()' infinite-scroll-disabled='tag.busy' infinite-scroll-distance='1'>
        <div class="thumb-cont">
            <h2><?php echo $title ?></h2>

            <ul class="row list-inline" id="tagsul">
                <li ng-repeat="item in tag.items">
                    <div class="wrapper">

                        <div class="name">
                            <a href="/user/{{ item.user_id }}/{{ item.user_name }}">
                                {{ item.user_name }}
                            </a>
                        </div>

                        <div class="img" id="img">
                            <a href="/m/{{ item.id }}">
                                <img class="lazy" src="/images/loading.bax-shop.nl.gif" ng-src="{{ item.image }}">

                                <div class="has-video" style="display: {{ item.has_video }}">
                                    <div class="play"></div>
                                </div>
                            </a>
                        </div>

                        <div class="field">
                            <div class="photo-time">{{ item.created_time }}</div>
                            <div class="like-comment">
                                <i ng-click="like()" class="fa fa-heart fa-fw {{ item.like_class }}"></i>{{ item.likes_count }}
                                <i class="fa fa-comment fa-fw"></i> {{ item.comments_count }}
                            </div>
                            <div class="clr"></div>
                        </div>

                    </div>
                </li>
            </ul>

            <div class="morebox">
                <div ng-show='tag.busy'><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
            </div>
        </div>
    </div>

</div>