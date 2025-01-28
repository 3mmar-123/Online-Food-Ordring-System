<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Fast Ordering</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="{{csrf_token()}}" name="csrf-token">
    <meta content="" name="description">
    <!-- Favicon -->
    <link href={{asset('assets/images/food-mania-logo.png')}} rel="icon">

    <link href="{{asset('libs/fontawesome-6.4.0/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/helper.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    <style>
        .card-header {
            background: #f54d5a none repeat scroll 0 0 !important;
            border-color: #f54d5a !important;
        }
    </style>
    @yield('styles')

</head>

<body class="fix-header">
<!-- content yield -->
<div id="main-wrapper">
    @include('layouts.admin-header')
    @include('layouts.left-sidebar')
    @yield('content')
</div>
<div class="modal fade" id="uni_modal" role='dialog' aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='submit' onclick="console.log($('#uni_modal form').first().submit())">Save</button>
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jquery-3.6.4.js')}}"></script>
@include('component.notify')

<script src="{{asset('assets/admin/libs/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>

<script src="{{asset('assets/admin/js/custom.js')}}"></script>
<script src="{{asset('js/jsv2.js')}}"></script>

@yield('scripts')

</body>

</html>
