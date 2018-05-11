<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @section('css')
        {{ Html::style('css/app.css')}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        {{ Html::style('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}

        @yield('extra-style')

        {{ Html::style('LTE/css/AdminLTE.min.css')}}
        {{ Html::style('LTE/css/skins/_all-skins.min.css')}}
  @show

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="skin-blue">
<div class="wrapper">

    <!-- Header -->
    @include('panel/partials.header')

    <!-- Sidebar -->
    @include('panel/partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('header')
            </h1>
        </section>
        @include('panel/partials.flashMessage')
        <!-- Main content -->

        <section class="content">
            <!-- Your Page Content Here -->
            @yield('contents')
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    <footer>
      @yield('footer')
    </footer>
    

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

@section('script')
       {{ Html::script('plugins/jQuery/jquery-2.2.3.min.js') }}
       {{ Html::script('js/app.js') }}
       {{ Html::script('plugins/fastclick/fastclick.js') }}
       {{ Html::script('LTE/js/app.min.js') }}
       {{ Html::script('plugins/sparkline/jquery.sparkline.min.js') }}
       {{ Html::script('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
       {{ Html::script('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
       {{ Html::script('plugins/slimScroll/jquery.slimscroll.min.js') }}

       <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
       {{ Html::script('plugins/chartjs/Chart.min.js') }}
       {{-- {{ Html::script('LTE/js/pages/dashboard2.js') }} --}}
       {{ Html::script('LTE/js/demo.js') }}
  @show  

  @yield('extra-script')
</body>
</html>







  