<?php

namespace App\Services\User;

use App\Enums\RoleAccount;
use App\Models\Customer;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

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
     * @param $data
     * @return array
     */
    public function createCustomer(array $data): array
    {
       $data['user_id'] = Auth::user()->id;
       $data['created_by'] = RoleAccount::Customer;
       $this->create($data);

       return $this->successResponse('Thêm thông tin cá nhân thành công');
    }

    public function updateCustomer(Customer $customerID, array $data)
    {
        $this->update($data, $customerID->id);
        return $this->successResponse('Cập nhật thông tin cá nhân thành công');
    }

    /**
     * @param Customer|null $customer
     * @return array
     */
    public function retriveCustomerData(?Customer $customer): array
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
