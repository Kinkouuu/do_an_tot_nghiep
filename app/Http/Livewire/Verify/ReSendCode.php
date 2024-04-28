<?php

namespace App\Http\Livewire\Verify;

use App\Services\User\AuthService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReSendCode extends Component
{
    public $title = 'Bạn chưa nhận được mã xác thực?';

    public $showButton = true;

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function render(): View|Factory|\Illuminate\View\View|Application
    {
        return view('livewire.verify.reSendCode',);
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function reSend(): void
    {
        $this->title = 'Gửi lại mã sau 3 phút.';
        $this->showButton = false;

        $authService = app()->make(AuthService::class);
        $authService->reSendVerifyCode();
    }

    /**
     * @return void
     */
    public function showButton(): void
    {
        $this->title = 'Gửi lại mã xác thực.';
        $this->showButton = true;
    }
}
