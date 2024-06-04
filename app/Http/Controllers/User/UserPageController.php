<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Services\User\BranchService;
use App\Services\User\RoomService;
use App\Services\User\RoomTypeService;
use App\Services\User\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserPageController extends Controller
{
    protected UserService $userService;
    protected RoomTypeService $roomTypeService;
    protected BranchService $branchService;
    protected RoomService $roomService;

    public function __construct(
        UserService     $userService,
        RoomTypeService $roomTypeService,
        BranchService   $branchService,
        RoomService     $roomService
    )
    {
        $this->userService = $userService;
        $this->roomTypeService = $roomTypeService;
        $this->branchService = $branchService;
        $this->roomService = $roomService;
    }

    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        $branches = $this->branchService->getBranches();
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
        return view('user.pages.authentication.login');
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
        return view('user.pages.authentication.verify-code',
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
        if ($user->status != UserStatus::Cancelled) {
            return redirect()->route('login');
        }

        $response = $this->userService->reActiveUser($user);
        return $this->showAlertAndRedirect($response);
    }

    public function forgotPassword()
    {
        return view('user.pages.authentication.forgot-password');
    }

    public function changePassword()
    {
        return view('user.pages.authentication.change-password');
    }

    public function search(Request $request)
    {
        $allBranches = $this->branchService->getBranchCities();

        $validator = Validator::make($request->all(), [
            'city' => ['required', 'string',Rule::in($allBranches->toArray())],
            'adults' => 'required|numeric|min:1',
            'children' => ['required', 'numeric', 'min:1', 'lte:' . $request->get('adults') * 2],
            'checkin' => ['required', 'date', 'after:' . Carbon::now()->toDateTimeString()],
            'checkout' => ['required', 'date', 'after:' . Carbon::now()->addHours(2)->toDateTimeString()],
        ]);

        if ($validator->fails()) {
            Alert::warning('Yêu cầu không phù hợp');
            return redirect()->route('homepage');
        }

        $data = $request->except('_token');
        $checkInAt = Carbon::parse($request['checkin']);
        $checkOutAt = Carbon::parse($request['checkout'])   ;
        $time = $checkOutAt->diffInHours($checkInAt);
        $roomList = $this->roomService->searchByCondition($data);
        $roomsOfBranch = $this->branchService->groupRoomByBranch($roomList);
        $allocateRooms = $this->roomService->allocateRooms($roomsOfBranch, $data, $time);

        return view('user.pages.rooms.response-search-list', [
            'page_title' => 'Best choice for your trip',
            'time' => $time,
            'roomBranches' => $allocateRooms,
            'condition' => $data,
        ]);
    }
}
