@extends('layouts.admin-main')
@section('styles')
@endsection
@section('content')

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card card-outline-primary">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Menus<a class="btn btn-outline-secondary pull-right bg-primary new-menu"><i class="fa fa-add"></i> New</a></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table id="menus-table"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Dish-Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($menus as $menu)
                                    <tr>
                                        <th>{{$menu->name}}</th>
                                        <td>{{$menu->description}}</td>
                                        <th>{{$menu->price}}</th>

                                        <td>
                                            <img src="{{asset($menu->image_url)}}"
                                                 class="img-responsive  radius"
                                                 style="max-height:100px;max-width:150px;"/>
                                        </td>
                                        <td>
                                            <a data-id="{{$menu->id}}" href="javascript:"
                                               data-toggle="tooltip" data-tooltip="edit"
                                               class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5 edit-menu"><i
                                                    class="fa fa-edit "></i></a>
                                            <a href="{{ route('menus.destroy',$menu->id) }}"
                                               class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                    class="fa fa-trash" style="font-size:16px"></i></a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <center>No Menu</center>
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        const menuEditURL='{{ route('menus.edit','__id__') }}';
        $('.new-menu').click(function () {
            uni_modal('Add Menu', '{{route('menus.create')}}');
        })
        $('.edit-menu').click(function () {
            uni_modal('Edit Menu', menuEditURL.replace('__id__',this.dataset.id));
        })
    </script>

@endsection
