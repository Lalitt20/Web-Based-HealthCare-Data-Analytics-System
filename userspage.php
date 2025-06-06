<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/favicon2.jpeg" type="image/x-icon" />
    <title>Healthcare</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
</head>

<style>
    .btns a {
        border-radius: 8px;
        transition: 0.3s ease;
        font-weight: 500;
    }

    .btns a:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">
    <!-- Top Navbar -->

    <div class="top-nav d-none d-md-block">
        <div class="container">
            <div class="contact">
                <div class="mail d-flex align-items-center">
                    <i class="ri-mail-line"></i>
                    <a href="mailto:healthcare@email.com">healthcare@email.com</a>
                </div>
                <div class="loc d-flex">
                    <i class="ri-map-pin-line"></i>
                    <p>Find our Location</p>
                </div>
            </div>
            <div class="icons">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-twitter-fill"></i></a>
                <a href="#"><i class="ri-linkedin-fill"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->

    <nav class="navbar navbar-expand-lg navigation-wrap">
        <div class="container">
            <a class="navbar-brand ms-3" href="#">
                <img src="images/logo.webp" alt="logo" class="img-fluid logo-img" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trends/index.php">HEALTH TRENDS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Section -->

    <div class="main-content d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <h1>
                        Making Healthcare <br />
                        Better Together
                    </h1>
                    <p>
                        At HealthCare, we bridge the gap between patients, doctors, and administrators through a secure,
                        intuitive,
                        and modern platform. Whether you're booking appointments, managing health records, or accessing
                        personalized
                        care – everything you need is just a click away.
                    </p>
                    <div class="btns d-flex flex-wrap gap-3 mt-4">
                        <!-- Patient/User Login -->
                        <a href="patientlogin.php" class="btn btn-primary px-4 py-2">Login as User</a>

                        <!-- Doctor Login -->
                        <a href="doctorlogin.php" class="btn btn-outline-success px-4 py-2">Login as Doctor</a>

                        <!-- Admin Login -->
                        <a href="adminlogin.php" class="btn btn-outline-danger px-4 py-2">Login as Admin</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
                    <div class="foot">
                    <h4>Top Medical Services</h4>
                    <a href="#">General Consultation</a> <br />
                    <a href="#">Health Checkups</a> <br />
                    <a href="#">Specialist Appointments</a> <br />
                    <a href="#">Emergency Care</a>
                </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
                    <div class="foot">
                        <h4>Quick Links</h4>
                        <a href="#">Jobs</a> <br />
                        <a href="#">Brand Assets</a> <br />
                        <a href="#">Investor Relations</a> <br />
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
                    <div class="foot">
                        <h4>Features</h4>
                        <a href="#">Jobs</a> <br />
                        <a href="#">Brand Assets</a> <br />
                        <a href="#">Investor Relations</a> <br />
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
                    <div class="foot">
                        <h4>Resources</h4>
                        <a href="#">Guides</a> <br />
                        <a href="#">Research</a> <br />
                        <a href="#">Experts</a> <br />
                        <a href="#">Agencies</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-5">
                    <div class="foot">
                        <h4>Newsletter</h4>
                        <a href="#">You can trust us. we only send promo offers,</a>
                        <div class="inpu">
                            <input type="text" placeholder="Your Email Address" />
                            <a href="mailto:healthcare@email.com">
                                <div class="but"><i class="ri-arrow-right-line"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="last-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <p>
                        Copyright © 2025 All rights reserved
                    </p>
                </div>
                <div class="col-12 col-md-6 right">
                    <a href="#">
                        <div class="icon"><i class="ri-facebook-fill"></i></div>
                    </a>
                    <a href="#">
                        <div class="icon"><i class="ri-twitter-fill"></i></div>
                    </a>
                    <a href="#">
                        <div class="icon"><i class="ri-global-line"></i></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>



</html>