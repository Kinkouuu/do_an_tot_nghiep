<?php

namespace App\Services\User;

use App\Enums\Service\ServiceStatus;
use App\Models\TypeService;
use App\Services\BaseService;

class ServiceTypeService extends BaseService
{
    public function getModel()
    {
        return TypeService::class;
    }

    /**
     * Lấy danh sách loại dịch vụ và dịch vụ đang cung cấp tương ứng
     * @return array
     */
    public function getServiceList(): array
    {
        $data = [];
        $allType = TypeService::orderBy('name', 'ASC')->get();

        foreach ($allType as $type) {
            $services = [];
            foreach ($type->services as $service) {
                if ($service->status == ServiceStatus::Active) {
                    $services[] = [
                        'id' => $service->id,
                        'name' => $service->name,
                    ];
                }
            }
            // Lấy mảng chứa các giá trị 'name' để sắp xếp
            $names = array_column($services, 'name');

            // Sắp xếp mảng $array theo mảng $names
            array_multisort($names, SORT_ASC, $services);
            $data[] = [
                'icon' => $type->icon,
                'name' => $type->name,
                'services' => $services,
            ];
        }

        return $data;
    }
}
