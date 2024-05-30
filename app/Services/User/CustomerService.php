<?php

namespace App\Services\User;

use App\Enums\RoleAccount;
use App\Models\Customer;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class CustomerService extends BaseService
{
    public function getModel()
    {
        return Customer::class;
    }

    /**
     * get data customer by account user id
     * @param $userID
     * @return Customer|null
     */
    public function getByUserID($userID): ?Customer
    {
         return Customer::where('user_id', $userID)->first();
    }

    /**
     * @param array $data
     * @return array
     */
    public function createCustomer(array $data): array
    {
       $data['user_id'] = Auth::user()->id;
       $data['created_by'] = RoleAccount::Customer;
       DB::beginTransaction();

        try {
            $this->create($data);
            DB::commit();
            return $this->successResponse('Thêm thông tin cá nhân thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Customer $customerID
     * @param array $data
     * @return array
     */
    public function updateCustomer(Customer $customerID, array $data): array
    {
        DB::beginTransaction();
        try {
            $this->update($data, $customerID->id);
            DB::commit();
            return $this->successResponse('Cập nhật thông tin cá nhân thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Customer|null $customer
     * @return array
     */
    public function retrieveCustomerData(?Customer $customer): array
    {
        return [
            'name' => $customer->name ?? null,
            'address' => $customer->address ?? null,
            'country' => $customer->country ?? null,
            'gender' => $customer->gender ?? null,
            'citizen_id' => $customer->citizen_id ?? null,
            'birth_day' => $customer->birth_day ?? null,
        ];
    }
}
