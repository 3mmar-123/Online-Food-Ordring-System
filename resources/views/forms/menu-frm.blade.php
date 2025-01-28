<form action='{{ route('menus.store') }}' method='POST' enctype="multipart/form-data">
    @csrf
    @if(isset($menu->id))
        <input type="hidden" name="mid" value="{{$menu->id}}">

    @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Dish Name</label>
                    <input type="text" name="name" value="{{$menu->name??''}}" class="form-control  border border-info">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6 ">
                <div class="form-group ">
                    <label class="control-label">Price </label>
                    <input type="text" name="price"  value="{{$menu->price??''}}" class="form-control  border border-info" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Image</label>
                    <input type="file" name="image" id="menu_image"
                           class="form-control  border border-info">
                </div>
                @if(isset($menu->image_url))
                    <img src="{{asset($menu->image_url)}}" width="80" height="80">
                @endif
            </div>
        </div>
        <div class="form-group mt-2 ">
            <label class="control-label">Description</label>
            <textarea name="description" class="form-control  border border-info"> {{$menu->description??''}}</textarea>
        </div>
</form>
