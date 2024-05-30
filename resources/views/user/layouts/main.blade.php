@include('user.layouts.header')

<div class="site-wrap">

    <x-navbar/>
    @if(!request()->is('booking-confirm'))
        @include('user.layouts.slide')
    @endif
    @yield('content')
    <x-footer/>
</div>
@include('user.layouts.footer')
