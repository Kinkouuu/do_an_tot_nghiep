<?php

namespace App\Http\Controllers\User;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\User\CustomerService;
use App\Services\User\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    protected CustomerService $customerService;
    protected UserService $userService;

    public function __construct(CustomerService $customerService, UserService $userService)
    {
        $this->customerService = $customerService;
        $this->userService = $userService;
    }

    /**
     * @param $userID
     * @return Application|Factory|View
     */
    public function getUserInfo()
    {
        $user = Auth::user();
        $userInfo = $this->customerService->getByUserID($user->id);
        $customer = $this->customerService->retrieveCustomerData($userInfo);

        return view('user.pages.personal-information', [
            'page_title' => 'Personal Information',
            'page_description' => 'Reputable & Confidential',
            'email' => $user->email,
            'phone' => $user->phone,
            'customer' => $customer
        ]);
    }

    public function updateUserInfo(CustomerRequest $request)
    {
        $user = Auth::user();
        $userInfo = $this->customerService->getByUserID($user->id);

        if($userInfo) {
            $response = $this->customerService->updateCustomer($userInfo, $request->except('_token', 'email'));
        } else {
           $response =  $this->customerService->createCustomer($request->except('_token', 'email'));
        }
        if($request->has('email') && $response['status'] == ResponseStatus::Success)
        {
            $this->userService->update(['email' => $request->get('email')], $user->id);
        }

        return $this->showAlertAndRedirect($response);
    }
}
