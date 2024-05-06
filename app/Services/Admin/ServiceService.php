<?php

namespace App\Services\Admin;

use App\Models\Service;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class ServiceService extends BaseService
{
    public function getModel()
    {
        return Service::class;
    }

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
}
