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

        // route for a person page
        .when('/person/:id', {
            templateUrl : 'pages/person.html',
            controller  : 'personController'
        })

        // route for a person edit page
        .when('/person/:id/edit', {
            templateUrl : 'pages/editperson.html',
            controller  : 'personEditController'
        })

        // route for a tree page
        .when('/tree/:id', {
            templateUrl : 'pages/tree.html',
            controller  : 'treeController'
        })

        // route for a tree person addition page
        .when('/tree/:id/create', {
            templateUrl : 'pages/editperson.html',
            controller  : 'personCreateController'
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

tooApp.controller('treeController', function($scope, $http, $routeParams) {
    $http.get("api/v1/tree/"+$routeParams.id)
    .then(function(response) {
        $scope.tree = response.data;
    });
});

tooApp.controller('personCreateController', function($scope, $http, $routeParams, $location) {
    $http.get("api/v1/tree/"+$routeParams.id)
    .then(function(response) {
        $scope.tree_id = response.data.id;
    });
    $http.get("api/v1/gender")
    .then(function(response) {
        $scope.genders = response.data;
    });
    $http.get("api/v1/person")
    .then(function(response) {
        $scope.people = response.data;
    });
    
    $scope.submit = function () {
        var data = {
            'tree_id': $scope.tree_id,
            'name': $scope.fullname,
            'birth': $scope.birth,
            'death': $scope.death,
            'gender_id': $scope.gender,
            'mother_id': $scope.mother,
            'father_id': $scope.father,
            'notes': $scope.notes
        };
        $http.post("api/v1/person", data)
        .then(function success(response) {
            $location.path("/person/"+response.data.id);
        }, function failure(response) {
            //
        });
    };
});

tooApp.controller('personEditController', function($scope, $http, $routeParams, $location) {
    $http.get("api/v1/person/"+$routeParams.id)
    .then(function(response) {
        $scope.person = response.data;
        $scope.tree_id = $scope.person.tree_id;
    
        $scope.fullname = $scope.person.name;
        $scope.birth = $scope.person.birth;
        $scope.death = $scope.person.death;
        $scope.notes = $scope.person.notes;

        $http.get("api/v1/gender")
        .then(function(response) {
            $scope.genders = response.data;
            $scope.gender = $scope.person.gender_id;
        });
        $http.get("api/v1/person")
        .then(function(response) {
            $scope.people = response.data;
            $scope.mother = $scope.person.mother.id;
            $scope.father = $scope.person.father.id;
        });
    });
    
    $scope.submit = function () {
        var data = {
            'tree_id': $scope.tree_id,
            'name': $scope.fullname,
            'birth': $scope.birth,
            'death': $scope.death,
            'gender_id': $scope.gender,
            'mother_id': $scope.mother,
            'father_id': $scope.father,
            'notes': $scope.notes
        };
        $http.put("api/v1/person/"+ $scope.person.id, data)
        .then(function success(response) {
            $location.path("/person/"+response.data.id);
        }, function failure(response) {
            //
        });
    };
});
