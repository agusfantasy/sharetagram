app.controller("TagController", function($scope, Tag) {
    $scope.tag = new Tag();
    $scope.like = function($http){

        var id = this.$index;
        var recentItem = $scope.tag.items[id];

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

app.factory('Tag', function($http) {
    var Tag = function() {
        this.items = [];
        this.busy = false;
        this.max_id = '';
        this.count = 0;
    };

    Tag.prototype.nextPage = function() {
        this.count = this.count + 1;
        if (this.count  !== 1 && this.max_id == undefined) return;

        if (this.busy) return;
        this.busy = true;

        var path = window.location.pathname;
        path = path.split("/");

        var url = "/tag_more/" + path[2] + "?max_id=" + this.max_id ;
        $http.get(url).success(function(data) {
            var items = data.data;
            for (var i = 0; i < items.length; i++) {
                this.items.push(items[i]);
            }
            this.max_id = data.pagination.next_max_tag_id;
            this.busy = false;
        }.bind(this));
    };

    return Tag;
});