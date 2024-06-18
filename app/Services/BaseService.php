<?php

namespace App\Services;

use App\Enums\ResponseStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

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

    //tìm theo id
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    //Tìm theo danh sách ids
    public function getByIds($ids)
    {
        return $this->model->whereIn('id', $ids);
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

    /**
     * Lọc & tìm kiếm & phân trang từ query DB
     * @param array $request
     * @return mixed
     */
    public function filter(array $request): mixed
    {
        $searchColumns = $this->model->getColumnsFilter();
        $query = $this->model->query();
        if(isset($request['sort']) && isset($request['by'])) {
            $query->orderBy($request['by'], $request['sort']);
        }
        if(isset($request['status']) && $request['status'] != null) {
            $query->whereIn('status', $request['status']);
        }
        if(isset($request['search'])) {
            foreach ($searchColumns as $column)
            {
                $query->orWhere($column, 'like', '%' . $request['search'] . '%');
            }
        }
        return $query->paginate(15);
    }

    /**
     * Lọc & tìm kiếm & phân trang dựa trên dữ liệu truyền vào
     * @param array|null $request
     * @param Collection $data
     * @return LengthAwarePaginator
     */
    public function search(?array $request, Collection $data): LengthAwarePaginator
    {
        $searchColumns = $this->model->getColumnsFilter();
        // Tìm kiếm
        if (isset($request['search'])) {
            $searchTerm = $request['search'];
            $data = $data->filter(function ($item) use ($searchColumns, $searchTerm) {
                foreach ($searchColumns as $value) {
                    if (stristr($item[$value], $searchTerm)) {
                        return true;
                    }
                }
                return false;
            });
        }
        //Sắp xếp theo bộ lọc
        if (isset($request['by']) && isset($request['sort'])) {
            $data = $data->sortBy($request['by'], null, $request['sort']);
        }
        // Lọc theo trạng thái
        if(isset($request['status'])) {
            $status = $request['status'];
            $data = $data->filter(function ($item) use ($status) {
                return in_array($item['status'] , $status);
            });
        }
        //Phân trang dữ liệu
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedData = $data->slice(($currentPage - 1) * config('constants.item_per_page'), config('constants.item_per_page'))->all();
        $paginatedCollection = new LengthAwarePaginator($paginatedData, count($data), config('constants.item_per_page'), $currentPage);

        $paginatedCollection->withPath(Request::url());

        return $paginatedCollection;
    }

    /**
     * render success response
     * @param string|null $title
     * @param string|null $message
     * @param string|null $nextUrl
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

    /**
     * @param string|null $title
     * @param string|null $message
     * @param string $nextUrl
     * @param string $code
     * @return array
     */
    public function questionResponse(string $nextUrl, string|int $code = null, ?string $title = null, ?string $message = null): array
    {
        return [
            'status' => ResponseStatus::Question,
            'nextUrl' => $nextUrl,
            'code' => $code,
            'title' => $title,
            'message' => $message,
        ];
    }
}
