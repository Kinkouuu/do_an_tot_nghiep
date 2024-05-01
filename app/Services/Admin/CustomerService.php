<?php

namespace App\Services\Admin;

use App\Models\Customer;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerService extends BaseService
{
    public function getModel()
    {
        return Customer::class;
    }

    /**
     * @param array $request
     * @param int $customerID
     * @param int|null $userID
     * @return array
     */
    public function updateCustomer(array $request,int $customerID, ?int $userID): array
    {
        $data = [
            'user_id' => $userID,
            'name' => $request['name'],
            'address' => $request['address'],
            'country' => $request['country'],
            'gender' => $request['gender'],
            'citizen_id' => $request['citizen_id'],
            'birth_day' => $request['birth_day']
        ];
        $this->update($data, $customerID);

        return $this->successResponse('Cập nhật thông tin khách hàng thành công');
    }

    /**
     * @param array $request
     * @param int|null $userID
     * @return array
     */
    public function createCustomer(array $request, ?int $userID): array
    {
        $data = [
            'user_id' => $userID,
            'name' => $request['name'],
            'address' => $request['address'],
            'country' => $request['country'],
            'gender' => $request['gender'],
            'citizen_id' => $request['citizen_id'],
            'birth_day' => $request['birth_day'],
            'created_by' => Auth::guard('admins')->user()->account_name
        ];
        $this->create($data);

        return $this->successResponse('Thêm thông tin khách hàng thành công', null, 'admin.customers.index');
    }

    /**
     * @param Customer $customer
     * @return array
     */
    public function deleteCustomer(Customer $customer): array
    {
        DB::beginTransaction();
        try {
            $this->delete($customer->id);
            DB::commit();
            return $this->successResponse('Xóa thông tin thành công!');
        } catch (\Exception $e)
        {
            DB::rollBack();
            return $this->errorResponse('Có lỗi xảy ra!', 'Vui lòng thử lại');
        }
    }
}
