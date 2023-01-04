<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyProjects') }} - @yield('title')</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('/') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ url('/') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('/') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/vendor/line-awesome/css/line-awesome.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ url('/') }}/assets/css/style.css" rel="stylesheet">


    <!-- =======================================================
  * Template Name: SoftLand - v2.1.0
  * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Mobile Menu ======= -->
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <!-- ======= Header ======= -->
    <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

        <div class="container">
            <div class="row align-items-center">

                <div class="col-6 col-lg-2">
                    <h1 class="mb-0 site-logo"><a href="{{ url('/') }}" class="mb-0">{{ config('app.name', 'Laravel') }}</a></h1>
                </div>

                <div class="col-12 col-md-10 d-none d-lg-block">
                    <nav class="site-navigation position-relative text-right" role="navigation">

                        <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                            <li class="active"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                            <li><a href="{{ url('/features') }}" class="nav-link">Features</a></li>
                            <!-- <li><a href="{{ url('/pricing') }}" class="nav-link">Pricing</a></li> -->
                            @guest
                                <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" class="nav-link">Client Registration</a></li>
                                @endif
                            @endguest
                            <?php
                            if (!empty(Auth::user())):
                                if(in_array('user', Auth::user()->roles->pluck('slug')->toArray()) || in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                                    <li class="has-children">
                                        <a href="#" class="nav-link">{{ Auth::user()->name }}</a>
                                        <ul class="dropdown">
                                            <li><a href="{{ route('home') }}" class="nav-link">Dashboard</a></li>
                                            <li><a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">Logout</a></li>
                                        </ul>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                <?php
                                    endif;
                            endif;
                            ?>
                        </ul>
                    </nav>
                </div>

                <div class="col-6 d-inline-block d-lg-none ml-md-0 py-3" style="position: relative; top: 3px;">

                    <a href="#" class="burger site-menu-toggle js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                        <span></span>
                    </a>
                </div>

            </div>
        </div>

    </header>

    <!-- ======= Hero Section ======= -->

    <!-- End Hero -->
    @yield('content')
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3>About {{ config('app.name', 'MyProjects') }}</h3>
                    <p>MyProjects enables individual or small to medium business to mange their projects and clients online to help their business and customers.</p>
                    <p class="social">
                        <a href="#"><span class="icofont-twitter"></span></a>
                        <a href="#"><span class="icofont-facebook"></span></a>
                        <a href="#"><span class="icofont-dribbble"></span></a>
                        <a href="#"><span class="icofont-behance"></span></a>
                    </p>
                </div>
                <div class="col-md-7 ml-auto">
                    <div class="row site-section pt-0">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Navigation</h3>
                            <ul class="list-unstyled">
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('/features') }}">Features</a></li>
                                <!-- <li><a href="{{ url('/pricing') }}">Pricing</a></li> -->
                                <!-- <li><a href="{{ url('/blog') }}">Blog</a></li> -->
                            </ul>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Links</h3>
                            <ul class="list-unstyled">
                                <!-- <li><a href="{{ url('/') }}">About</a></li> -->
                                @guest
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" >Client Registration</a></li>
                                @endif
                                @endguest
                                <?php
                                    if (!empty(Auth::user())):
                                        if(in_array('user', Auth::user()->roles->pluck('slug')->toArray()) || in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                                            <li>
                                                 <a href="{{ route('home') }}" >Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
                                            </li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                        <?php
                                        endif;
                                    endif;
                                ?>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Contact Us</h3>
                            <ul class="list-unstyled">
                                <li><a href="#">Monday - Friday</a></li>
                                <li><a href="#">10:00 AM TO 5:00 PM</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center text-center">
                <div class="col-md-7">
                    <p class="copyright">&copy; Copyright {{ config('app.name', 'MyProjects') }} <?php echo date("Y"); ?>. All Rights Reserved</p>
                    <div class="credits">
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ url('/') }}/assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{ url('/') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="{{ url('/') }}/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ url('/') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ url('/') }}/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="{{ url('/') }}/assets/vendor/jquery-sticky/jquery.sticky.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('/') }}/assets/js/main.js"></script>

</body>

</html>