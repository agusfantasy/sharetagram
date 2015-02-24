$(function () {
    var path = window.location.pathname;
    path = path.split("/");

    var loading = $('#loading');

    //variable tag page
    var moreTag = $("#more-tag");

    //handling autoload
    if (path[1] == 'tag') {
        tagToHtml(path[2]);
    } else if (path[1] == 'user') {
        userRecentToHtml(path[2],'');
    }

    function pressEnter( e ) {
        if (e.keyCode == 13){
            $("#nav-search-btn").click();
        }
    }

    function search( keyword ) {
        if ( keyword ) {
            var fCar = keyword.substr(0,1);
            if(  fCar == '#' ||  fCar == '@' ) {
                keyword =  keyword.replace(fCar,'');
            }
            return BASE_URL + "search/" + keyword;
        }
        return false
    }

    var responseTagData ;
    function getTagData(tag, maxId) {

        var ajaxResp = $.ajax({
            url: '/tag_more',
            type: "get",
            async: false,
            dataType :"json",
            data: { tag: tag, max_id: maxId }
        });
        responseTagData = ajaxResp;

        return  responseTagData;

    }

    function tagToHtml(tag, maxId) {
        var getTag = getTagData(tag, maxId);
        getTag.success( function( response ) {
            if (response.alert == 'fail') {
                alert('Failed. Please try again!');
            } else if (response.alert == 429) {
                alert('Request Limit. Please sign in with instagram!');
            } else {
                var newMaxId = response.pagination.next_max_tag_id;
                moreTag.attr("data-max-id", newMaxId);

                var transform = [{
                    tag: 'li', children: [{
                        tag: 'div', class: 'wrapper', children: [
                            { tag: 'div', class: 'name', html: '<a href="/user/${user_id}/${user_name}"> ${user_name} </a>' },
                            { tag: 'div', class: 'img', id:'img', children: [{
                                tag: 'a', href: '/m/${id}',  children: [{
                                        tag: 'img', class:'lazy', 'src': '${image}'
                                    }]
                                }]
                            },
                            {
                                tag: 'div', class: 'field', children: [
                                    { tag: 'div', class: 'photo-time', html: '${created_time}' },
                                    { tag: 'div', class: 'like-comment', html: '<i class="fa fa-heart fa-fw"></i> ${likes_count} <i class="fa fa-comment fa-fw"></i> ${comments_count}' },
                                    { tag: 'div', class: 'clr'}
                                ]
                            }
                        ]
                    }]
                }];
                loading.hide();
                $("#tagsul").json2html(response.data, transform);
                $("#tagsul").off('keydown');
                moreTag.show();
            }
        });

        getTag.fail(function( jqXHR, textStatus ) {
            alert('Failed. Please try again!');
        });
    }

    var responseUserRecent;
    function getUserRecent(userId, maxId) {

        var ajaxResp = $.ajax({
            url: '/user/recent',
            type: "get",
            async: false,
            dataType :"json",
            data: { user_id: userId, max_id: maxId }
        });
        responseUserRecent = ajaxResp;

        return  responseUserRecent;
    }

    function userRecentToHtml(userId, maxId) {
        var getRecent = getUserRecent(userId, maxId);

        getRecent.success( function( response ) {
            if (response.alert == 'fail') {
                alert('Failed. Please try again');
            } else if (response.alert == 'limit') {
                alert('Request Limit. Please sign in with instagram');
            } else {
                var newMaxId = response.max_id;
                $('#more-user-recent').attr("data-max-id", newMaxId);

                var transform = [{
                    tag: 'li', children: [{
                        tag: 'div', class: 'wrapper', children: [
                            { tag: 'div', class: 'img', id:'img', children: [{
                                tag: 'a', href: '/m/${id}',  children: [{
                                    tag: 'img', class:'lazy', 'src': '${image}'
                                }]
                            }]
                            },
                            {
                                tag: 'div', class: 'field', children: [
                                { tag: 'div', class: 'photo-time', html: '${created_time}' },
                                { tag: 'div', class: 'like-comment', html: '<i class="fa fa-heart fa-fw"></i> ${likes_count} <i class="fa fa-comment fa-fw"></i> ${comments_count}' },
                                { tag: 'div', class: 'clr'}
                            ]
                            }
                        ]
                    }]
                }];
                loading.hide();
                $("#tagsul").json2html(response.data, transform);
                $('#more-user-recent').show();
            }
        });
    }

    //nav
    var navSearchBtn = $("#nav-search-btn");
    navSearchBtn.on("click",function(){
        var keyword =  $("#keyword").val();
        if (search(keyword)) {
            location.assign(search( keyword ));
        }
        return false;
    });

    var avatar = $('#avatar');
    avatar.click(function(){
        $(".triagle-up").toggle();
        $("#profile").toggle();
    });

    //home
    var homeSearchBtn = $("#home-search-btn");
    homeSearchBtn.on("click", function(){
        var keyword =  $("#home-keyword").val();
        if (search(keyword)) {
            location.assign(search(keyword));
        }
        return false;
    });

    /*tag BEGIN*/
    //image
    var imgLazy = $("img.lazy");
    imgLazy.lazyload({
        //event: "sporty",
        effect : "fadeIn",
        bind : "event"
    });

    moreTag.on("click", function() {
        $(this).hide(10, function(){
            loading.show('fast', function(){
                var url = '/tag_more',
                    tag = moreTag.attr( "data-tag" ),
                    maxId = moreTag.attr( "data-max-id" );
                tagToHtml(tag, maxId);
            });
        });
    });
    /*tag END*/

    var moreUserRecent = $('#more-user-recent');
    moreUserRecent.on("click", function(){
        $(this).hide(10, function(){
            loading.show('fast', function(){
                var userId = moreUserRecent.attr( "data-user-id" ),
                    maxId = moreUserRecent.attr( "data-max-id" );
                userRecentToHtml(userId, maxId);
            });
        });
    });

});

/*$(window).bind("load", function() {
    var timeout = setTimeout(function() { $("img.lazy").trigger("sporty") }, 50);
});*/