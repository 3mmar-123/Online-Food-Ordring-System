<form action="{{ route('agent.store') }}" method="POST">
    @csrf
    @if(isset($agent->id))
        <input type="hidden" name="aid" value="{{$agent->id}}">
    @endif
    <div class="form-group">
        <label for="example-text-input" class="form-label">Name</label>
        <input class="form-control border border-info" type="text" name="name"
               value="{{isset($agent->user)?$agent->user->name:''}}"
               id="example-text-input">
    </div>
    <div class="row mt-2">
        <div class="form-outline col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="text" class="form-control border border-info" name="email"
                   value="{{isset($agent->user)?$agent->user->email:''}}"
                   id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-outline col-sm-6">
            <label for="example-tel-input-3" class="form-label">Phone</label>
            <input class="form-control border border-info" type="text" name="phone"
                   value="{{isset($agent->user)?$agent->user->phone:''}}"
                   id="example-tel-input-3">
        </div>
    </div>
    <div class="row mt-2">
        @if(isset($agent->user))
            <div class="form-outline col-sm-6">
                <label for="exampleInputPassword1" class="form-label"> New Password</label>
                <input type="password" class="form-control border border-info" name="npassword"
                       placeholder="******************"
                       id="exampleInputPassword1">
            </div>
        @else
            <div class="form-outline col-sm-6">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control border border-info" name="password"
                       placeholder="******************"
                       id="exampleInputPassword1">
            </div>
        @endif

        <div class="form-outline col-sm-6">
            <label for="example-trans-input-3" class="form-label">Transportation</label>
            <input class="form-control border border-info" type="text" name="transportation"
                   value="{{$agent->transportation??''}}"
                   id="example-trans-input-3">
        </div>
    </div>
</form>
