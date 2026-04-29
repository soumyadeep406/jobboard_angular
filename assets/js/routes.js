app.config(function ($routeProvider) {

    $routeProvider

    /* ================= PUBLIC ================= */
    .when("/", {
        templateUrl: "views/home/home.html",
        controller: "JobController"
    })
    .when("/home", {
        templateUrl: "views/home/home.html",
        controller: "JobController"
    })

    /* ================= AUTH ================= */
    .when("/login", {
        templateUrl: "views/auth/login.html",
        controller: "AuthController"
    })
    .when("/register", {
        templateUrl: "views/auth/register.html",
        controller: "AuthController"
    })

    /* ================= SEEKER ================= */
    .when("/seeker-dashboard", {
        templateUrl: "views/seeker/dashboard.html",
        controller: "SeekerController"
    })
    .when("/seeker-profile", {
        templateUrl: "views/seeker/profile.html",
        controller: "SeekerController"
    })
    .when("/applied-jobs", {
        templateUrl: "views/seeker/applied-jobs.html",
        controller: "SeekerController"
    })
    .when("/saved-jobs", {
        templateUrl: "views/seeker/saved-jobs.html",
        controller: "SeekerController"
    })

    /* ================= RECRUITER ================= */
    .when("/recruiter-dashboard", {
        templateUrl: "views/recruiter/dashboard.html",
        controller: "RecruiterController"
    })
    .when("/company-profile", {
        templateUrl: "views/recruiter/company-profile.html",
        controller: "RecruiterController"
    })
    .when("/post-job", {
        templateUrl: "views/recruiter/post-job.html",
        controller: "RecruiterController"
    })
    .when("/applications", {
        templateUrl: "views/recruiter/applications.html",
        controller: "RecruiterController"
    })

    /* ================= ADMIN ================= */
    .when("/admin-dashboard", {
        templateUrl: "views/admin/dashboard.html",
        controller: "AdminController"
    })
    .when("/admin-users", {
        templateUrl: "views/admin/users.html",
        controller: "AdminController"
    })
    .when("/admin-recruiters", {
        templateUrl: "views/admin/recruiters.html",
        controller: "AdminController"
    })
    .when("/admin-jobs", {
        templateUrl: "views/admin/jobs.html",
        controller: "AdminController"
    })
    .when("/admin-skills", {
        templateUrl: "views/admin/skills.html",
        controller: "AdminController"
    })

    .otherwise({
        redirectTo: "/"
    });
});