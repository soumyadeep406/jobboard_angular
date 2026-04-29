<!DOCTYPE html>
<html lang="en" ng-app="jobApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobBoard - Hire Smarter</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font (Premium Look) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">

    <!-- Angular -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-custom {
            background: #000000;
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 22px;
            color: #e50914 !important;
        }

        .nav-link {
            color: #cccccc !important;
            margin-right: 15px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffffff !important;
        }

        .btn-primary {
            background-color: #e50914;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff1f1f;
        }

        .btn-danger {
            background-color: #b91c1c;
            border: none;
        }

        footer {
            background-color: #111;
            color: #888;
        }

        .main-content {
            min-height: 85vh;
            padding-top: 40px;
        }
    </style>
</head>

<body ng-controller="MainController">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">

            <a class="navbar-brand" href="#!/">
                JobBoard
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" ng-class="{active: isActive('/')}" href="#!/">
                            Home
                        </a>
                    </li>

                    <li class="nav-item" ng-if="isLoggedIn()">
                        <a class="nav-link" href="{{ getDashboardLink() }}">
                            Dashboard
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">

                    <div ng-if="!isLoggedIn()">
                        <a href="#!/login" class="btn btn-outline-light me-2">
                            Login
                        </a>
                        <a href="#!/register" class="btn btn-primary">
                            Get Started
                        </a>
                    </div>

                    <div ng-if="isLoggedIn()">
                        <button ng-click="logout()" class="btn btn-danger">
                            Logout
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container main-content">
        <div ng-view></div>
    </div>

    <!-- FOOTER -->
    <footer class="text-center py-4 mt-5">
        <p class="mb-0">
            © 2026 JobBoard. Crafted with passion by Soumyadeep & Sneha. 🚀
        </p>
    </footer>


    <!-- Angular Scripts -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/routes.js"></script>

    <script src="assets/js/services/AuthService.js"></script>
    <script src="assets/js/controllers/MainController.js"></script>
    <script src="assets/js/controllers/AuthController.js"></script>
    <script src="assets/js/controllers/JobController.js"></script>
    <script src="assets/js/controllers/RecruiterController.js"></script>
    <script src="assets/js/controllers/SeekerController.js"></script>
    <script src="assets/js/controllers/AdminController.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
