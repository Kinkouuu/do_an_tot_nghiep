<?php

namespace App\Services;

use App\Enums\FilterType;
use App\Enums\ResponseStatus;

abstract class BaseService
{
    protected $model;

    //gán con trỏ tới model trong service được kế thừa
    public function __construct()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    //tạo 1 hàm trừu tượng
    abstract public function getModel();

    //lấy tất cả các dữ liệu từ modal
    public function all()
    {
        return $this->model->all();
    }

    // lấy dang sách theo phân trang
    public function pagination(?int $number = 15)
    {
        return $this->model->orderBy('id', 'DESC')->paginate($number);
    }

    //tìm 1 cột theo id
    public function find($id)
    {
        return $this->model->find($id);
    }

    //thêm data vào model
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    //cập nhập data theo id
    public function update(array $data,$id)
    {
        return $this->model->where('id',$id)->update($data);
    }

    //xóa data theo id
    public function delete($id)
    {
        return $this->model->where('id',$id)->delete();
    }

    public function filter(?int $type, $data) {
        $query = $this->model->query();
        switch ($type) {
            case FilterType::SortBy:
                 $query->orderBy($data['by'], $data['sort']);
                 break;
            case FilterType::Status:
                 $query->where('status', $data['status']);
                 break;
            case FilterType::Search:
                foreach ($data['columns'] as $columns)
                {
                    $query->orWhere($columns, 'like', '%' . $data['value'] .'%');
                }
                break;
        }
        return $query->get();
    }

    /**
     * render success response
     * @param string|null $title
     * @param string|null $message
     * @return array
     */
    public function successResponse(?string $title = null, ?string $message = null, ?string $nextUrl = null): array
    {
        return [
            'status' => ResponseStatus::Success,
            'title' => $title,
            'message' => $message,
            'nextUrl' => $nextUrl
        ];
    }

    /**
     * render error response
     * @param string|null $message
     * @return array
     */
    public function errorResponse(?string $title = null, ?string $message = null): array
    {
        return [
            'status' => ResponseStatus::Error,
            'title' => $title,
            'message' => $message
        ];
    }
}
