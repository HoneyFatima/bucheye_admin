<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>term_condition : About</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('assets_html/img/favicon.png') }}" rel="icon">
    <link href="{{ url('assets_html/img/favicon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('assets_html/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ url('assets_html/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets_html/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('assets_html/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets_html/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets_html/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url('assets_html/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">




</head>

<body>


    <main id="main">



        {{-- <section id="terms" class="services"> --}}
            <div class="container aos-init aos-animate" data-aos="fade-up" style="margin-bottom: 20px;">

                <div class="section-title">
                    <img src="{{ url('assets_html/img/logo.png') }}"
                    alt="" style="width: 150px">
                    <h3>About</span></h3>

                </div>

                <div class="row">
                    <div class="col-md-12 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                        <p class="abt-terms">{!!$settings->about!!}</p>

                    </div>

                </div>

            </div>
        {{-- </section> --}}





    </main><!-- End #main -->


    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ url('assets_html/vendor/aos/aos.js') }}"></script>
    <script src="{{ url('assets_html/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets_html/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ url('assets_html/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('assets_html/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ url('assets_html/vendor/purecounter/purecounter.js') }}"></script>
    <script src="{{ url('assets_html/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('assets_html/vendor/waypoints/noframework.waypoints.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('assets_html/js/main.js') }}"></script>

</body>

</html>
