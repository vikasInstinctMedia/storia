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
                <h1>{{ $branch->name }}</h1>
            </div>
            
            <div class="col-sm-6">
                <a href="{{ route('admin.branches.inventory.import_view', ['branch_id' => $branch->id ]) }}" class="btn btn-success float-sm-right">Import stock</a>
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
                        <table id="products" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Prodcut Name</th>
                                    <th>SKU</th>
                                    <th>Quantity</th>
                                    <!-- <th>Action</th> -->
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="{{ route('admin.branches.inventory.updatequantity') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Quantity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <p id="product-name"></p>
                        </div>
                        <input type="hidden" id="inventory-id" name="inventoryId" > 
                        <label for="quantity"> Quantity  </label>
                        <input type="number" min="0" id="quantity" name="quantity" class="form-control" value="" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

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
        window.dataTable = $("#products").DataTable({
            ...datatableProperties,
            stateSave: true,
            ajax: "{{ route('admin.branches.inventory.getlist', [ 'branch' => $branch->id ]) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'sku.product.name',
                    name: 'sku.product.name',
                    render: function(data, type, row) {
                        // return '';
                        return data + "(" + row.sku.details.title + ")";
                    }
                },
                {
                    data: 'sku.sku',
                    name: 'sku.sku'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                // {
                //     data: 'quantity',
                //     name: 'quantity'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let prodcutName = row.sku.product.name + "(" + row.sku.details.title + ")";
                        // let prodcutName = row.sku.id;
                        return `<div class="btn-group">
                        <button type="button" class="btn btn-warning change-qty" data-qty = "${row.quantity}" data-product-name= "${prodcutName}" data-inventory-id ="${row.id}">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                      </div>`;
                    }
                },
            ],

        });



        $(document).on('click', '.change-qty', function() {
            $('#quantity').val( $(this).data('qty') );
            $('#product-name').text( $(this).data('product-name'));
            $('#inventory-id').val( $(this).data('inventory-id'));
            $('#exampleModal').modal('toggle');

        });


    });
</script>
@endsection