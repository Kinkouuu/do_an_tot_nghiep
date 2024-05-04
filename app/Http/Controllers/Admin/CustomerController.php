<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FilterType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;
use App\Services\Admin\CustomerService;
use App\Services\Admin\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $customers = $this->customerService->filter($request->all());
        return view('admin.pages.customers.index', [
            'title' => 'Danh sách khách hàng',
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function create()
    {
        return view('admin.pages.customers.create',[
            'title' => 'Thêm khách hàng mới',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @return RedirectResponse
     */
    public function store(CustomerRequest $request)
    {
        $user = null;
        if ($request->has('email') && $request->has('phone') )
        {
            $user = $this->userService->adminCreateOrUpdateUserAccount($request->all());
        }
        $response = $this->customerService->createCustomer($request->all(), $user?->id);
        return $this->showAlertAndRedirect($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(Customer $customer)
    {
        return view('admin.pages.customers.edit', [
            'title' => 'Cập nhật thông tin khách hàng',
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $user = null;
        if ($request->has('email') && $request->has('phone') )
        {
            $user = $this->userService->adminCreateOrUpdateUserAccount($request->all());
        }
        $response =  $this->customerService->updateCustomer($request->all(), $customer->id, $user?->id);

        return $this->showAlertAndRedirect($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return array
     */
    public function destroy(Customer $customer)
    {
        return $this->customerService->deleteCustomer($customer);
    }
}
