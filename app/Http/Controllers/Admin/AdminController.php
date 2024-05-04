<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AdminService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Show admin login page
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function login()
    {
        return view('admin.pages.login');
    }

    /**
     * Start admin|manger|employee session
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function signin(LoginRequest $request)
    {
        $response = $this->adminService->adminAuthenticate($request->all());
        return $this->showAlertAndRedirect($response);
    }

    /**
     *
     */
    public function logout()
    {
        Auth::guard('admins')->logout();
        return redirect()->route('admin.login');
    }

    /**
     * Show admin dashboard page
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.pages.dashboard');
    }
}
