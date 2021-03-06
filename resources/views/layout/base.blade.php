<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Water+Brush&display=swap" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin_lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_lte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <!-- Virtual Keyboard -->
  <link rel="stylesheet" href="{{ asset('keyboard/css/keyboard-dark.css') }}">
  <link rel="stylesheet" href="{{ asset('keyboard/css/keyboard-previewkeyset.css') }}">
  <link rel="shortcut icon" href="{{ asset('images/typing.png') }}"/>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">


  @include('layout.navbar')


  @include('layout.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->


  @include('layout.footer')
 
</div>
<!-- ./wrapper -->

<style>
  .card {
    box-shadow: 4px 6px 4px lightgrey;
  }
</style>

<style>
  <style>
  html head + body .ui-navbutton.ui-navbutton-c:hover,
  html head + body .ui-navbutton.ui-navbutton-c.ui-navbutton-hover,
  html head + body .ui-navbutton.ui-navbutton-c:active,
  html head + body .ui-navbutton.ui-navbutton-c.ui-navbutton-active {
      border-color: #a37a00;
      color: #fff !important;
  }

  html head+body button.ui-keyboard-button.ui-state-hover {
      border: 2px solid #ffffff !important;
      background-color: #999999 !important;
  }
  /* Class added to indicate the virtual keyboard has navigation focus */
  .hasFocus {
      border-color: #59b4d4 !important;
  }
  .navbutton {
      line-height: 30px;
      margin: 2px;
      padding: 5px;
      border: #333 1px solid;
  }
</style>

<?php if(session('user_roles') == 'Student') : ?>
<style>
  .card {
    border-top: 3px solid lightskyblue;
  }
</style>
<?php endif; ?>

<?php if(session('user_roles') == 'Admin') : ?>
<style>
  .card {
    border-top: 3px solid salmon;
  }
</style>
<?php endif; ?>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admin_lte/plugins/jquery/jquery.min.js') }}"></script>


<!-- Bootstrap -->
<script src="{{ asset('admin_lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('keyboard/js/jquery.keyboard.js') }}" ></script>
<script src="{{ asset('keyboard/js/jquery.keyboard.extension-previewkeyset.js') }}"></script>
<script src="{{ asset('keyboard/js/jquery.keyboard.extension-typing.js') }}"></script>

@yield('js')

<script>

  $('#table').DataTable({
  })

  const Toast = Swal.mixin({
  toast: true,
  position: 'top',
  showConfirmButton: false,
  width:350,
  timer: 3000,
  timerProgressBar: true,
  })
  function msg(icon,title){
  Toast.fire({ icon, title })
  }
</script>

<!-- AdminLTE -->
<script src="{{ asset('admin_lte/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('admin_lte/plugins/chart.js/Chart.min.js') }} "></script>

<script src="{{ asset('admin_lte/dist/js/pages/dashboard3.js') }} "></script>

<script>
  // Current Time
  time = new Date().toLocaleString([], {day: '2-digit', month: '2-digit', year: '2-digit', hour: '2-digit', minute:'2-digit'});
  $('#current-time').text(time)

</script>

</body>
</html>
