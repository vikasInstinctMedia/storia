<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Storia</title>

  @include('admin.layout.include.styles')
  @yield('style')

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">

   @include('admin.layout.include.header')

   @include('admin.layout.include.sidenav')

  <div class="content-wrapper">
   @yield('content')
  </div>

  <!-- Right sidebar  -->
  <!-- <aside class="control-sidebar control-sidebar-dark">
  </aside> -->

  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer> -->


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('admin.layout.include.scripts')
@yield('script')
</body>
</html>
