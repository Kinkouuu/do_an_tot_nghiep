<?php

namespace App\Http\Livewire\Room;

use App\Enums\ResponseStatus;
use App\Enums\UserStatus;
use App\Services\User\BookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class BookingForm extends Component
{
    protected BookingService $bookingService;
    public $condition;
    public $roomBranch;
    public $time;
    public $account;
    public $password;
    public $forRelative = false;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->bookingService = app()->make(BookingService::class);
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.room.booking-form',[
            'user' => $user
        ]);
    }

    protected function loginRules()
    {
        return [
            'account' => 'required|numeric|starts_with:0|digits:10',
            'password' => 'required|min:6'
        ];
    }
    public function login()
    {
        $this->validate($this->loginRules());
        if (Auth::attempt([
            'phone' => $this->account,
            'password' => $this->password,
            'status' => UserStatus::Active
        ])) {
            $this->showAlert(ResponseStatus::Success, 'Đăng nhập thành công!', 'Đặt phòng ngay thôi.');
//            $this->dispatchBrowserEvent('close-modal', ['modalId' => 'needLogin']);
        } else {
            $this->showAlert(ResponseStatus::Error, 'Tài khoản hoặc mật khẩu sai!');
            $this->resetInput();
        }
    }

    public function showAlert($status, $title = null, $text = null)
    {
        $this->dispatchBrowserEvent('show-alert', [
            'title' => $title,
            'text' => $text,
            'icon' => $status
        ]);
    }

    /**
     * Trigger switch button thông tin người đặt phòng
     * @return void
     */
    public function forRelative(): void
    {
        $this->forRelative = !$this->forRelative;
    }

    /**
     * Reset lại dữ liệu form input
     * @return void
     */
    public function resetInput(): void
    {
        $this->resetExcept(['roomBranch', 'time']);
    }

    public function bookingConfirm($userId)
    {
       Cache::put('cart_' . $userId, [
           'branch' => $this->roomBranch['branch'],
           'rooms' => $this->roomBranch['rooms'],
           'total_amount' => $this->roomBranch['total_amount'],
           'condition' => $this->condition,
       ]);
        return redirect()->route('booking.confirm');
    }
}
