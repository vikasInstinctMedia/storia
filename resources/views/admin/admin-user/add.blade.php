@extends('admin.layout.app')
@section('page_title', 'Category')
@section('style')

@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Admin User</h1>
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
                    <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
                    <!-- /.card-header -->
                    <form action="{{ isset($action) ? route('admin.admin-user.update',['id' => $admin_user->id]) : route('admin.admin-user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if (isset($action))
                                            <input type="hidden" name="admin_id" id="" value="{{ $admin_user->id }}">
                                        @endif
                                        <label for="name" class="required">Name</label>
                                        <input name="full_name" type="text" class="form-control" autocomplete="off" value="{{ isset($admin_user->full_name) ? $admin_user->full_name : '' }}" />
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Email</label>
                                        <input name="email" type="email" class="form-control" autocomplete="off" value="{{ isset($admin_user->email) ? $admin_user->email : '' }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Password</label>
                                        <input name="password" type="password" class="form-control" autocomplete="off" value="" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Role</label>
                                        <select name="role_id" id="" class="form-control">
                                            <option value="" selected disabled>Select</option>
                                            <option value="1" 
                                            @if (isset($admin_user->role_id) && $admin_user->role_id == 1)
                                                selected
                                            @endif
                                            >Super Admin</option>
                                            <option value="2"
                                            @if (isset($admin_user->role_id) && $admin_user->role_id == 2)
                                            selected
                                        @endif
                                        >Branch Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Branch</label>
                                        <select name="branch_id" id="" class="form-control">
                                            <option value="" disabled selected>Select</option>
                                            @foreach ($branch_data as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($admin_user->branch_id) && $admin_user->branch_id == $item->id)
                                                        selected
                                                    @endif
                                                    >{{ $item->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <div class="input-group">

                                                <textarea name="description">{{ isset($admin_user->description) ? $admin_user->description : '' }}</textarea>

                                        </div>
                                    </div>
                                </div> --}}

                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-main"> Create </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>
<script>
    CKEDITOR.replace( 'description' );
</script>
<script>

    $(function() {
        bsCustomFileInput.init();



    });
    $(document).on('click','.add_slider_image',function(e){
        e.preventDefault();
        $('.add_img_here').append('<div class="row main_div" style="margin-bottom: 5px;"><div class="col-md-5"><input type="file" name="slider_images[]" id="" class="form-control"></div><div class="col-md-5"><input type="text" name="slider_url[]" placeholder="Add redirect Url" class="form-control" id=""></div><div class="col-md-2"><button class="btn btn-danger remove_image">X</button></div>');
    });

    $(document).on('click','.remove_image',function(e){
        e.preventDefault();
        $(this).closest('.main_div').remove();
    });
</script>
@endsection
