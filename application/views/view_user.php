<div ng-app="myApp" ng-controller="userController">

    <div infinite-scroll='user.nextPage()' infinite-scroll-disabled='user.busy' infinite-scroll-distance='1'>

        <div class="row">
            <div class="thumb-cont follow">
                <ul class="row list-inline" id="tagsul">
                    <li ng-repeat="item in user.items">
                        <div class="wrapper">
                            <div class="img" id="img">
                                <a href="/user/{{ item.id }}/{{ item.username }}">
                                    <img class="lazy" src="/static/images/loading.bax-shop.nl.gif" ng-src="{{ item.profile_picture }}" 
                                        width="150" height="150" >
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
                    <div ng-show='user.busy'><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
                </div>
            </div>
        </div>

    </div>

</div>