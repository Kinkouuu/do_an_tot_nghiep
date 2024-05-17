<?php

namespace App\Services\User;

use App\Models\Branch;
use App\Services\BaseService;

class BranchService extends BaseService
{
    public function getModel()
    {
        return Branch::class;
    }

    /**
     * Lấy danh sách các tỉnh thành có chi nhánh khách sạn
     * @return array
     */
    public function getBranchCities(): array
    {
        $data = [];

        $cities = Branch::distinct('city')->pluck('city');
        $branches = $this->all();

        foreach ($cities as $city) {
            $data[] = $branches->filter(function ($item) use ($city) {
                return $item['city'] == $city;
            });
        }
        return $data;

    }
}
