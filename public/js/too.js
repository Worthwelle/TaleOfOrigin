// create the module and name it tooApp
var tooApp = angular.module('TaleOfOriginAJS', ['ngRoute', 'ngSanitize']);

// create the controller and inject Angular's $scope
tooApp.config(function($routeProvider) {
    $routeProvider

        // route for the home page
        .when('/', {
            templateUrl : 'pages/home.html',
            controller  : 'mainController'
        })

        // route for the about page
        .when('/person/create', {
            templateUrl : 'pages/editperson.html',
            controller  : 'personCreateController'
        })

        // route for the about page
        .when('/person/:id', {
            templateUrl : 'pages/person.html',
            controller  : 'personController'
        })

        // route for the about page
        .when('/tree/:id', {
            templateUrl : 'pages/tree.html',
            controller  : 'treeController'
        })
});

// create the controller and inject Angular's $scope
tooApp.controller('mainController', function($scope, $http) {
    $http.get("api/v1/trees/1")
    .then(function(response) {
        $scope.trees = response.data;
    });
});

tooApp.controller('personController', function($scope, $http, $routeParams) {
    $http.get("api/v1/person/"+$routeParams.id)
    .then(function(response) {
        $scope.person = response.data;
    });
});

tooApp.controller('personCreateController', function($scope) {
    
});

tooApp.controller('treeController', function($scope, $http, $routeParams) {
    $http.get("api/v1/tree/"+$routeParams.id)
    .then(function(response) {
        $scope.tree = response.data;
    });
});