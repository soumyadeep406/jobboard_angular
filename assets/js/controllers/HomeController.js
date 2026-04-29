app.controller("HomeController", function($scope, JobService, $location){

    $scope.jobs = [];
    $scope.selectedJob = null;

    $scope.search = { skill: "", location: "" };

    $scope.loadJobs = function(){

        JobService.searchJobs($scope.search.skill, $scope.search.location)
        .then(function(res){

            $scope.jobs = res.data.data || [];

            if($scope.jobs.length > 0){
                $scope.selectJob($scope.jobs[0]);
            }
        });
    };

    $scope.selectJob = function(job){

        JobService.getJobDetails(job.job_id)
        .then(res => $scope.selectedJob = res.data);
    };

    $scope.applyJob = function(){
        alert("Login required");
        $location.path("/login");
    };

    $scope.loadJobs();

});