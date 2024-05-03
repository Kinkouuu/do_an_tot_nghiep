<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\User\CustomerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @param $userID
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function getUserInfo()
    {
        $user = Auth::user();
        $userInfo = $this->customerService->getByUserID($user->id);
        $customer = $this->customerService->retrieveCustomerData($userInfo);

        return view('user.pages.personal-information', [
            'page_title' => 'Personal Information',
            'page_description' => 'Reputable & Confidential',
            'customer' => $customer
        ]);
    }

    public function updateUserInfo(CustomerRequest $request)
    {
        $user = Auth::user();
//        dd($request->all());
        $userInfo = $this->customerService->getByUserID($user->id);
        if($userInfo) {
            $response = $this->customerService->updateCustomer($userInfo, $request->except('_token'));
        } else {
           $response =  $this->customerService->createCustomer($request->except('_token'));
        }

        return $this->showAlertAndRedirect($response);
    }
}
