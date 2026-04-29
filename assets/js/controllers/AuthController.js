app.controller("AuthController", function($scope, $location, AuthService) {

    /* ================= INIT ================= */

    $scope.login = {};
    $scope.user = { role: 'job_seeker' }; // default role
    $scope.message = "";

    /* ================= LOGIN ================= */

    $scope.loginUser = function(){

        if (!$scope.login.email || !$scope.login.password) {
            $scope.message = "Please enter email and password";
            return;
        }

        AuthService.login($scope.login)
        .then(function(res){

            if(res.data.status === "success"){

                redirectUser(res.data.role);

            } else {
                $scope.message = res.data.message || "Login failed";
            }

        })
        .catch(function(){
            $scope.message = "Server error. Try again.";
        });
    };

    /* ================= REGISTER ================= */

    $scope.registerUser = function(){

        if (!$scope.user.name || !$scope.user.email || !$scope.user.password) {
            $scope.message = "All fields are required";
            return;
        }

        AuthService.register($scope.user)
        .then(function(res){

            $scope.message = res.data.message;

            if(res.data.status === 'success'){
                alert("Registration successful! Please log in.");
                $location.path('/login');
            }

        })
        .catch(function(){
            $scope.message = "Registration failed. Try again.";
        });
    };

    /* ================= HELPER ================= */

    function redirectUser(role){

        switch(role){
            case "admin":
                $location.path("/admin-dashboard");
                break;

            case "recruiter":
                $location.path("/recruiter-dashboard");
                break;

            default:
                $location.path("/seeker-dashboard");
        }
    }

});