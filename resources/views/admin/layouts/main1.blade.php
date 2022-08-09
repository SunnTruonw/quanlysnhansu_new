
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('admin_asset/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('admin_asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">

  <link rel="stylesheet" href="{{asset('admin_asset/dist/css/adminlte.min.css')}}">
</head>


<b ody class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
    @include('admin.partials.header');
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  
  @include('admin.partials.sidebar');


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    

    <!-- Main content -->
        @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
  @include('admin.partials.footer');
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('admin_asset/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin_asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('admin_asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin_asset/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('admin_asset/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('admin_asset/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('admin_asset/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('admin_asset/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>

<!-- -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<!-- ChartJS -->
<script src="{{asset('admin_asset/plugins/chart.js/Chart.min.js')}}"></script>

<!-- MainJS -->
<script src="{{asset('admin_asset/asset/js/main.js')}}"></script>

<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('admin_asset/dist/js/demo.js')}}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin_asset/dist/js/pages/dashboard2.js')}}"></script>

@yield('js')

</body>
</html>
