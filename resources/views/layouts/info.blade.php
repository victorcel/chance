@if(Session::has('info'))
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script  type="text/javascript">

        {{--swal({--}}
            {{--title: "{{Session::get('info')}}",--}}
            {{--icon: "success",--}}
            {{--buttons: true,--}}
        {{--}).then((value) => {--}}

            {{--}--}}
        swal({
            title: "{{Session::get('info')}}",
            icon: "success",
            showConfirmButton: true,
            //dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                   // swal("Error!!!", "", "error");
                    window.location.href = "https://chance.local:446/login";
                    //return fetch('https://loteria.local/login');
                }else {
                    window.location.href = "https://chance.local/login";
                }
            });

    </script>
    {{--{{ route('login') }}--}}

    {{--<div class="alert alert-info col-md-8 col-md-offset-1">--}}
        {{--<button type="button" class="close" data-dismiss="alert">--}}
            {{--<span>&times;</span>--}}
        {{--</button>--}}
        {{--{{ Session::get('info') }}--}}
    {{--</div>--}}
@endif