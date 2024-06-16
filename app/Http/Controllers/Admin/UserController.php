<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\Admin\CustomerService;
use App\Services\Admin\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected UserService $userService;
    protected CustomerService $customerService;

    public function __construct(UserService $userService, CustomerService $customerService)
    {
        $this->userService = $userService;
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = $this->userService->filter($request->all());
        return view('admin.pages.users.index', [
            'title' => 'Tài khoản người dùng',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $user = $this->userService->find($id);

        return [
            'email' => $user->email,
            'phone' => $user->phone,
            'name' => $user->customer?->name,
            'country' => $user->customer?->country,
            'citizen_id' => $user->customer?->citizen_id,
            'gender' => $user->customer?->gender,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(User $user)
    {
        return view('admin.pages.users.edit', [
           'title' => "Cập nhật thông tin người dùng",
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {

        $this->userService->update([
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'status' => $request->get('status')
        ], $user->id);

        if($user->customer?->id) {
            $this->customerService->updateCustomer($request->all(),$user->customer?->id, $user->id);
        } else {
            $this->customerService->createCustomer($request->all(), $user->id);
        }

        return $this->showAlertAndRedirect([
           'status' => ResponseStatus::Success,
            'title' => 'Cập nhật thông tin tài khoản thành công'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
