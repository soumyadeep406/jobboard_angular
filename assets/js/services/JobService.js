app.service("JobService", function($http){

    this.searchJobs = function(skill, location){
        return $http.get("api/jobs/list.php?skill=" + skill + "&location=" + location);
    };

    this.getJobDetails = function(id){
        return $http.get("api/jobs/details.php?id=" + id);
    };

});
