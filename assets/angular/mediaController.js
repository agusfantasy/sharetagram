app.controller("mediaController", function($scope, Media) {
    $scope.media = new Media();
    $scope.like = function($http){

        var id = this.$index;
        var recentItem = $scope.media.items[id];

        if (!recentItem.selfId) {
            alert('Please Sign in with Instagram!');
        } else {
            var action = '';
            if (!recentItem.liked) {
                action = 'like';
                recentItem.liked = true;
                recentItem.like_class = 'liked';
                recentItem.likes_count = parseInt(recentItem.likes_count, 10) + 1;
            } else {
                action = 'unlike';
                recentItem.liked = false;
                recentItem.like_class = '';
                recentItem.likes_count = parseInt(recentItem.likes_count, 10) - 1;
            }

            $http.post('/like', {media_id: recentItem.id, action: action}).
                success(function (response) {
                    console.log(response);
                }).
                error(function (response) {
                    alert('An error occured. Please try again!');
                    if (!recentItem.liked) {
                        action = 'unlike';
                        recentItem.liked = false;
                        recentItem.like_class = '';
                        recentItem.likes_count = parseInt(recentItem.likes_count, 10) - 1;
                    } else {
                        action = 'like';
                        recentItem.liked = true;
                        recentItem.like_class = 'liked';
                        recentItem.likes_count = parseInt(recentItem.likes_count, 10) + 1;
                    }
                });
        }
    }
});

app.factory('Media', function($http) {
    var Media = function() {
        this.endpoint = $("#endpoint").text();
        this.param  = $("#param").text();
        this.items = [];
        this.busy = false;
        this.max_id = '';
        this.count = 0;
        this.view_user = false;
    };

    Media.prototype.nextPage = function() {
        this.count = this.count + 1;
        if (this.count  !== 1 && this.max_id == '') return;
        
        if (this.busy) return;
        this.busy = true;

        var path = window.location.pathname;
        path = path.split("/");

        var url = "/media?endpoint=" + this.endpoint + "&param=" + this.param + "&max_id=" + this.max_id;
        $http.get(url).
        success(function(data) {
            if (data.code !== 200) {
                this.more_btn = true;                  
                this.busy = false; 
            } else {
                this.view_user = data.view_user;
                var items = data.data;
                for (var i = 0; i < items.length; i++) {
                    this.items.push(items[i]);
                }
                this.max_id = data.max_id;
                this.busy = false;
            }
        }.bind(this)).
        error(function(data, status, headers, config) {            
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            this.busy = false;    
            this.more_btn = true;
        });
    };

    return Media;
});
