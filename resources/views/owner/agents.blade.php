@extends('layouts.admin-main')
@section('styles')
@endsection
@section('content')

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card card-outline-primary">


                <div class="card-header">
                    <h4 class="m-b-0 text-white">Delivery Agents <a class="btn btn-outline-secondary w-auto pull-right bg-primary new-agent"><i class="fa fa-add"></i> New</a></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bagented table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($agents as $agent)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <th>{{$agent->user->name}}</th>
                                    <td>{{$agent->user->phone}}</td>
                                    <td>{{$agent->user->email}}</td>
                                    <td>
                                        <span class="badge badge-{{ $agent->status?'danger':'success'}}">
                                            {{ $agent->status?'Busy':'Available'}}
                                        </span></td>

                                    <td>

                                        <div class="btn-group btn-sm">
                                            <a href="#" class="btn btn-primary edit_agent" data-id="{{$agent->id}}"
                                               >Edit
                                            </a>
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item agent-btn assign-order" href="javascript:" data-id = '{{ $agent->id}}' data-op="ao">Assign Order</a>
                                                <div class="dropdown-divider" ></div>
                                                <a class="dropdown-item  agent-btn daily-tasks" href="javascript:void(0)" data-id = '{{ $agent->id}}' data-op="dt">Daily Delivers</a>
                                                <a class="dropdown-item agent-btn text-danger delete-agent" href="javascript:void(0)" data-id = '{{ $agent->id}}' data-op="d">Delete</a>
                                            </div>
                                        </div>

                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Agents</td>
                                </tr>

                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        const agentEditURL='{{route('agent.edit','__id__')}}'
        const agentOPURL='{{route('agent.operations')}}'
        $('.new-agent').click(function () {
            uni_modal('Add Agent', '{{route('agent.create')}}');
        })
        $('.edit_agent').click(function () {
            uni_modal('Update Agent Info', agentEditURL.replace('__id__',this.dataset.id));
        })
        $('.agent-btn').click(function () {
            uni_modal('', '{{route('agent.operations')}}'+'?id='+this.dataset.id+'&op='+this.dataset.op);
        })
        $('.change-status').click(function () {
            start_load()
            $.ajax({
                url: '{route("owner.change-agent-status")}}',
                method: 'POST',
                data: {id: this.dataset.id, sid: this.dataset.value, _token: '{{csrf_token()}}'},
                success: function (resp) {
                    if (resp) {
                        notify(resp.status || "success", resp.message || "Process completed")
                        setTimeout(function () {
                            location.reload()
                        }, 1500)
                    }
                },
                error: function (xhr, status, message) {
                    console.log(xhr)
                    end_load()
                    notify('error', "Err " + status + " " + message)
                }
            })
        })
    </script>
@endsection
