@extends('layouts.main')
@section('styles')
    <style>
        .right-div-bg {
            margin-top: 0 !important;
            border-width: thick;
            background: aquamarine;
            border-color: blueviolet;
            opacity: 0.7;
            border: solid;
            border-bottom-left-radius: 450%;
            border-bottom-right-radius: 40%;
            overflow: hidden;
            border-block-end: none;

        }

        .right-div-bg img {
            width: 100% !important;
            height: 100% !important;
        }

        .left-div-bg {
            margin-top: auto !important;
            border-width: thick;
            background: aquamarine;
            border-color: blueviolet;
            opacity: 0.7;
            border: solid;
            border-top-right-radius: 450%;
            border-bottom-right-radius: 40%;
            overflow: hidden;
            border-block-end: none;
        }

        .left-div-bg img {
            width: 100% !important;
            height: 100% !important;
        }

        .who-we-are-bg {
            background: rgb(40 46 18 / 87%);
        }

        .partial-opacity img {
            width: 100% !important;
            height: 100% !important;
            -webkit-mask-image: linear-gradient(to left, transparent, black);
            mask-image: linear-gradient(to left, transparent, black);
        }

        .hero-img-bg {
            background: url("/img/hero1.png") no-repeat;
            height: 100vh;

            background-size: cover;

        }

        .hero-img-bg div {
            top: 13%;
            position: relative;
        }

        .txt-sub {
            font-size: 2.3rem;
            font-weight: bold;
            opacity: 0.8;
        }

        .text-xxxl {

            font-size: 4rem;
            line-height: 112px;
            font-weight: bold;
            opacity: 0.8;
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity));
            font-family: Playfair auto, serif !important;
            letter-spacing: 1px;
        }
    </style>
    <style>

        @media (min-width: 1281px) {
            .one-stop-shop-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);;
            }

            .quick-response-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);;
            }

        }

        @media (min-width: 1025px) and (max-width: 1280px) {
            .quick-response-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);;
            }

            .txt-sub {
                font-size: 2rem;
            }

            .text-xxxl {
                font-size: 3.7rem;
                line-height: 85px;

            }

            .one-stop-shop-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);;
            }

        }

        /* Media Query for Tablets Ipads portrait mode */
        @media (min-width: 768px) and (max-width: 1024px) {
            .quick-response-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);;
            }

            .txt-sub {
                font-size: 1.7rem;
            }

            .text-xxxl {
                font-size: 3rem;
                line-height: 65px;
            }

            .one-stop-shop-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);;

            }
        }

        /* Media Query for low resolution like mobiles */
        @media (min-width: 320px) and (max-width: 767px) {

            .txt-sub {
                font-size: 2rem;
            }

            .text-xxxl {
                font-size: 3.5rem;
                line-height: 40px;

            }

            .quick-response-div-bg {
                background-position: 50% 50%;
                background: linear-gradient(to right, #333843, #323541);
                clip-path: polygon(0% 1%, 0% 100%, 100% 100%, 100% 0%, 56% 15%);
                -webkit-clip-path: polygon(0% 1%, 0% 100%, 100% 100%, 100% 0%, 53% 15%);
            }
        }


    </style>

@endsection
@section('nav_bar')
    @include('component.nav_bar')

@endsection
@section('hero')
    <div class="container-fluid  p-0 hero-header hero-img-bg">
        <div class="container-xxl text-white   px-5 mb-1  " style="z-index: 9999">
            <div class="row m-auto">
                <p class=" tracking-wide text-xxxl font-medium mt-2 ">
                    <span class="d-block">Your Gateway to Cybersecurity</span>
                </p>
                <p class="txt-sub  mt-3 mt-md-5">Navigate the digital landscape with confidence, backed by expert
                    knowledge and practical skills.</p>

            </div>


        </div>
        <div class="hero-bg"></div>

    </div>

@endsection

@section('content')

    <!-- Who We Are Start-->
    <div class="container-xxl who-we-are-bg mb-1 mt-5">
        <div class="row white-text m-auto">
            <div class="ms-3">
                <h1 class="mt-3 mb-1 quick-response-h text-center white-text wow fadeInRight" data-wow-delay="0.3s">
                    <span>Who We Are</span>
                </h1>
                <p class="text-center quick-response-p">
                    We are dedicated to revolutionizing how restaurants and their customers connect. Our platform provides
                    an intuitive and efficient way to manage restaurant menus, streamline ordering processes, and enhance
                    the overall dining experience.
                </p>
            </div>
        </div>
    </div>
    <!-- Who We Are End-->

    <!-- Choose Us Start -->
    <div class="container-xxl quick-response-div-bg row-flex vc_custom_1685098197489">
        <div class="container">
            <div class="row white-text">
                <div class="col-sm-12 col-lg-6 col-md-6">
                    <div class="why-choose-content-1">
                        <h1 class="mt-3 quick-response-h text-center white-text wow fadeInRight" data-wow-delay="0.3s">
                            <span>Efficient Management</span>
                        </h1>
                        <p class="quick-response-p">
                            Seamlessly manage restaurant menus, orders, and payment details with our easy-to-use tools,
                            designed for restaurant owners and staff.
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6 col-md-6">
                    <div class="why-choose-content-1">
                        <h1 class="mt-3 quick-response-h text-center white-text wow fadeInRight" data-wow-delay="0.3s">
                            <span>Convenient Ordering</span>
                        </h1>
                        <p class="quick-response-p">
                            Empower customers to explore restaurants, view menus, and place orders effortlessly, ensuring
                            a smooth and enjoyable experience.
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="why-choose-content-2">
                        <h1 class="wow fadeInLeft one-stop-shop-h text-center white-text" data-wow-delay="0.3s">
                            <span>Secure Payments</span>
                        </h1>
                        <p class="one-stop-shop-p">
                            Enjoy peace of mind with secure payment options, including PayPal, credit/debit cards, and
                            cash-on-delivery methods tailored for flexibility and safety.
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="why-choose-content-2">
                        <h1 class="wow fadeInLeft one-stop-shop-h text-center white-text" data-wow-delay="0.3s">
                            <span>Real-Time Updates</span>
                        </h1>
                        <p class="one-stop-shop-p">
                            Leverage real-time location updates and notifications to stay informed and connected, whether
                            managing orders or delivering exceptional service.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Choose Us End -->

    <!-- Our Mission Start -->
    <div class="container-xxl bg-primary">
        <div class="row white-text">
            <div class="col-sm-12 col-lg-7">
                <div class="ms-3">
                    <h1 class="mt-3 mb-1 quick-response-h text-center white-text wow fadeInRight" data-wow-delay="0.3s">
                        <span>Our Mission</span>
                    </h1>
                    <p class="quick-response-p">
                        <i class="fa fa-check-double"></i> Simplify the dining experience for customers and restaurant owners through cutting-edge technology.
                    </p>
                    <p class="quick-response-p">
                        <i class="fa fa-check-double"></i> Enable restaurants to grow and thrive by offering efficient tools for menu and order management.
                    </p>
                    <p class="quick-response-p">
                        <i class="fa fa-check-double"></i> Enhance customer satisfaction with a seamless ordering process and real-time updates.
                    </p>
                </div>
            </div>
            <div class="col-lg-5 p-0 d-md-block right-div-bg d-sm-none">
                <img src="{{ asset('img/resources.png') }}" alt="Mission Image">
            </div>
        </div>
    </div>
    <!-- Our Mission End -->

    <!-- Our Vision Start -->
    <div class="container-xxl bg-primary">
        <div class="row white-text">
            <div class="col-lg-5 d-md-block mt-0 p-0 left-div-bg d-sm-none">
                <img src="{{ asset('img/img4.png') }}" alt="Vision Image">
            </div>
            <div class="col-sm-12 col-lg-7">
                <div class="ms-3">
                    <h1 class="mt-3 mb-1 quick-response-h text-center white-text wow fadeInRight" data-wow-delay="0.3s">
                        <span>Our Vision</span>
                    </h1>
                    <p class="quick-response-p">
                        To redefine how restaurants and customers connect by creating a user-friendly platform that
                        bridges gaps, enhances engagement, and fosters growth.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Vision End -->

@endsection


