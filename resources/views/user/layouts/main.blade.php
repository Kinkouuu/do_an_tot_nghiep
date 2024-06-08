@include('user.layouts.header')

<div class="site-wrap">

    <x-navbar/>
    @if(!request()->routeIs(config('constants.route_not_include_carousel')))
        @include('user.layouts.slide')
    @endif
    @yield('content')
    <x-footer/>
</div>
@include('user.layouts.footer')
