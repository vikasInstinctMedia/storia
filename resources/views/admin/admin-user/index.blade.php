@extends('admin.layout.app')
@section('page_title', 'Category')
@section('style')

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Users</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.admin-user.create') }}" class="btn btn-success float-sm-right">Add New</a>
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
                        <div class="card-body">
                            <table id="categories" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
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

    <script>
        $(function() {
            window.dataTable = $("#categories").DataTable({
                ...datatableProperties,
                ajax: "{{ route('admin.admin-user.getlist') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },

                    {
                        data: 'role_id',
                        name: 'role_id',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            //   console.log(data);
                            //   return `<img src="${data}" . '" alt="" height="30px" weight="50px">`;
                            if (data == 1) {
                                return 'Super Admin';
                            } else {
                                return 'Branch Admin';
                            }
                        }
                    },
                    {
                        data: 'branch_show',
                        name: 'branch_show'
                    },
                    {
                        data: 'status_new',
                        name: 'status_new',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            //   console.log(data);
                            //   return `<img src="${data}" . '" alt="" height="30px" weight="50px">`;
                            if (data.status == 1) {
                                return '<button class="btn btn-success change_staus" data-status="' +
                                    data.status + '" data-id="' + data.id + '">Active</button>';
                            } else {
                                return '<button class="btn btn-danger change_staus" data-status="' +
                                    data.status + '" data-id="' + data.id + '">In-active</button>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {


                            return `<div class="btn-group">
                        <a href ='${data.edit_url}'>
                        <button type="button" class="btn btn-warning">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        </a>
                        <a href ='${data.delete_url}'>
                        <button type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                        </a>
                      </div>`;
                        }
                    },
                ],

            });


        });

        $(document).on('click', '.change_staus', function() {
            var admin_id = $(this).attr('data-id');
            var admin_status = $(this).attr('data-status');
            // alert(admin_id);
            var cur_ele = $(this);
            $.ajax({
                url: "{{ route('admin.admin-user.change-status') }}",
                type: "POST",
                data: {
                    admin_id: admin_id,
                    admin_status:admin_status,
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
                    // console.log(data);
                    // $('.show_pro_list_here').text('');
                    // $('.show_pro_list_here').append(data);
                    // $('#sub_category_id').text('');
                    // $('#sub_category_id').append(data);
                    // $('.show_pro_list_here_main').fadeIn();
                },
                error: function(data) {
                    alert("Something went wrong please try again");
                }
            });

        });
    </script>
@endsection
