<div ng-app="myApp" ng-controller="userFollowController">

    <div infinite-scroll='follow.nextPage()' infinite-scroll-disabled='follow.busy' infinite-scroll-distance='1'>

        <div class="row">
            <div class="thumb-cont follow">
                <ul class="row list-inline" id="tagsul">
                    <li ng-repeat="item in follow.items">
                        <div class="wrapper">
                            <div class="img" id="img">
                                <a href="/user/{{ item.id }}/{{ item.username }}">
                                    <img class="lazy" src="/images/loading.bax-shop.nl.gif" ng-src="{{ item.profile_picture }}" width="150" height="150" >
                                </a>
                            </div>
                            <div class="name">
                                <a href="/user/{{ item.id }}/{{ item.username }}">
                                    {{ item.username.substr(0,21) }}
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="morebox" >
                    <div ng-show='follow.busy'><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
                </div>
            </div>
        </div>

    </div>

</div>