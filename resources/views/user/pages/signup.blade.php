@push('meta-link')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script nonce="7a02897d-a5f4-4157-ab95-5c01e31e448e">try{(function(w,d){!function(kL,kM,kN,kO){kL[kN]=kL[kN]||{};kL[kN].executed=[];kL.zaraz={deferred:[],listeners:[]};kL.zaraz.q=[];kL.zaraz._f=function(kP){return async function(){var kQ=Array.prototype.slice.call(arguments);kL.zaraz.q.push({m:kP,a:kQ})}};for(const kR of["track","set","debug"])kL.zaraz[kR]=kL.zaraz._f(kR);kL.zaraz.init=()=>{var kS=kM.getElementsByTagName(kO)[0],kT=kM.createElement(kO),kU=kM.getElementsByTagName("title")[0];kU&&(kL[kN].t=kM.getElementsByTagName("title")[0].text);kL[kN].x=Math.random();kL[kN].w=kL.screen.width;kL[kN].h=kL.screen.height;kL[kN].j=kL.innerHeight;kL[kN].e=kL.innerWidth;kL[kN].l=kL.location.href;kL[kN].r=kM.referrer;kL[kN].k=kL.screen.colorDepth;kL[kN].n=kM.characterSet;kL[kN].o=(new Date).getTimezoneOffset();if(kL.dataLayer)for(const kY of Object.entries(Object.entries(dataLayer).reduce(((kZ,k$)=>({...kZ[1],...k$[1]})),{})))zaraz.set(kY[0],kY[1],{scope:"page"});kL[kN].q=[];for(;kL.zaraz.q.length;){const la=kL.zaraz.q.shift();kL[kN].q.push(la)}kT.defer=!0;for(const lb of[localStorage,sessionStorage])Object.keys(lb||{}).filter((ld=>ld.startsWith("_zaraz_"))).forEach((lc=>{try{kL[kN]["z_"+lc.slice(7)]=JSON.parse(lb.getItem(lc))}catch{kL[kN]["z_"+lc.slice(7)]=lb.getItem(lc)}}));kT.referrerPolicy="origin";kT.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(kL[kN])));kS.parentNode.insertBefore(kT,kS)};["complete","interactive"].includes(kM.readyState)?zaraz.init():kL.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>
@endpush

@include('user.layouts.header')

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">{{__('Đăng ký')}}</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-wrap p-0">
                    <form action="" class="sign-up-form" method="POST">
                        @csrf
                        @error('email')
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                        </div>
                        @error('phone')
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="{{__('Số điện thoại')}}" value="{{ old('phone') }}">
                        </div>
                        @error('password')
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <input id="password-field" type="password" class="form-control" name="password" placeholder="{{__('Mật khẩu')}}">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        @error('re-password')
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <input id="re-password-field" type="password" class="form-control" name="re-password"
                                   placeholder="{{__('Nhập lại mật khẩu')}}">
                            <span toggle="#re-password-field" class="fa fa-fw fa-eye field-icon toggle-re-password"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="text-uppercase form-control btn btn-primary submit px-3">
                                {{__('Đăng ký')}}
                            </button>
                        </div>
                        <div class="w-100 text-right">
                                <span href="#" style="color: #fff">{{__('Bạn đã có tài khoản')}}?</span>
                        </div>
                    </form>
                    <div class="form-group w-100 text-center">
                        <a href="{{ route('login') }}" class="">&mdash; {{__('Về trang đăng nhập')}} &mdash;</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script src="{{asset('js/app.js')}}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"87551f7f2d97850e","version":"2024.3.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
@endpush

@include('user.layouts.footer')

