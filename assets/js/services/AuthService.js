app.service("AuthService", function($http, $window) {

    this.login = function(data){
        return $http.post("api/auth/login.php", data).then(function(res){
            if(res.data.status === 'success'){
                // Save the role (e.g., 'recruiter') to browser storage
                $window.localStorage.setItem('user_role', res.data.role);
                $window.localStorage.setItem('user_id', res.data.user_id);
            }
            return res;
        });
    };

    this.register = function(data){
        return $http.post("api/auth/register.php", data);
    };

    this.logout = function(){
        $window.localStorage.removeItem('user_role');
        $window.localStorage.removeItem('user_id');
        return $http.get("api/auth/logout.php");
    };

    this.isLoggedIn = function(){
        return !!$window.localStorage.getItem('user_role');
    };

    // --- THIS IS THE MISSING PART ---
    this.getRole = function(){
        return $window.localStorage.getItem('user_role');
    };
});