<?php

namespace App\Services\Admin;

use App\Models\Device;
use App\Services\BaseService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

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

    /**
     * @param Collection $devices
     * @param array|null $request
     * @return LengthAwarePaginator
     */
    public function getUsingDevices(Collection $devices, ?array $request): LengthAwarePaginator
    {
        $data = [];
        foreach ($devices as $device) {
            $quantity = $this->getRentingAndUsingDevices($device);
            $data[] = [
                "id" => $device->id,
                "type_device" => $device->typeDevice->name,
                "name" => $device->name,
                "rental_price" =>  $device->rental_price,
                "quantity" => $device->quantity,
                "brand" => $device->brand,
                "for_rent" => $device->for_rent ? 'Cho thuê' : 'Không cho thuê',
                "equipping_quantity" => $quantity->equipping_quantity,
            ];
        }

        return $this->search($request, collect($data));
    }

    /**
     * Lấy số tổng lượng thiết bị đang được sử dụng | cho thuê
     * @param Device $device
     * @return object|null
     */
    public function getRentingAndUsingDevices(Device $device): object|null
    {
        return DB::table('device_room')->where('device_id', $device->id)
            ->selectRaw('SUM(quantity) as equipping_quantity')->first();
    }
}
