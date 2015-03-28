app.controller("userRecentController", function($scope, $http, Recent) {
    $scope.recent = new Recent();
    $scope.like = function(){

        var id = this.$index;
        var recentItem = $scope.recent.items[id];

        if ($scope.recent.self_id=='') {
            alert('Please Sign in with Instagram!');
        } else {
            var action = '';
            if (!recentItem.liked) {
                action = 'like';
                recentItem.liked = true;
                recentItem.like_class = 'liked';
                recentItem.likes_count = parseInt(recentItem.likes_count,10) + 1 ;
            } else {
                action = 'unlike';
                recentItem.liked = false;
                recentItem.like_class = '';
                recentItem.likes_count = parseInt(recentItem.likes_count,10) - 1 ;
            }

            $http.post('/like', {media_id:  recentItem.id , action: action}).
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

app.factory('Recent', function($http) {
    var Recent = function() {
        this.items = [];
        this.busy = false;
        this.max_id = '';
        this.count = 0;
        this.more_btn = false;
    };

    Recent.prototype.nextPage = function() {
        this.count = this.count + 1;
        if (this.count  !== 1 && this.max_id == '') return;

        if (this.busy) return;
        this.busy = true;


        var urlRecent = "/user/recent/" + path[2] ;

        var req = {
            method: 'GET',
            url: urlRecent,
            headers: {
                'Content-Type': 'application/json',
            },
            cache : true,
            params: { max_id: this.max_id }
        };    

        $http(req).
        success(function(data) {
            if (data.alert =='fail' || data.alert =='limit' ||  data.alert == 'retry') {
                this.more_btn = true;                  
                this.busy = false; 
            } else {
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

    return Recent;
});