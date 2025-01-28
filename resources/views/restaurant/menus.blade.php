@extends('layouts.main')
@section('styles')
    <style>
        header.masthead {
            background: url('{{asset($restaurant->logo_url)}}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            position: relative;
            height: 85vh !important;
        }
        header.masthead:before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            backdrop-filter: brightness(0.8);
        }
        .page-title > h1 {
            text-shadow: 0px 0px 5px #000 !important;
            font-family: 'Dancing Script', cursive !important;
            font-size: 4em !important;
        }
        .page-wrapper {
            padding-top: 94px;
            /* Used for inpper pages if navigation fixed to the top */
        }
    </style>

@endsection
@section('content')
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 position-relative align-self-center mb-4 page-title">
                    <h1 class="text-white">Welcome to {{$restaurant->name}}</h1>
                    <hr class="divider my-4 bg-dark" />

                </div>

            </div>
        </div>
    </header>

    <div class="pae-wrapper">
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a
                            href="{{ route('customer.restaurants') }}">Choose Restaurant</a>
                    </li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a
                            href="#">Pick Your favorite food</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>
                </ul>
            </div>
        </div>

        <div class="breadcrumb">
            <div class="container">

            </div>
        </div>
        <section class="page-section" id="menu">
            <p class="text-center text-cursive fw-bolder" style="font-size:3em">Menus</p>
            <div class="d-flex justify-content-center">
                <hr class="border-dark" width="5%">
            </div>
            <div id="menu-field" class="card-deck row mt-2">
                @foreach($menus as $menu)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card menu-item  rounded-0">
                            <div class="position-relative overflow-hidden" id="item-img-holder">
                                <img src="{{asset($menu->image_url)}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body rounded-0">
                                <h5 class="card-title">{{$menu->name}}</h5>
                                <p class="card-text truncate">{{$menu->description}}</p>
                                <div class="text-center">
                                    <button type="button" class="btn btn-outline-dark view_prod btn-block theme-btn-dash pull-right" data-ripple-color="dark" data-id="{{$menu->id}}"><i class="fa fa-eye"></i> View</button>

                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    </div>
    <div class="modal fade" id="uni_modal_right" role='dialog'>
        <div class="modal-dialog modal-full-height  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-arrow-right"></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')

    <script>
        $('.view_prod').click(function(){
            uni_modal_right('Menu Details','{{route('menu.view')}}?id='+$(this).attr('data-id'))
        })
    </script>
    <script>
    </script>

@endsection

