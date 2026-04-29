var app = angular.module("jobApp", ["ngRoute"]);

app.run(function($rootScope, $location, AuthService) {
    $rootScope.$on("$routeChangeStart", function(event, next, current) {
        var nextPath = next.originalPath; 
        var loggedIn = AuthService.isLoggedIn();

        if (nextPath && nextPath.includes('dashboard') && !loggedIn) {
            $location.path("/login");
        }
    });
});


// ================= FILE MODEL DIRECTIVE =================
app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            element.bind('change', function () {
                scope.$apply(function () {
                    model.assign(scope, element[0].files[0]);
                });
            });
        }
    };
}]);