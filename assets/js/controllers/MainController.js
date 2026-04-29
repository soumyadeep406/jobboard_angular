app.controller("MainController", function($scope, $location, AuthService) {

    $scope.isLoggedIn = () => AuthService.isLoggedIn();

    $scope.getDashboardLink = function() {
        const role = AuthService.getRole();

        if(role === 'admin') return '#!/admin-dashboard';
        if(role === 'recruiter') return '#!/recruiter-dashboard';
        return '#!/seeker-dashboard';
    };

    $scope.logout = function() {
        AuthService.logout().then(function() {
            $location.path('/login');
            window.location.reload();
        });
    };

    $scope.isActive = path => path === $location.path();

});