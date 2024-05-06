<?php

namespace App\Services\Admin;

use App\Models\Device;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;

class DeviceService extends BaseService
{
    public function getModel()
    {
        return Device::class;
    }

    /**
     * Store new device
     * @param array $request
     * @return array
     */
    public function storeDevice(array $request): array
    {
        DB::beginTransaction();
        try {
            $this->create($request);
            DB::commit();
            return $this->successResponse(title:'Thêm thiết bị thành công', nextUrl: 'admin.devices.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param array $request
     * @param Device $device
     * @return array
     */
    public function updateDevice(array $request, Device $device): array
    {
        DB::beginTransaction();
        try {
            $this->update($request, $device->id);
            DB::commit();
            return $this->successResponse(title:'Cập nhật thiết bị thành công', nextUrl: 'admin.devices.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }
}
