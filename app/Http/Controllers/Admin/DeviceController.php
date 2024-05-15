<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeviceRequest;
use App\Models\Device;
use App\Models\TypeDevice;
use App\Services\Admin\DeviceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeviceController extends Controller
{
    protected DeviceService $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $allDevices = $this->deviceService->all();
        $devices = $this->deviceService->getUsingDevices($allDevices, $request->all());

        return view('admin.pages.devices.index', [
            'title' => 'Danh sách thiết bị',
            'devices' => $devices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function create()
    {
        $typeDevices = TypeDevice::all()->sortBy('name');
        return view('admin.pages.devices.create', [
            'title' => 'Danh sách thiết bị',
            'typeDevices' => $typeDevices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeviceRequest $request
     * @return RedirectResponse
     */
    public function store(DeviceRequest $request)
    {
        $response = $this->deviceService->storeDevice($request->except('__token'));

        return $this->showAlertAndRedirect($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Device $devices
     * @return Response
     */
    public function show(Device $devices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Device $devices
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(Device $device)
    {
        $typeDevices = TypeDevice::all()->sortBy('name');
        return view('admin.pages.devices.edit', [
            'title' => 'Cập nhật thiết bị',
            'device' => $device,
            'typeDevices' => $typeDevices
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeviceRequest $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function update(DeviceRequest $request, Device $device)
    {
        $response = $this->deviceService->updateDevice($request->except('_token','_method'), $device);

        return $this->showAlertAndRedirect($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $devices
     * @return Response
     */
    public function destroy(Device $devices)
    {
        //
    }
}
