@extends('admin.layout.app')
@section('page_title', 'Susbcription')
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
            <h1>Users Subscription List</h1>
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
              <div class="card-body">
                <table id="categories" class="table table-bordered">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Subscription</th>
                    <th>Subscription Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    {{-- <th>Banner Image</th> --}}
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($subscription as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->mobile_no }}</td>
                        <td>{{ $item->subscription->title }}</td>
                        <td>{{ $item->subscription->subscription_type->title }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            @if ($item->status == 1)
                            <button class="btn btn-success status_btn" data-id="{{ $item->id }}">Active</button>
                            @else
                            <button class="btn btn-danger status_btn" data-id="{{ $item->id }}">In-active</button>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.subscription.user.orders',['id'=>$item->id]) }}" class="btn btn-success">View Order</a>
                            <a href="{{ route('admin.subscription.delete.user',['id'=>$item->id]) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>

                    </tr>
                    @endforeach

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
        $(document).on('click','.status_btn',function(){
            var cur_val = $(this).attr('data-id');
            // alert(cur_val);
            var cur_elemet = $(this);
            $.ajax({
                            url: "{{ route('admin.user_change_sub_status') }}",
                            type: "POST",
                            data: {
                                id: cur_val,
                                "_token": "{{ csrf_token() }}",

                            },
                            success: function(data) {
                                // console.log(data);
                                if(data == 1){
                                    $(cur_elemet).text('Active');
                                    $(cur_elemet).removeClass('btn-danger');
                                    $(cur_elemet).addClass('btn-success');
                                }else{
                                    $(cur_elemet).text('In-active');
                                    $(cur_elemet).addClass('btn-danger');
                                    $(cur_elemet).removeClass('btn-success');
                                }
                                // $('#products_id').text('');
                                // $('#products_id').append(data);
                            },
                            error: function(data) {
                                alert("Something went wrong please try again");
                            }
                        });
        });
    </script>
@endsection
