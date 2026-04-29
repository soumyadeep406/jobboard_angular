app.controller("JobController", function ($scope, $http, AuthService) {

    $scope.jobs = [];
    $scope.selectedJob = null;

    $scope.search = { skill: "", location: "" };

    $scope.currentPage = 1;
    $scope.totalPages = 1;

    const role = AuthService.getRole();
    $scope.userRole = role ? role.toLowerCase() : '';
    console.log("User Role:", $scope.userRole);

    $scope.isJobSeeker = () => {
    return $scope.userRole === 'job_seeker';
};

    /* ================= LOAD ================= */

    $scope.loadJobs = function (page = 1) {

        let url = `api/jobs/list.php?page=${page}&skill=${$scope.search.skill}&location=${$scope.search.location}`;

        $http.get(url).then(function (res) {

            if (res.data.status === "success") {

                $scope.jobs = res.data.data;
                $scope.totalPages = res.data.totalPages;
                $scope.currentPage = res.data.currentPage;

                $scope.selectedJob = $scope.jobs[0] || null;
            }
        });
    };

    /* ================= ACTIONS ================= */

    $scope.selectJob = job => $scope.selectedJob = job;

    $scope.applyJob = function () {

        if (!$scope.isJobSeeker()) return alert("Only job seekers allowed");

        $http.post("api/jobs/apply.php", {
            job_id: $scope.selectedJob.job_id
        }).then(res => alert(res.data.message));
    };

   $scope.toggleSaveJob = function (job) {

    if (!$scope.isJobSeeker())
        return alert("Only job seekers allowed");

    $http.post("api/seeker/save-job.php", {
        job_id: job.job_id
    }).then(function (res) {

        alert(res.data.message);

        // 🔥 USE BACKEND RESPONSE
        if (res.data.action === "saved") {
            job.is_saved = true;
        } else if (res.data.action === "unsaved") {
            job.is_saved = false;
        }
    });
};

    /* ================= PAGINATION ================= */

    $scope.nextPage = () => {
        if ($scope.currentPage < $scope.totalPages)
            $scope.loadJobs($scope.currentPage + 1);
    };

    $scope.prevPage = () => {
        if ($scope.currentPage > 1)
            $scope.loadJobs($scope.currentPage - 1);
    };

    $scope.searchJobs = () => $scope.loadJobs(1);

    /* ================= INIT ================= */

    $scope.loadJobs(1);

});