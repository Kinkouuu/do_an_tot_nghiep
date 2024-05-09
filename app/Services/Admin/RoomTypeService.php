<?php

namespace App\Services\Admin;

use App\Enums\Room\ImageType;
use App\Enums\Room\PriceType;
use App\Models\RoomImage;
use App\Models\RoomPrice;
use App\Models\TypeRoom;
use App\Services\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoomTypeService extends BaseService
{
    public function getModel()
    {
        return TypeRoom::class;
    }

    /**
     * @param array|null $request
     * @return Collection
     */
    public function getAll(?array $request): Collection
    {
        $data = [];
        $roomTypes = $this->all();
        $priceTypes = PriceType::getRoomPriceType();
        foreach ($roomTypes as $roomType)
        {
            $prices =[];
            foreach ($priceTypes as $key=>$priceType) //giá phòng theo từng loại
            {
                $prices[$key] = $roomType?->roomPrices[$key]?->price ?? 0;
            }

            $data[] = [
                'id' => $roomType->id,
                'thumb_link' => $this?->getThumbNailImage($roomType)?->path, // lấy ảnh đại diện
                'name' => $roomType->name,
                'prices' => $prices,
                'status' => $roomType->status
            ];
        }

        $result = collect($data);

        if(isset($request['search']))
        {
            $searchTerm = $request['search'];
            $result = $result->filter(function ($item) use ($searchTerm) {
                return str_contains($item['name'], $searchTerm);
            });
        }

        if(isset($request['by']) && isset($request['sort']))
        {
            $result = $result->sortBy($request['by'],null, $request['sort']);
        }

        return $result;
    }

    /**
     * Create room type and it's price
     * @param array $data
     * @return array
     */
    public function createRoomType(array $data): array
    {
        DB::beginTransaction();

        try {
            $typeRoom = $this->create([
                'name' => $data['name'],
                'description' => $data['description']
            ]);
            foreach ($data['price'] as $key => $price) {
                RoomPrice::create([
                    'type_room_id' => $typeRoom->id,
                    'type' => $key,
                    'price' => $price
                ]);
            }

            DB::commit();

            return $this->questionResponse(
                'admin.room-type.services',
                $typeRoom->id,
                'Thêm loại phòng mới thành công',
                'Tiếp tục thêm dịch vụ của phòng!',
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param int|null $typeRoomID
     * @return mixed
     */
    public function getById(?int $typeRoomID): mixed
    {
        $typeRoom = $this->find($typeRoomID);

        if(!$typeRoom)
        {
            abort(404);
        }

        return $typeRoom;
    }

    /**
     * @param TypeRoom $typeRoom
     * @return mixed
     */
    public function getThumbNailImage(TypeRoom $typeRoom): mixed
    {
       return $typeRoom->roomImages->filter(function ($item) {
            return ($item['type'] == ImageType::ThumbNail);
        })->first();
    }

    /**
     * @param TypeRoom $typeRoom
     * @return mixed
     */
    public function getDetailImages(TypeRoom $typeRoom): mixed
    {
        return $typeRoom->roomImages->filter(function ($item) {
            return ($item['type'] == ImageType::Detail);
        });
    }

    /**
     * @param $files
     * @param TypeRoom $typeRoom
     * @param int|string|null $imageType
     * @return array
     */
    public function storeImages($files, TypeRoom $typeRoom , ?string $imageType = ImageType::ThumbNail): array
    {
        foreach ($files as $file)
        {
            $ext = $file->extension();
            $file_name = $typeRoom->name . '-' . time()  . '.' .$ext;
            $file->move('storage/images/room_type',$file_name);

            RoomImage::create([
                'type_room_id' => $typeRoom->id,
                'path' => '/storage/images/room_type/' . $file_name,
                'type' => $imageType
            ]);
        }
        return $this->successResponse('Cập nhật ảnh phòng thành công!');
    }

    /**
     * @param RoomImage $roomImage
     * @return bool|null
     */
    public function removeImage(RoomImage $roomImage): ?bool
    {
        $filePath = public_path($roomImage->path);
        if (File::exists($filePath)) {
            // Xóa tệp tin ảnh
            File::delete($filePath);
        }
        return $roomImage->delete();
    }

    /** Filter các dịch vụ phòng đang/chưa có
     * @param TypeRoom $typeRoom
     * @param Collection $typeServices
     * @return array
     */
    public function getListServices(TypeRoom $typeRoom, Collection $typeServices): array
    {
        $servicesUnProvide = [];
        $servicesProvide = [];
        $serviceIds = [];
        //Lấy các dịch vụ phòng đang có
        foreach ($typeRoom->roomServices as $roomService)
        {
            $providedTypeService = $roomService->typeService; //Lấy thông tin loại dịch vụ
            if(!isset($servicesProvide[$providedTypeService->id])) { //Lưu thông tin loại dịch vụ nếu chưa có trong ds
                $servicesProvide[$providedTypeService->id] = [
                    'type_service_id' => $providedTypeService->id,
                    'type_service_icon' => $providedTypeService->icon,
                    'type_service_name' => $providedTypeService->name,
                ];
            }
            //Lưu thông tin dịch vụ
            $servicesProvide[$providedTypeService->id]['services'][] = [
                'id' => $roomService->id,
                'name' => $roomService->name,
                'price' => $roomService->price,
                'status' => $roomService->status,
                'discount' => $roomService->pivot->discount,
            ];
            // Cập danh sách ID của các dịch vụ phòng đang có
            $serviceIds[] = $roomService->id;
        }

        // Lấy các dịch vụ đang được cung cấp group theo loại dịch vụ
        foreach ($typeServices as $key=>$typeService)
        {
            $servicesUnProvide[] = [
                'type_service_id' => $typeService->id,
                'type_service_icon' => $typeService->icon,
                'type_service_name' => $typeService->name,
            ];
           foreach($typeService->services as $service) {
               //Thêm vào danh sách các dịch vụ phòng chưa có
               if(!in_array($service->id, $serviceIds)) {
                   $servicesUnProvide[$key]['services'][] = [
                       'id' => $service->id,
                       'name' => $service->name,
                       'price' => $service->price,
                       'status' => $service->status,
                   ];
               }
           }
        }

        return [
            'provided_service' => $servicesProvide,
            'un_provided_service' => $servicesUnProvide,
        ];
    }
}
