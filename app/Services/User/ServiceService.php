<?php

namespace App\Services\User;

use App\Enums\Service\ServiceStatus;
use App\Models\Service;
use App\Services\BaseService;

class ServiceService extends BaseService
{
    public function getModel()
    {
        return Service::class;
    }

    /**
     * Lấy danh sách các dịch vụ đang cung cấp
     * @return mixed
     */
    public function getActiveService(): mixed
    {
       return Service::where('status', ServiceStatus::Active)->get();
    }
}
