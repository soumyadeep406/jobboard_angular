app.controller("AdminController", function ($scope, $http, $location) {

    /* ================= INIT ================= */

    $scope.selectedRole = 'all';
    $scope.fromDate = "";
    $scope.toDate = "";

    $scope.users = [];
    $scope.recruiters = [];
    $scope.jobs = [];
    $scope.skills = [];
    $scope.reports = {};

    $scope.reportType = "";

    /* ================= FILTER ================= */

    $scope.filterUsers = function(user){
        if ($scope.selectedRole === 'all') return true;
        return user.role && user.role.toLowerCase().includes($scope.selectedRole);
    };

    $scope.getFilteredUsers = function(){
        return ($scope.users || []).filter($scope.filterUsers);
    };

    $scope.applyFilter = function(){

        if (!$scope.fromDate || !$scope.toDate) {
            return alert("Select both dates");
        }

        $http.get(`api/admin/reports.php?from=${$scope.fromDate}&to=${$scope.toDate}`)
        .then(res => {
            $scope.users = res.data.users;
            $scope.jobs = res.data.jobs;
            $scope.companies = res.data.companies;
        })
        .catch(() => alert("Filter failed"));
    };

    $scope.download = function(type){
        window.open(`http://localhost/jobboard_angular/api/admin/download.php?type=${type}`, "_blank");
    };

    /* ================= NAV ================= */

    $scope.isActive = path => $location.path() === path;

    /* ================= PAGINATION (REUSABLE) ================= */

    function loadData(url, page, target){
        $http.get(`${url}?page=${page}`)
        .then(res => {
            if(res.data.status === "success"){
                $scope[target] = res.data.data;
                $scope[target + "TotalPages"] = res.data.totalPages;
                $scope[target + "CurrentPage"] = res.data.currentPage;
            }
        });
    }

    function nextPage(target, loader){
        if ($scope[target + "CurrentPage"] < $scope[target + "TotalPages"]) {
            loader($scope[target + "CurrentPage"] + 1);
        }
    }

    function prevPage(target, loader){
        if ($scope[target + "CurrentPage"] > 1) {
            loader($scope[target + "CurrentPage"] - 1);
        }
    }

    /* USERS */
    $scope.userCurrentPage = 1;
    $scope.userTotalPages = 1;

    $scope.loadUsers = (p = 1) => loadData("api/admin/users.php", p, "users");
    $scope.nextUserPage = () => nextPage("user", $scope.loadUsers);
    $scope.prevUserPage = () => prevPage("user", $scope.loadUsers);

    /* RECRUITERS */
    $scope.recruiterCurrentPage = 1;
    $scope.recruiterTotalPages = 1;

    $scope.loadRecruiters = (p = 1) => loadData("api/admin/recruiters.php", p, "recruiters");
    $scope.nextRecruiterPage = () => nextPage("recruiter", $scope.loadRecruiters);
    $scope.prevRecruiterPage = () => prevPage("recruiter", $scope.loadRecruiters);

    /* JOBS */
    $scope.jobCurrentPage = 1;
    $scope.jobTotalPages = 1;

    $scope.loadJobs = (p = 1) => loadData("api/admin/jobs.php", p, "jobs");
    $scope.nextJobPage = () => nextPage("job", $scope.loadJobs);
    $scope.prevJobPage = () => prevPage("job", $scope.loadJobs);

    /* ================= ACTIONS ================= */

    $scope.approveRecruiter = function(id){
        $http.post("api/admin/approve-recruiter.php", { id })
        .then(res => {
            if(res.data.status === "success"){
                $scope.loadRecruiters($scope.recruiterCurrentPage);
            } else {
                alert(res.data.message);
            }
        });
    };

    $scope.blockUser = function(id){

        if (!confirm("Block this user?")) return;

        $http.post("api/admin/block-user.php", { id })
        .then(res => {
            if(res.data.status === "success"){
                $scope.loadUsers($scope.userCurrentPage);
            } else {
                alert(res.data.message);
            }
        });
    };

    /* ================= SKILLS (PAGINATION FINAL) ================= */

$scope.skills = [];
$scope.skillCurrentPage = 1;
$scope.skillTotalPages = 1;
$scope.newSkill = "";

// LOAD
$scope.loadSkills = function(page = 1){

    $http.get("api/skills/list.php?page=" + page)
    .then(function(res){

        if(res.data.status === "success"){

            $scope.skills = res.data.data;
            $scope.skillCurrentPage = res.data.currentPage;
            $scope.skillTotalPages = res.data.totalPages;

        }

    }, function(){
        alert("Error loading skills");
    });
};

// NEXT
$scope.nextSkillPage = function(){
    if ($scope.skillCurrentPage < $scope.skillTotalPages) {
        $scope.loadSkills($scope.skillCurrentPage + 1);
    }
};

// PREV
$scope.prevSkillPage = function(){
    if ($scope.skillCurrentPage > 1) {
        $scope.loadSkills($scope.skillCurrentPage - 1);
    }
};

// ADD
$scope.addSkill = function(){

    if (!$scope.newSkill){
        alert("Enter skill");
        return;
    }

    $http.post("api/skills/add.php", {
        skill_name: $scope.newSkill
    })
    .then(function(res){

        if(res.data.status === "success"){

            $scope.newSkill = "";

            // 🔥 reload same page
            $scope.loadSkills($scope.skillCurrentPage);

        } else {
            alert(res.data.message);
        }

    });
};

    /* ================= REPORTS ================= */

    $scope.loadReports = function(){
        $http.get("api/admin/reports.php")
        .then(res => $scope.reports = res.data);
    };

    /* ================= CHART ================= */

    let chart = null;

    $scope.loadChart = function(){

        $http.get("api/admin/reports.php")
        .then(res => {

            let data = res.data;

            if(chart) chart.destroy();

            chart = new Chart(document.getElementById("adminChart"), {
                type: "pie",
                data: {
                    labels: ["Jobseekers", "Jobs", "Companies"],
                    datasets: [{
                        data: [
                            data.totalUsers,
                            data.totalJobs,
                            data.totalCompanies
                        ],
                        backgroundColor: ["#36A2EB","#FF6384","#4BC0C0"]
                    }]
                }
            });

        });
    };

    /* ================= DOWNLOAD CSV ================= */

    $scope.downloadUsers = function(){

        let data = $scope.getFilteredUsers();

        if (!data.length) return alert("No data");

        let csv = "Name,Email,Role\n";

        data.forEach(u => {
            csv += `${u.name},${u.email},${u.role}\n`;
        });

        let blob = new Blob([csv], { type: "text/csv" });
        let url = URL.createObjectURL(blob);

        let a = document.createElement("a");
        a.href = url;
        a.download = "users_report.csv";
        a.click();
    };

    /* ================= REPORT VIEW ================= */

    function loadReport(url, type){
        $http.get(url).then(res => {
            $scope[type + "Report"] = res.data.data;
            $scope.reportType = type;
        });
    }

    $scope.viewUsers = function(){
        let url = "api/admin/users.php";
        if($scope.fromDate && $scope.toDate){
            url += `?from=${$scope.fromDate}&to=${$scope.toDate}`;
        }

        $http.get(url).then(res => {
            $scope.usersReport = res.data.data.filter($scope.filterUsers);
            $scope.reportType = "users";
        });
    };

    $scope.viewRecruiters = function(){
        let url = "api/admin/recruiters.php";

        // 🔥 BUG FIXED HERE
        if($scope.fromDate && $scope.toDate){
            url += `?from=${$scope.fromDate}&to=${$scope.toDate}`;
        }

        loadReport(url, "recruiters");
    };

    $scope.viewJobs = function(){
        let url = "api/admin/jobs.php";

        if($scope.fromDate && $scope.toDate){
            url += `?from=${$scope.fromDate}&to=${$scope.toDate}`;
        }

        loadReport(url, "jobs");
    };

    /* ================= INIT ================= */

    $scope.loadUsers();
    $scope.loadRecruiters();
    $scope.loadJobs();
    $scope.loadSkills();
    $scope.loadReports();

    setTimeout(() => $scope.loadChart(), 300);

});