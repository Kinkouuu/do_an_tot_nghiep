<?php

namespace App\Services\User;

use App\Models\Branch;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class BranchService extends BaseService
{
    public function getModel()
    {
        return Branch::class;
    }

    /**
     * Lấy danh sách các tỉnh thành có chi nhánh khách sạn
     * @return Collection
     */
    public function getBranchCities(): Collection
    {
        return Branch::distinct('city')->orderBy('city', 'ASC')->pluck('city');
    }

    /**
     * Lấy danh sách chi nhánh sắp xếp theo tỉnh thành
     * @return array
     */
    public function getBranches(): array
    {
         $data = [];
         $cities = $this->getBranchCities();
         $branches = $this->all();
        foreach ($cities as $city) {
            $data[] = $branches->filter(function ($item) use ($city) {
                return $item['city'] == $city;
            });
        }
        return $data;
    }

    /**
     * Group các phòng theo chi nhánh
     * @param Collection $emptyRooms
     * @return mixed
     */
    public function groupRoomByBranch(Collection $emptyRooms): mixed
    {
        return array_reduce($emptyRooms->toArray(), function($result, $item) {
            $branchId = $item['branch_id'];
            if (!array_key_exists($branchId, $result)) {
                $branch = $this->find($branchId);
                $result[$branchId]['branch'] = $branch;
            }
            $result[$branchId]['rooms'][] = $item;
            return $result;
        }, []);
    }
}
