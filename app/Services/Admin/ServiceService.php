<?php

namespace App\Services\Admin;

use App\Enums\Service\ServiceStatus;
use App\Models\Service;
use App\Models\TypeService;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class ServiceService extends BaseService
{
    public function getModel()
    {
        return Service::class;
    }

    /**
     * Delete service
     * @param Service $service
     * @return array
     */
    public function deleteService(Service $service): array
    {
        DB::beginTransaction();
        try {
            $this->delete($service->id);
            DB::commit();
            return $this->successResponse('Xóa thông tin thành công!');
        } catch (\Exception $e)
        {
            DB::rollBack();
            return $this->errorResponse('Có lỗi xảy ra!', 'Vui lòng thử lại');
        }
    }

    /**
     * Lấy các loại dich vụ đang cung cấp
     * @return mixed
     */
    public function getActiveTypeServices(): mixed
    {
        return TypeService::has('services', '>' , 0)->with(['services' => function ($query) {
            $query->where('status',  ServiceStatus::Active);
        }])->get();
    }
}
