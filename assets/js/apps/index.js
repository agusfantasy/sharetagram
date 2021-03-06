
function facebookShare(){
    window.open("https://www.facebook.com/sharer/sharer.php?u="+location.href, "Share instagram on Facebook","width=640,height=320");
}

function twitterShare(){
    window.open("https://twitter.com/share?url="+location.href, "Share on Twitter","width=550,height=520");
}

function googlePlus(){
    window.open('https://plus.google.com/share?url={'+location.href+'}','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
    return false;
}

function tumblrShare(){
    var itemCaption = $(".item-caption").html();
    var itemImg = $(".item-media img").attr("src");

    var photo = encodeURIComponent(itemImg);
    var caption = encodeURIComponent(itemCaption);

    var url = 'http://www.tumblr.com/share/photo?source='+photo+'&caption='+caption;
    window.open(url, 'Share Instagram photo on Tumblr','menubar=no,toolbar=no ,resizable=yes,scrollbars=yes,height=500,width=700');
    return false;
}

function goBack(index){     
    var link = $(index).attr('id');
    if (link=='') {
        if (window.history.length == 1) {
            window.location.assign("/");    
        } else { 
            window.history.back();               
        }
    } else {
        window.location.assign(link); 
    }
}


var responseLike;
function like(mediaId, action) {
    var ajax = $.ajax({
        type: 'post',
        url: '/like',
        data: {media_id: mediaId, action: action},
        dataType: 'json'
    });

    ajax.success(function (response) {

    });
    ajax.error(function (response) {

    });
}

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

    var responseDataLike;
    function isLiked(mediaId, action){

        var ajax = $.ajax({
            type: "post",
            url : "like",
            data : {media_id : media_id,  action : action},
            dataType :'json',
            async : false
        });
        ajax.done(function(response){
            responseDataLike = response.data.success;
        });
        ajax.error(function(){
            responseDataLike = 'error';
        });

        return responseDataLike;
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

    var follow = $("#follow");
	
	var userId = follow.data('user-id'),
        selfId = follow.data('self-id'),
		status = follow.data('rel-status');
	
	if (status == 'following') {
		follow.hover(
			function(){
				$(this).removeClass('btn-success').addClass('btn-danger').text('unfollow');			
			},function(){
				$(this).removeClass('btn-danger').addClass('btn-success').text('following');	
			}
		);
	}
	
    follow.on("click",function(){    
        if (selfId == '') {
            alert('You Should Login.');
        } else {
			if(status=='follow'){
				$(this).removeClass('btn-primary').addClass('btn-success').text('following');
			} else if (status=='following'){
            	$(this).removeClass('btn-success').addClass('btn-primary').text('follow');
			} else {
				return false;				
			}		

			$.ajax({
				url: '/post_follow',
				type: 'post',
				data: {user_id:userId, action:status},
				dataType: 'json',
				success: function(response){
					console.log(response);
				},
				error: function(){
					alert('An error occured');
					if(status=='follow'){
						$(this).removeClass('btn-success').addClass('btn-primary').text('follow');						
					} else if (status=='following'){
						$(this).removeClass('btn-primary').addClass('btn-success').text('following');
					} 
				}				
			});
					
        }
    });

});