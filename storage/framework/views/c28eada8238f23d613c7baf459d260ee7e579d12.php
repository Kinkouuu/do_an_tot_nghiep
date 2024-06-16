<?php
    use App\Enums\Room\RoomStatus;
    use App\Enums\Room\PriceType;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingType;
?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center p-3 mb-3"><?php echo e($title); ?></h1>
            </div>

            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('booking.create-form', [
                'branches' => $branches,
                'roomTypes' => $roomTypes,
            ])->html();
} elseif ($_instance->childHasBeenRendered('JLkkXUK')) {
    $componentId = $_instance->getRenderedChildComponentId('JLkkXUK');
    $componentTag = $_instance->getRenderedChildComponentTagName('JLkkXUK');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JLkkXUK');
} else {
    $response = \Livewire\Livewire::mount('booking.create-form', [
                'branches' => $branches,
                'roomTypes' => $roomTypes,
            ]);
    $html = $response->html();
    $_instance->logRenderedChild('JLkkXUK', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <form action="<?php echo e(route('admin.booking.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="checkin" value="<?php echo e(request()->get('checkin')); ?>">
                <input type="hidden" name="checkout" value="<?php echo e(request()->get('checkout')); ?>">
                <div class="col-md-12 border p-1 px-0 bg-secondary mb-1">
                    <h4 class="text-center text-capitalize">Danh sách phòng</h4>
                </div>
                <div class="col-md-12 mt-3 table-responsive"  style="max-height: 55vh">
                    <table class="table table-bordered table-striped table-hover" style="min-width: 100%; width: max-content">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên phòng</th>
                            <th scope="col">Loại phòng</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Bảng giá</th>
                            <th scope="col">Số giường</th>
                            <th scope="col">Sức chứa</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th scope="row"><?php echo e($room['room']['id']); ?></th>
                                <td><?php echo e($room['room']['name']); ?></td>
                                <td><?php echo e($room['room']['roomType']['name']); ?></td>
                                <td><?php echo e(RoomStatus::getValue($room['room']['status'])); ?></td>
                                <td>
                                    <?php $__currentLoopData = $room['room']['roomType']['roomPrices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($price['type_price'] == PriceType::ListedHourPrice['value']): ?>
                                            <li>
                                                <?php echo e(PriceType::ListedHourPrice['text'] . ': '); ?>

                                                <p class="text-danger m-0">
                                                    <?php echo e(number_format($price['price'], 0, ',', '.')); ?>

                                                    VND/phòng/<?php echo e(PriceType::ListedDayPrice['type']); ?>

                                                </p>
                                            </li>
                                        <?php elseif($price['type_price'] == PriceType::ListedDayPrice['value']): ?>
                                            <li>
                                                <?php echo e(PriceType::ListedDayPrice['text'] .': '); ?>

                                                <p class="text-danger m-0">
                                                    <?php echo e(number_format($price['price'], 0, ',', '.')); ?>

                                                    VND/phòng/<?php echo e(PriceType::ListedDayPrice['type']); ?>

                                                </p>
                                            </li>
                                        <?php elseif($price['type_price'] == PriceType::First2Hours['value']): ?>
                                            <li>
                                                <?php echo e(PriceType::First2Hours['text'] .': '); ?>

                                                <p class="text-danger m-0">
                                                    <?php echo e(number_format($price['price'], 0, ',', '.')); ?>

                                                    VND/phòng/<?php echo e(PriceType::First2Hours['type']); ?>

                                                </p>
                                            </li>
                                        <?php elseif($price['type_price'] == PriceType::EarlyCheckIn['value']): ?>
                                            <li>
                                                <?php echo e(PriceType::EarlyCheckIn['text'] .': '); ?>

                                                <p class="text-danger m-0">
                                                    <?php echo e(number_format($price['price'], 0, ',', '.')); ?>

                                                    VND/phòng/<?php echo e(PriceType::EarlyCheckIn['type']); ?>

                                                </p>
                                            </li>
                                        <?php elseif($price['type_price'] == PriceType::LateCheckOut['value']): ?>
                                            <li>
                                                <?php echo e(PriceType::LateCheckOut['text'] .': '); ?>

                                                <p class="text-danger m-0">
                                                    <?php echo e(number_format($price['price'], 0, ',', '.')); ?>

                                                    VND/phòng/ <?php echo e(PriceType::LateCheckOut['type']); ?>

                                                </p>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <ul>
                                        <?php if($room['single_bed'] > 0): ?>
                                            <li>Giường đơn: x <?php echo e($room['single_bed']); ?></li>
                                        <?php endif; ?>

                                        <?php if($room['double_bed'] > 0): ?>
                                            <li>Giường đôi: x <?php echo e($room['double_bed']); ?></li>
                                        <?php endif; ?>

                                        <?php if($room['twin_bed'] > 0): ?>
                                            <li>Giường cặp: x <?php echo e($room['twin_bed']); ?></li>
                                        <?php endif; ?>

                                        <?php if($room['family_bed'] > 0): ?>
                                            <li>Giường gia đình: x <?php echo e($room['family_bed']); ?></li>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                                <td>
                                    <p class="m-0"><?php echo e($room['adult_capacity']); ?> người lớn và <?php echo e($room['children_capacity']); ?> trẻ em</p>
                                </td>
                                <td>
                                    <div class="form-check m-0 justify-content-center">
                                        <input class="form-check-input" name="rooms[]" type="checkbox" value="<?php echo e($room['room']['id']); ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="row">
                            <h4 class="col-md-12 bg-secondary p-1 text-center text-capitalize">Thông tin người nhận phòng</h4>
                        <div class="col-md-12 m-auto py-2">
                            <div class="row">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Khách hàng</span>
                                    </div>
                                    <select class="form-control selectpicker" name="user_id" data-live-search="true"
                                             id="userSelect" data-style="bg-white border border-left-0">
                                        <option value="">Khách vãng lai</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php echo e(old('user_id') == $user['id'] ? 'selected' : ''); ?> value=<?php echo e($user['id']); ?>>
                                                <?php echo e($user->customer?->name); ?>:
                                                <?php echo e($user['phone']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số điện thoại</span>
                                    </div>
                                    <input type="text" class="customer-info form-control col-md-7"
                                           name="phone" id="phone" value="<?php echo e(old('phone')); ?>">
                                </div>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Họ tên</span>
                                    </div>
                                    <input type="text" class="customer-info form-control col-md-7"
                                           name="name" id="name" value="<?php echo e(old('name')); ?>">
                                </div>
                                <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Quốc tịch</span>
                                    </div>
                                    <input type="text" class=" customer-info form-control col-md-7"
                                           name="country" id="country" value="<?php echo e(old('country')); ?>">
                                </div>
                                <?php $__errorArgs = ['citizen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số CCCD</span>
                                    </div>
                                    <input type="text" class="customer-info form-control col-md-7"
                                           name="citizen_id" id="citizen_id" value="<?php echo e(old('citizen_id')); ?>">
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Giới tính</span>
                                    </div>
                                    <select class="form-select" name="gender" id="gender">
                                        <?php $__currentLoopData = UserGender::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                <?php echo e(old('gender') == $gender ? 'selected' : ''); ?> value=<?php echo e($gender); ?>>
                                                <?php echo e($gender == UserGender::Male ? 'Nam' : 'Nữ'); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Đã thanh toán (VND)</span>
                                    </div>
                                    <input type="number" class="form-control col-md-7" name="deposit" min="0"
                                           value="<?php echo e(old('deposit')); ?>">
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Thanh toán bằng</span>
                                    </div>
                                    <select class="form-control selectpicker" name="payment"
                                            data-style="bg-white border border-left-0">
                                        <?php $__currentLoopData = PaymentType::getPaymentType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option data-icon="<?php echo e($payment['icon']); ?>"
                                                    <?php echo e(old('payment') == $payment ? 'selected' : ''); ?> value=<?php echo e($payment['type']); ?>>
                                                <?php echo e($payment['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Đặt phòng qua</span>
                                    </div>
                                    <select class="form-select" name="type"
                                            data-style="bg-white border border-left-0">
                                        <?php $__currentLoopData = BookingType::createTypeForAdmin(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php echo e(old('type') == $type ? 'selected' : ''); ?> value=<?php echo e($type); ?>>
                                                <?php
                                                    $typeName = match ($type) {
                                                     BookingType::OnSociety => 'Mạng xã hội',
                                                     BookingType::OffLine => 'Tại quầy lễ tân'
                                                    };
                                                    echo $typeName;
                                                ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Đặt phòng cho</span>
                                    </div>
                                    <select class="form-select" name="for_relative"
                                            data-style="bg-white border border-left-0">
                                            <option <?php echo e(old('for_relative') == "0" ? 'selected' : ''); ?> value="0">
                                                Chính chủ
                                            </option>
                                        <option <?php echo e(old('for_relative') == "0" ? 'selected' : ''); ?> value="1">
                                            Người thân
                                        </option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['adults'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số người lớn</span>
                                    </div>
                                    <input type="number" class="form-control col-md-7" name="adults" min="0"
                                           value="<?php echo e(old('adults')); ?>">
                                </div>
                                <?php $__errorArgs = ['children'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số trẻ em</span>
                                    </div>
                                    <input type="number" class="form-control col-md-7" name="children"
                                           value="<?php echo e(old('children')); ?>">
                                </div>
                                <?php $__errorArgs = ['deposit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-2 p-0">
                                        <span class="input-group-text w-100">Ghi chú</span>
                                    </div>
                                    <textarea name="note" cols="1" rows="2" class="form-control col-md-10">
                                        <?php echo e(old('note')); ?>

                                </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center border-top py-4">
                            <button type="submit" id="submit-btn" class="btn btn-success">Đặt phòng</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $('#userSelect').change(function() {
                const id = $(this).val();
                if (id === '') {
                    // Reset các trường input của form khi id là null
                    resetForm();
                } else {
                    $.ajax({
                        url: '<?php echo e(route("admin.users.show", ':id')); ?>'.replace(':id', id),
                        type: 'GET',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                        },
                        success: function(response) {
                            // Xử lý response từ server
                            $('#name').val(response.name);
                            $('#phone').val(response.phone);
                            $('#country').val(response.country);
                            $('#citizen_id').val(response.citizen_id);
                            $('#gender').val(response.gender);
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Xử lý lỗi nếu có
                            console.error(error);
                            // Reset các trường input của form khi có lỗi
                            resetForm();
                        }
                    });
                }
            });
        });

        function resetForm() {
            // Lấy tất cả các input và select trong form
            var formElements = $('.customer-info');

            // Duyệt qua từng phần tử và reset giá trị
            formElements.each(function() {
                    $(this).val('');
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/bookings/create.blade.php ENDPATH**/ ?>