<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AdminService;
use App\Services\User\BranchService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected AdminService $adminService;
    protected BranchService $branchService;

    public function __construct(AdminService $adminService, BranchService $branchService)
    {
        $this->adminService = $adminService;
        $this->branchService = $branchService;
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
    public function index(Request $request)
    {
        $user = Auth::guard('admins')->user();
        if ($user->role == RoleAccount::Admin || is_null($user->branch_id))
        {
            $branches = $this->branchService->all()->sortBy('name');
        } else {
            $branches = $this->branchService->all()->where('id', $user->branch_id);
        }

        $data = $this->adminService->statisticalData($request->all());
        return view('admin.pages.dashboard', [
            'branches' => $branches,
            'data' => $data,
        ]);
    }
}
