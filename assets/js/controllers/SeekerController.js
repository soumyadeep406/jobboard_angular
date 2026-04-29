app.controller("SeekerController", function ($scope, $http, $sce) {

    /* ================= PROFILE ================= */

    $scope.profile = {};
    $scope.appliedJobs = [];
    $scope.savedJobs = [];
    $scope.resumeFile = null;

    // Load Profile
    $scope.loadProfile = function () {
        $http.get("api/seeker/profile.php")
        .then(function(res){

            if (res.data.status === "success") {
                $scope.profile = res.data.data;

                if ($scope.profile.resume) {
                    $scope.profile.resumeSafe =
                        $sce.trustAsResourceUrl($scope.profile.resume);
                }
            }

        }).catch(function(){
            alert("Failed to load profile.");
        });
    };

    // Update Profile
    $scope.updateProfile = function () {
        $http.post("api/seeker/profile.php", $scope.profile)
        .then(function(res){
            alert(res.data.message || "Profile updated!");
        }).catch(function(){
            alert("Server error while updating profile.");
        });
    };

    /* ================= RESUME ================= */

    $scope.uploadResume = function () {

        if (!$scope.resumeFile) {
            return alert("Select a resume first.");
        }

        let fd = new FormData();
        fd.append("resume", $scope.resumeFile);
        fd.append("user_id", $scope.profile.user_id);

        $http.post("api/seeker/upload_resume.php", fd, {
            transformRequest: angular.identity,
            headers: { "Content-Type": undefined }
        })
        .then(function(res){

            if (res.data.status === "success") {

                $scope.profile.resume = res.data.path;
                $scope.profile.resumeSafe =
                    $sce.trustAsResourceUrl(res.data.path);

                alert("Resume uploaded!");

            } else {
                alert(res.data.message);
            }

        }).catch(function(){
            alert("Upload failed.");
        });
    };

    $scope.deleteResume = function () {

        if (!confirm("Delete resume?")) return;

        $http.post("api/seeker/delete_resume.php", {
            user_id: $scope.profile.user_id
        })
        .then(function(res){

            if(res.data.status === "success"){
                $scope.profile.resume = null;
                $scope.profile.resumeSafe = null;
                alert("Deleted!");
            } else {
                alert(res.data.message);
            }

        }).catch(function(){
            alert("Delete failed.");
        });
    };

    /* ================= JOB DATA ================= */

    $scope.loadAppliedJobs = function () {
        $http.get("api/seeker/applied-jobs.php")
        .then(res => $scope.appliedJobs = res.data.data || []);
    };

    $scope.loadSavedJobs = function () {
        $http.get("api/seeker/saved-jobs.php")
        .then(res => $scope.savedJobs = res.data.data || []);
    };

    /* ================= INIT ================= */

    $scope.loadProfile();
    $scope.loadAppliedJobs();
    $scope.loadSavedJobs();

});