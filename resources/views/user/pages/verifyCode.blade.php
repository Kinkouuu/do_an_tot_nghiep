@include('user.layouts.header')

<section class="text-center" style="margin-top: 200px">

    <h3 class="text-black"> Mã xác thực <span class="text-lowercase">{{ $response['title_page'] }}</span> đã được gửi đến địa chỉ email:</h3>
    <h5 class="text-secondary"> {{ $response['email'] }}</h5>

    <form class="" action="" method="POST">
        @csrf
        <div class="m-3">
            <input class="form-control col-md-5 m-auto" id="code" name="code" type="text" placeholder="Nhập mã xác thực">
            <input type="hidden" name="type" value="{{ $response['type'] }}">
            <span class="text-danger"></span>
        </div>
        <livewire:verify.re-send-code />
        <button id="verify" type="submit" class="btn btn-success mt-3 " disabled>Xác nhận</button>
    </form>

</section>

@push('script')
    <script>
        // validation input verify-code input
        $(document).ready(function () {
            let typingTimer;
            const doneTypingInterval = 100;

            $(document).on("input", "#code", function () {
                clearTimeout(typingTimer);

                typingTimer = setTimeout(function () {
                    const input = $("#code").val();
                    if (input && input.length >= 6) {
                        $("#verify").removeAttr("disabled");
                    } else {
                        $("#verify").attr("disabled", true);
                    }
                }, doneTypingInterval);
            });
        });
    </script>
@endpush

@include('user.layouts.footer')
