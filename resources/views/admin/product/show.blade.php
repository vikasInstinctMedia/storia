@extends('admin.layout.app')
@section('page_title', 'Product')
@section('style')


@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Product </h1>
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
          <div class="card-header">
            <h3 class="card-title">Product Details</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3">
                <h4>Storia Mango Shake- No Added Sugar</h4>
                <p>Behold, the kinf of fruits has arrived in its most delicious avatar. It is India's Highest Fruit Content Shake, making it as healthy as it is irresistible. Sip it, gulp it, devour it, there's no way you won't love it, now with No Added Sugar.</p>
              </div>
              <div class="col-lg-9">
                <div class="text-center">
                  <div class="storiabase">
                    <img src="http://localhost/storia/public/storage/usp/Natural_icon.png">
                    <p>Contains Natural Fruit</p>
                  </div>
                  <div class="storiabase">
                    <img src="http://localhost/storia/public/storage/usp/Trans_fat_free.png">
                    <p>Trans Fat Free</p>
                  </div>
                  <div class="storiabase">
                    <img src="http://localhost/storia/public/storage/usp/No_added_sugar.png">
                    <p>No Added Sugar</p>
                  </div>
                  <div class="storiabase">
                    <img src="http://localhost/storia/public/storage/usp/Nutrients_and_vitamin_icon.png">
                    <p>Rich Source Of Iron &amp; Vitamin A</p>
                  </div>
                </div>
              </div>
              <div class="collg-9">
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


<script>
  $(function() {


  });
</script>
@endsection