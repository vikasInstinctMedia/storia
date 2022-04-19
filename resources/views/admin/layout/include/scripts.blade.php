<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('admin/template/js/adminlte.js') }}"></script>

<script src="{{ asset('admin/js/helper.js') }}"></script>

<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('admin/notiflix/notiflix-2.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/notiflix/notiflix-aio-2.6.0.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('admin/js/jquery.amsify.suggestags.js') }}"></script>

<!-- Flash Message Popup -->
<script>
    toastr.options = { "closeButton" : true, "progressBar" : true };
</script>
@if(Session::has('message'))
    <script>toastr.success("{{ session('message') }}"); </script>
@elseif(Session::has('error'))
    <script>toastr.error("{{ session('error') }}"); </script>
@endif

<script>

    @if($errors->any())
        var span = document.createElement("div");
        let str = "<ul style='float:left'>";
            @foreach ($errors->all() as $error)
                    str += "<li style='float:left'>{{ $error }}</li>";
            @endforeach
        str += "</ul>";

        span.innerHTML = str;

        Swal.fire({
            title: "Errors !! please correct followings",
            html: span,
        });

    @endif

    $(document).on('keyup keypress','.allownumeric', function(event) {

        console.log($(this).html());
        // return;
        // (?<=^| )\d+(\.\d+)?(?=$| )
        $(this).val(
            $(this).val().replace(/[^\.\d].+/, "")
            // $(this).val().replace(/(?<=^| )\d+(\.\d+)?(?=$| )|(?<=^| )\.\d+(?=$| )/, "")
        );
        if ((event.which < 48 || event.which > 57) && even.which != 46) {
            event.preventDefault();
        }

    });
</script>
