@include('admin.layouts.header')
<div class="wrapper">
    @include('admin.layouts.navbar')

    @include('admin.layouts.sidebar')

    @yield('content')
</div>
<!-- ./wrapper --><!-- jQuery -->
@include('admin.layouts.footer')
