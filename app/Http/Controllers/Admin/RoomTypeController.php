<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ResponseStatus;
use App\Enums\Room\ImageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomTypeRequest;
use App\Http\Requests\RoomImageRequest;
use App\Models\RoomImage;
use App\Models\TypeRoom;
use App\Services\Admin\RoomTypeService;
use App\Services\Admin\ServiceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomTypeController extends Controller
{
    protected RoomTypeService $roomTypeService;
    protected ServiceService $serviceService;

    public function __construct(RoomTypeService $roomTypeService, ServiceService $serviceService)
    {
        $this->roomTypeService = $roomTypeService;
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function index(Request $request)
    {
        $roomTypes = $this->roomTypeService->getAll($request->all());

        return view('admin.pages.room-types.index', [
            'title' => 'Danh sách phân loại phòng',
            'roomTypes' => $roomTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pages.room-types.create', [
            'title' => 'Thêm loại phòng mới'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomTypeRequest $request
     * @return RedirectResponse
     */
    public function store(RoomTypeRequest $request)
    {
        $response = $this->roomTypeService->createRoomType($request->except('_token'));

        return $this->showAlertAndRedirect($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, TypeRoom $typeRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getImages(int $typeRoomID)
    {
        $typeRoom = $this->roomTypeService->getById($typeRoomID);

        $thumbImage = $this->roomTypeService->getThumbNailImage($typeRoom);
        $detailImages = $this->roomTypeService->getDetailImages($typeRoom);

        return view('admin.pages.room-types.images', [
            'title' => 'Cập nhật ảnh loại phòng',
            'type_room' => $typeRoom,
            'thumbnail' => $thumbImage,
            'details' => $detailImages,
        ]);
    }

    /**
     * Change thumbnail image
     * @param RoomImageRequest $request
     * @param TypeRoom $typeRoom
     * @return RedirectResponse
     */
    public function changeThumbNail(RoomImageRequest $request, TypeRoom $typeRoom)
    {
        //Xóa ảnh thumbnail(nếu có)
        $thumbImage = $this->roomTypeService->getThumbNailImage($typeRoom);
        if($thumbImage)
        {
            $this->roomTypeService->removeImage($thumbImage);
        }
        //Lưu ảnh mới lên hệ thống
        $response = $this->roomTypeService->storeImages($request->file(), $typeRoom);

        return $this->showAlertAndRedirect($response);
    }

    public function changeDetail(RoomImageRequest $request, TypeRoom $typeRoom)
    {
        //Xóa ảnh thumbnail(nếu có)
        $detailImages = $this->roomTypeService->getDetailImages($typeRoom);
        if(count($detailImages) >= config('constants.max_room_img'))
        {
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Warning,
                'title' => 'Đã quá số lượng ảnh cho phép'
            ]);
        } else {
            //Lưu ảnh mới lên hệ thống
            $response = $this->roomTypeService->storeImages($request->file(), $typeRoom, ImageType::Detail);
        }

        return $this->showAlertAndRedirect($response);
    }

    /**
     * Delete detail image
     * @param RoomImage $roomImage
     * @return RedirectResponse
     */
    public function deleteImage(RoomImage $roomImage)
    {
        $this->roomTypeService->removeImage($roomImage);

        return $this->showAlertAndRedirect([
           'status' =>  ResponseStatus::Success,
            'title' => 'Xóa ảnh thành công'
        ]);
    }

    /**
     * Lấy danh sách đã/chưa được cung cấp sẵn cho từng loại phòng
     * @param int $typeRoomID
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function getServices(int $typeRoomID)
    {
        $typeRoom = $this->roomTypeService->getById($typeRoomID);
        $activeTypeServices = $this->serviceService->getActiveTypeServices();
        $services = $this->roomTypeService->getListServices($typeRoom, $activeTypeServices);
//dd($services);
        return view('admin.pages.room-types.services', [
            'title' => 'Cập nhật dịch vụ của loại phòng ',
            'type_room' => $typeRoom,
            'services' => $services,
        ]);
    }
}
