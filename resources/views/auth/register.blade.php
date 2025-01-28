@extends('layouts.main')
@section('styles')

@endsection
@section('content')

    <div style=" background-image: url('{{asset('img/fields/heroFOS.webp')}}');">
        <div class="page-wrapper">

            <div class="container">
                <ul>


                </ul>
            </div>

            <section class="contact-page inner-page">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="widget">
                                <div class="text-error">
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)

                                            <p>{{$error}}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="widget-body">

                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="example-text-input">User-Name</label>
                                                <input class="form-control" type="text" name="name"
                                                       id="example-text-input">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail1">Email Address</label>
                                                <input type="text" class="form-control" name="email"
                                                       id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="example-tel-input-3">Phone number</label>
                                                <input class="form-control" type="text" name="phone"
                                                       id="example-tel-input-3">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                       id="exampleInputPassword1">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="exampleInputPassword2">Confirm password</label>
                                                <input type="password" class="form-control" name="password_confirmation"
                                                       id="exampleInputPassword2">
                                            </div>
                                            <div class="form-outline m-2">
                                                <label class="form-label">Register As: </label>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio"  name="role" value="owner"
                                                           id="owner" required>
                                                    <label class="form-check-label" for="owner">Restaurant Owner</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio"  name="role" value="customer"
                                                           id="custo" checked required>
                                                    <label class="form-check-label" for="custo">Customer</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio"  name="role" value="deliver"
                                                           id="deliv"  required>
                                                    <label class="form-check-label" for="deliv">Deliver</label>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p><input type="submit" value="Register" name="submit"
                                                          class="btn theme-btn"></p>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection
