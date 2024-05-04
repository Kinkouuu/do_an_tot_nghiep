@include('admin.layouts.header')
<div class="wrapper">
    @include('admin.layouts.navbar')

    @include('admin.layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper --><!-- jQuery -->
@include('admin.layouts.footer')
