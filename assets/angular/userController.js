app.controller("userController", function($scope, User) {
    $scope.user = new User();
});

app.factory('User', function($http) {
    var User = function() {
        this.endpoint = path[4];
        this.user_id  = path[2];
        this.items = [];
        this.busy = false;
        this.next_cursor = '';
        this.count = 0;
    };

    User.prototype.nextPage = function() {
        this.count = this.count + 1;
        if (this.count  !== 1 && this.next_cursor == '') return;

        if (this.busy) return;
        this.busy = true;

        var url = "/user_collection?endpoint=" + this.endpoint + "&user_id=" + this.user_id + "&next_cursor=" + this.next_cursor;
        $http.get(url).success(function(data) {
            if (data.code !== 200) {
                this.more_btn = true;                  
                this.busy = false; 
            } else {
                var items = data.data;
                for (var i = 0; i < items.length; i++) {
                    this.items.push(items[i]);
                }
                this.next_cursor = data.next_cursor;
                this.busy = false;
            }

        }.bind(this));
    };

    return User;
});