var app = angular.module("myApp", ['infinite-scroll', 'ngSanitize']);

var path = window.location.pathname;
path = path.split("/");
