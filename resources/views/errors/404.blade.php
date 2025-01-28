@extends('layouts.main')
@section('nav_bar')
@endsection
@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Coming Soon</h1>
                    <a class="btn btn-light rounded-pill py-3 px-5" href="{{route('home')}}">Go Back To Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
