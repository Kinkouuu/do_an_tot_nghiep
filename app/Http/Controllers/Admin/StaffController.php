<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAccountRequest;
use App\Models\Admin;
use App\Services\Admin\StaffService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    protected StaffService $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $staffs = $this->staffService->filter($request->all());

        return view('admin.pages.staff.index', [
            'title' => 'Tài khoản nhân viên',
            'staffs' => $staffs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function create()
    {
        return view('admin.pages.staff.create', [
            'title' => 'Thêm tài khoản nhân viên mới'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminAccountRequest $request
     * @return RedirectResponse
     */
    public function store(AdminAccountRequest $request)
    {
       $response = $this->staffService->createStaffAccount($request->all());
       return $this->showAlertAndRedirect($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Admin $admin
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(Admin $staff)
    {
        return view('admin.pages.staff.edit', [
            'title' => "Cập nhật thông tin nhân viên",
            'staff' => $staff
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminAccountRequest $request
     * @param Admin $staff
     * @return RedirectResponse
     */
    public function update(AdminAccountRequest $request, Admin $staff)
    {
        $this->staffService->update($request->all(), $staff->id);

        return $this->showAlertAndRedirect($this->staffService->successResponse(
            title: 'Thêm tài khoản thành công!',
            nextUrl: 'admin.staffs.index'
        ));
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

    public function resetPassword(Request $request, Admin $staff)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            're-password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();

            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Error,
                'title' => $error
            ]);
        }

        $this->staffService->update(['password' => Hash::make($request->get('password'))], $staff->id);

        return  $this->showAlertAndRedirect([
           'status' => ResponseStatus::Success,
           'title' => 'Cập lại mật khẩu thành công',
           'message' => 'Target account: '. $staff->account_name
        ]);
    }
}
