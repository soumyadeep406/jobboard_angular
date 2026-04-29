app.controller("RecruiterController", function($scope, $http, $location){

    $scope.company = {};
    $scope.job = { skills: "" };
    $scope.jobs = [];
    $scope.applications = [];

    /* ================= COMPANY ================= */

    $scope.saveCompany = function(){
        $http.post("api/recruiter/company.php", $scope.company)
        .then(res => alert(res.data.message))
        .catch(() => alert("Error saving company"));
    };

    /* ================= JOB ================= */

    $scope.postJob = function(){

        let data = angular.copy($scope.job);

        if(typeof data.skills === 'string'){
            data.skills = data.skills.split(",").map(s => s.trim());
        }

        $http.post("api/jobs/add.php", data)
        .then(function(res){

            alert(res.data.message);

            if(res.data.status === 'success'){
                $scope.job = { skills: "" };
                $location.path('/recruiter-dashboard');
            }

        }).catch(() => alert("Error posting job"));
    };

    $scope.loadJobs = function(){
        $http.get("api/recruiter/jobs.php")
        .then(res => $scope.jobs = res.data.data || []);
    };

    /* ================= APPLICATION ================= */

    $scope.viewApplications = function(job_id){
        $http.get("api/recruiter/applications.php?job_id=" + job_id)
        .then(res => $scope.applications = res.data.data || []);
    };

    $scope.approveApplication = function(app_id){

        $http.post("api/recruiter/approve.php", { app_id })
        .then(function(res){

            if(res.data.status === "success"){
                updateStatus(app_id, "approved");
                alert("Approved!");
            }

        }).catch(() => alert("Error"));
    };

    $scope.rejectApplication = function(app_id){

        $http.post("api/recruiter/reject.php", { app_id })
        .then(function(res){

            if(res.data.status === "success"){
                updateStatus(app_id, "rejected");
                alert("Rejected!");
            }

        }).catch(() => alert("Error"));
    };

    // Helper
    function updateStatus(id, status){
        $scope.applications.forEach(app => {
            if(app.app_id === id) app.status = status;
        });
    }

    /* ================= INIT ================= */

    if(['/recruiter-dashboard','/applications'].includes($location.path())){
        $scope.loadJobs();
    }

});