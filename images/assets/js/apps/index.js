$(function () {
    var loading = $('#loading');

    function pressEnter( e ) {
        if (e.keyCode == 13){
            $("#nav-search-btn").click();
        }
    }

    function search( keyword ) {
        console.log(keyword);
        if ( keyword ) {
            var fCar = keyword.substr(0,1);
            if(  fCar == '#' ||  fCar == '@' ) {
                keyword =  keyword.replace(fCar,'');
            }
            return "/search/" + keyword;
        }
        return false
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
    
    //image
    var imgLazy = $("img.lazy");
    imgLazy.lazyload({
        effect : "fadeIn",
        bind : "event"
    });

});