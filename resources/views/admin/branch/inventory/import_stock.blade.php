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
                <h1>Import Stock</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.branches.inventory.export_template', ['branch_id' => $branch->id]) }}" class="btn btn-warning float-sm-right">Excel Template</a>
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
                    <form action="{{ route('admin.branches.inventory.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="branch_id" value="{{ $branch->id }}" >
                        <div class="card-body">
                            <small>
                                ( Import the template first in order to import )
                            </small>
                            <div class="row">
                                <div class="col-sm-6">
                                     <div class="form-group">
                                        <label for="exampleInputFile" class="required">Excel file with stock data</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="file" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
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