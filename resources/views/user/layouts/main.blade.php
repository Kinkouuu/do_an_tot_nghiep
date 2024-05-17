@include('user.layouts.header')

<div class="site-wrap">

    <x-navbar/>
    @include('user.layouts.slide')

    @yield('content')

    <x-footer/>
</div>
@include('user.layouts.footer')
