@extends('layouts.main')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
    <style type="text/css">
        #buttn {
            color: #fff;
            background-color: #ff3300;
        }
    </style>
@endsection
@section('content')

    <div style=" background-image: url('{{asset('img/fields/heroFOS.webp')}}');">


        <div class="pen-title">
            <
        </div>

        <div class="module form-module">
            <div class="toggle">

            </div>
            <div class="form">
                <h2>Login to your account</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="email" placeholder="Username" name="email"/>
                    <input type="password" placeholder="Password" name="password"/>
                    <input type="submit" id="buttn" name="submit" value="Login"/>
                </form>
            </div>

            <div class="cta">Not registered?<a href="{{ route('register') }}" style="color:#f30;"> Create an account</a>
            </div>
        </div>


        <div class="container-fluid pt-3">
            <p></p>
        </div>
    </div>

@endsection
