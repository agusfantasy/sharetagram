app.controller("userRecentController", function($scope, Recent) {
    $scope.recent = new Recent();
});

app.factory('Recent', function($http) {
    var Recent = function() {
        this.items = [];
        this.busy = false;
        this.max_id = '';
    };

    Recent.prototype.nextPage = function() {
        if (this.busy) return;
        this.busy = true;

        var path = window.location.pathname;
        path = path.split("/");

        var url = "/user/recent/" + path[2] + "?max_id=" + this.max_id ;
        $http.get(url).success(function(data) {
            //console.log(data.data);
            var items = data.data;
            for (var i = 0; i < items.length; i++) {
                this.items.push(items[i]);
            }
            this.max_id = data.max_id;
            this.busy = false;
        }.bind(this));
    };

    return Recent;
});