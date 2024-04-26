@include('user.layouts.header')

<section class="text-center">
    <h3 class="text-black">
        Mã xác thực  <span class="text-lowercase"> {{ $subject }} </span> của bạn là: <span class="text-secondary"> {{ $verifyCode }} </span>
    </h3>
    <p class="text-danger">
        * Lưu ý: Mã xác thực chỉ có hạn trong 5 phút. Vui lòng không chia sẻ mã này với bất kỳ người khác!
    </p>
</section>

@include('user.layouts.footer')

