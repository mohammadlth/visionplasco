@if ($errors->any())

    @foreach ($errors->all() as $error)


        <script>
            toastr.error('', '{{ $error }}', {
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": true,
            });
        </script>

    @endforeach

@endif


@if(Session::get('success_message'))

    <script>
        toastr.success('', '{{Session::get('success_message') }}', {
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
        });
    </script>

@endif

@if (session('error_message'))

    <script>
        toastr.error('', '{{Session::get('error_message')}}', {
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
        });
    </script>

@endif
