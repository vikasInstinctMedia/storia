@extends('admin.layout.app')
@section('page_title', 'Banner')
@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@endsection
@section('content')
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 78px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Image Library</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">



                <div class="card">
                    <a href="javascript:void(0)" title="image gallery" data-toggle="modal" data-target="#gallery" class="btn btn-success">
                        Add Images
                    </a>
                    <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                        @foreach ($image_data as $item)
                            <div class="col-md-3" style="margin-bottom: 50px">
                                <a href="{{ URL::to('/') }}/storage/public/assets/image_library/{{ $item->image }}">
                                <img src="{{ URL::to('/') }}/storage/public/assets/image_library/{{ $item->image }}" alt="" style="width:100%;height:200px">
                                </a>
                                <a href="{{ route('admin.image_library_delete',['id'=>$item->id]) }}" style="position: absolute;margin-left: -8px;margin-top: -16px;" class="del_image" data-id="{{ $item->id }}">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="form-control" readonly value="{{ URL::to('/') }}/storage/public/assets/image_library/{{ $item->image }}">
                            </div>
                        @endforeach
                        </div>




                        <div class="modal fade" id="gallery" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">

                                  <h4 class="modal-title">Add Images</h4>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('admin.image_library_store') }}" method="post" enctype="multipart/form-data">
                                 {{ csrf_field() }}
                                 @method('POST')
                                        <div class="col-md-6">
                                     <label for="">Add Images</label>
                                     <input type="file" name="galary_images[]" multiple class="form-control">

                                    </div>
                                 <div class="col-md-12">
                                     <input type="submit" class="btn btn-info" value="submit">
                                 </div>

                                </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection

@section('script')
<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>

<script>
    $(function() {
        bsCustomFileInput.init();

        window.dataTable = $("#banners").DataTable({
            ...datatableProperties,
        });


    });
</script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
$( function() {
  $( "#sortable" ).sortable();
} );



        $(document).on('click', '.change_staus', function() {
            var admin_id = $(this).attr('data-id');
            var admin_status = $(this).attr('data-status');
            // alert(admin_id);
            var cur_ele = $(this);
            // Notiflix.Loading.init({});
            // Notiflix.Loading.pulse();
            // Notiflix.Loading.standard();
            // Notiflix.Notify.success('Sol lucet omnibus');


            $.ajax({
                url: "{{ route('admin.page_change_status') }}",
                type: "POST",
                data: {
                    id: admin_id,
                    status:admin_status,
                    "_token": "{{ csrf_token() }}",

                },
                success: function(data) {
                    if(data == 2){
                        $(cur_ele).attr('data-status', data);
                        $(cur_ele).removeClass('btn-success');
                        $(cur_ele).addClass('btn-danger');
                        $(cur_ele).text('In-active');
                    }else{
                        $(cur_ele).attr('data-status', data);
                        $(cur_ele).removeClass('btn-danger');
                        $(cur_ele).addClass('btn-success');
                        $(cur_ele).text('Active');
                    }
                    // Notiflix.Loading.remove();

                    // console.log(data);
                    // $('.show_pro_list_here').text('');
                    // $('.show_pro_list_here').append(data);
                    // $('#sub_category_id').text('');
                    // $('#sub_category_id').append(data);
                    // $('.show_pro_list_here_main').fadeIn();
                },
                error: function(data) {
                    alert("Something went wrong please try again");
                    // Notiflix.Loading.remove();

                }
            });

        });
</script>
@endsection
