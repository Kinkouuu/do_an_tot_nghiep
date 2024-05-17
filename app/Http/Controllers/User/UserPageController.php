<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Services\User\BranchService;
use App\Services\User\RoomTypeService;
use App\Services\User\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
{
    protected UserService $userService;
    protected RoomTypeService $roomTypeService;
    protected BranchService $branchService;

    public function __construct(UserService $userService, RoomTypeService $roomTypeService, BranchService $branchService)
    {
        $this->userService = $userService;
        $this->roomTypeService = $roomTypeService;
        $this->branchService = $branchService;
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        $branches = $this->branchService->getBranchCities();
        return view('user.pages.home', [
            'page_title' => 'Welcome To V.V.C',
            'page_description' => 'TRAVEL & VACATION',
            'room_types' => $roomTypes,
            'branches' => $branches,
        ]);
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function introduce()
    {
        return view('user.pages.introduce', [
            'page_title' => 'About Us',
            'page_description' => 'Inspirational Story'
        ]);
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function contact()
    {
        $user = $this->userService->retrieveUserData();
        return view('user.pages.contact', [
            'page_title' => 'Get In Touch',
            'page_description' => 'Chat With Us',
            'user' => $user
        ]);
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function login()
    {
        return view('user.pages.login');
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function signup()
    {
        return view('user.pages.signup');
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function verifyCode()
    {
        $response = $this->userService->showVerifyPage();
        return view('user.pages.verify-code',
        [
            'response' => $response
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function reActiveAccount()
    {
       $user = Auth::user();
       if($user->status != UserStatus::Cancelled)
       {
           return redirect()->route('login');
       }

       $response = $this->userService->reActiveUser($user);
       return $this->showAlertAndRedirect($response);
    }

    public function forgotPassword()
    {
        return view('user.pages.forgot-password');
    }

    public function changePassword()
    {
        return view('user.pages.change-password');
    }
}
