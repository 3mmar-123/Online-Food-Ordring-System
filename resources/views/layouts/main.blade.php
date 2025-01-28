<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Food Ordering </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="{{csrf_token()}}" name="csrf-token">
    <meta content="" name="description">
    <!-- Favicon -->
    <link href="{{asset('css/mdb6-2.css')}}" rel="stylesheet">


    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/animsition.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/iziToast.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    <link href="{{asset('css/mdb5-customized.css')}}" rel="stylesheet">
    <link href="{{asset('css/style2.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/stylev2.css')}}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap');
    </style>
    @yield('styles')

</head>

<body class="home">
@include('component.nav_bar')


<!-- content yield -->
@yield('content')
{{--
<footer class="footer">
    <div class="container">
        <div class="bottom-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-3 payment-options color-gray">
                    <h5>Payment Options</h5>
                    <ul>
                        <li>
                            <a href="#"> <img src="{{asset('assets/images/paypal.png')}}" alt="Paypal"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="{{asset('assets/images/mastercard.png')}}" alt="Mastercard"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="{{asset('assets/images/maestro.png')}}" alt="Maestro"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="{{asset('assets/images/stripe.png')}}" alt="Stripe"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="{{asset('assets/images/bitcoin.png')}}" alt="Bitcoin"> </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 address color-gray">
                    <h5>Address</h5>
                    <p>213, Raheja Chambers, Free Press Journal Road, Nariman Point, Mumbai, Maharashtra 400021,
                        India</p>
                    <h5><a>Phone: +91 8093424562</a></h5></div>
                <div class="col-xs-12 col-sm-5 additional-info color-gray">
                    <h5>Addition informations</h5>
                    <p>Join thousands of other restaurants who benefit from having partnered with us.</p>
                </div>
            </div>
        </div>

    </div>
</footer>
--}}
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('js/iziToast.js')}}"></script>
@include('component.notify')


<script src="{{asset('assets/js/tether.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('assets/js/animsition.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.isotope.min.js')}}"></script>
<script src="{{asset('assets/js/headroom.js')}}"></script>
<script src="{{asset('assets/js/foodpicky.min.js')}}"></script>
<script src="{{asset('js/jsv2.js')}}"></script>
@yield('scripts')

</body>

</html>
