app.controller("itemController", function($scope, $http) {
    var path = window.location.pathname;
    path = path.split("/");

    $scope.likes = function() {
        var url = "/likes_media/"+path[2];
        $scope.like_loading = true;
        $scope.like_view_all = true;
        $http.get(url).success(function(response){
            $scope.like_loading = false;
            $scope.like_data = true;
            $scope.like_rows = response;

        });
    }

    $scope.comments = function() {
        var url = "/comments_media/"+path[2];
        $scope.comment_loading = true;
        $scope.comment_view_all = true;
        $http.get(url).success(function(response){
            for(var i=0; i < response.length ; i++) {
                response[i].text = emojione.unicodeToImage(response[i].text);
            }
            $scope.comment_loading = false;
            $scope.comment_data = true;
            $scope.comment_rows = response;
        });
    }

    $scope.isLiked = function(){

        var likeElem = angular.element($('#like'));
        var likeCountElem = angular.element($('#like-count'));

        var count = parseInt(likeCountElem.text(), 10);
        if ( likeElem.data('self-id') == '') {
            alert('Please sign in with Instagram');
        } else {
            var action = '';
            if (!likeElem.data('status')) {
                likeElem.addClass('liked').data('status', true);
                likeCountElem.text(count + 1);
                action = 'like';
            } else {
                likeElem.removeClass('liked').data('status', false);
                likeCountElem.text(count - 1);
                action = 'unlike';
            }

            var url = '/like';
            $http.post(url, {media_id: path[2], action: action}).
                success(function (response) {
                }).
                error(function (response) {
                    if (!likeElem.data('status')) {
                        likeElem.removeClass('liked').data('status', false);
                    } else {
                        likeElem.addClass('liked').data('status', true);
                    }
                });
        }
    }
});