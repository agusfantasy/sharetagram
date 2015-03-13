app.controller("mediaController", function($scope, Media) {
    $scope.media = new Media();
});

app.factory('Media', function($http) {
    var Media = function() {
        this.endpoint = '';
        this.items = [];
        this.busy = false;
        this.max_id = '';
        this.user_id = '';
    };

    Media.prototype.nextPage = function() {
        if (this.busy) return;
        this.busy = true;

        var path = window.location.pathname;
        path = path.split("/");

        var url = "/media/?endpoint=" + this.endpoint + "&max_id=" + this.max_id  + "&user_id=" + this.user_id;
        $http.get(url).success(function(data) {
            var items = data.data;
            for (var i = 0; i < items.length; i++) {
                this.items.push(items[i]);
            }
            this.max_id = data.max_id;
            this.busy = false;
        }.bind(this));
    };

    return Media;
});