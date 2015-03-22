app.controller("userFollowController", function($scope, Follow) {
    $scope.follow = new Follow();
});

app.factory('Follow', function($http) {
    var Follow = function() {
        this.items = [];
        this.busy = false;
        this.cursor = '';
        this.count = 0;
    };

    Follow.prototype.nextPage = function() {
        this.count = this.count + 1;
        if (this.count  !== 1 && this.cursor == '') return;

        if (this.busy) return;
        this.busy = true;

        var path = window.location.pathname;
        path = path.split("/");

        var url = "/" + path[4] + "/" + path[2] +"?next_cursor="+ this.cursor;
        $http.get(url).success(function(data) {
            //console.log(data.data);
            var items = data.data;
            for (var i = 0; i < items.length; i++) {
                this.items.push(items[i]);
            }
            this.cursor = data.next_cursor;
            this.busy = false;
        }.bind(this));
    };

    return Follow;
});