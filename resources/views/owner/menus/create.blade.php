@extends('layouts.admin-main')
@section('styles')
@endsection
@section('content')

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card card-outline-primary">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Add Menu</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{session('success')}}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{session('success')}}
                            </div>
                        @endif
                        <form action='{{ route('menu.store') }}' method='POST' enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <hr>
                                <div class="row p-t-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Dish Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Price </label>
                                            <input type="text" name="price" class="form-control" placeholder="₹">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Image</label>
                                            <input type="file" name="image" id="menu_image"
                                                   class="form-control form-control-danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has-danger">
                                    <label class="control-label">Description</label>
                                    <textarea name="description" class="form-control form-control-danger"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

@endsection
@section('scripts')

@endsection
