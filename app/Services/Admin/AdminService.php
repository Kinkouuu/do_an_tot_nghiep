<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Models\Admin;

class AdminService extends BaseService
{

    public function getModel()
    {
        return Admin::class;
    }
}
