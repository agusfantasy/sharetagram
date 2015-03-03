app.controller("userTagController", function($scope, Tag) {
    $scope.tag = new Tag();
});

app.factory('Tag', function($http) {
    var Tag = function() {
        this.items = [];
        this.busy = false;
        this.max_id = '';
    };

    Tag.prototype.nextPage = function() {
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
            this.max_id = data.max_id;
            this.busy = false;
        }.bind(this));
    };

    return Tag;
});