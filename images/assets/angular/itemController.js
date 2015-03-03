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
            $scope.comment_loading = false;
            $scope.comment_data = true;
            $scope.comment_rows = response;

        });
    }
});