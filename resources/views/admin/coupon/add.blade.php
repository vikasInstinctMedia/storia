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
                <h1>Create Coupon</h1>
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
                    <form action="{{ route('admin.coupons.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Code</label>
                                        <input name="code" type="text" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Type</label>
                                        <select class="form-control" name="type">
                                                <option value="">Select</option>
                                                @foreach(\App\Models\Coupon::TYPES as $key => $type)
                                                    <option value="{{ $key }}">{{ $type }}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Value</label>
                                        <input name="value" type="number" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description" class="required">Description</label>
                                        <textarea name="description"  class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="valid_from">From Date</label>
                                        <input name="valid_from" type="date" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="till_from" >Till Date</label>
                                        <input name="valid_till" type="date" class="form-control" />
                                    </div>
                                </div>

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

<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>

<script>
    $(function() {
        bsCustomFileInput.init();



    });
</script>
@endsection
