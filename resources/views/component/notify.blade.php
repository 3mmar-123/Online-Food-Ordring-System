<script src="{{asset('js/iziToast.js')}}"></script>
<link href="{{asset('css/iziToast.css')}}" rel="stylesheet"/>
@if (session()->has('notify'))
    @foreach (session('notify') as $msg)
        <script>
            "use strict";
            iziToast.{{ $msg[0] }}({
                message: "{{ __($msg[1]) }}",
                position: "topRight"
            });
        </script>
    @endforeach
@endif
@if (session()->has('success'))

    <script>
        "use strict";
        iziToast.success({
            message: "{{ __(session('success')) }}",
            position: "topRight"
        });
    </script>
@endif
@if (session()->has('error'))

    <script>
        "use strict";
        iziToast.error({
            message: "{{ __(session('error')) }}",
            position: "topRight"
        });
    </script>
@endif

@if (isset($errors) && $errors->any())
    @php
        $collection = collect($errors->all());
        $errors = $collection->unique();
    @endphp

    <script>
        "use strict";
        @foreach ($errors as $error)
        iziToast.error({
            message: '{{ __($error) }}',
            position: "topRight"
        });
        @endforeach
    </script>
@endif
<script>
    "use strict";

    function notify(status, message) {
        if (typeof message == 'string') {
            iziToast[status]({
                message: message,
                position: "topRight"
            });
        } else if(message){
            $.each(message, function(i, val) {
                iziToast[status]({
                    message: val,
                    position: "topRight"
                });
            });
        }
    }
</script>
