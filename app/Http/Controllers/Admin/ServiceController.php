<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Models\TypeService;
use App\Services\Admin\ServiceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    protected ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $services = $this->serviceService->filter($request->all());

        return view('admin.pages.services.index', [
            'title' => 'Danh sách dịch vụ',
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function create()
    {
        $typeServices = TypeService::all()->sortBy('name');

        return view('admin.pages.services.create', [
            'title' => 'Thêm dịch dịch vụ mới',
            'typeServices' => $typeServices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return RedirectResponse
     */
    public function store(ServiceRequest $request)
    {
       $this->serviceService->create($request->except('_token'));

       return $this->showAlertAndRedirect($this->serviceService->successResponse(
           title: 'Thêm dịch vụ mới thành công',
           nextUrl: 'admin.services.index'
       ));
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(Service $service)
    {
        $typeServices = TypeService::all()->sortBy('name');

        return view('admin.pages.services.edit', [
            'title' => 'Cập nhật dịch vụ',
            'service' => $service,
            'typeServices' => $typeServices
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param Service $service
     * @return RedirectResponse
     */
    public function update(ServiceRequest $request, Service $service)
    {
      $this->serviceService->update($request->except('_token', '_method'), $service->id);

        return $this->showAlertAndRedirect($this->serviceService->successResponse(
            title: 'Cập nhật dịch vụ thành công!',
            nextUrl: 'admin.services.index'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return array
     */
    public function destroy(Service $service)
    {
        return $this->serviceService->deleteService($service);
    }
}
