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
        foreach ($roomTypes as $roomType) {
            $prices = [];
            foreach ($priceTypes as $key => $priceType) //giá phòng theo từng loại
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

        if (isset($request['search'])) {
            $searchTerm = $request['search'];
            $result = $result->filter(function ($item) use ($searchTerm) {
                return str_contains($item['name'], $searchTerm);
            });
        }

        if (isset($request['by']) && isset($request['sort'])) {
            $result = $result->sortBy($request['by'], null, $request['sort']);
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
                    'type_price' => (string)$key,
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

    public function updateRoomType(array $data, TypeRoom $typeRoom)
    {
        DB::beginTransaction();
        try {
            $typeRoom->update([
                'name' => $data['name'],
                'description' => $data['description']
            ]);

            foreach ($data['price'] as $key => $price) {
                $roomPrice = RoomPrice::where('type_room_id', $typeRoom->id)->where('type_price', (string)$key)->first();
                //Cập nhật nếu đã có trong CSDL
                if ($roomPrice) {
                    $roomPrice->price = $price;
                    $roomPrice->save();
                } else {//Thêm nếu chưa có trong CSDL
                    RoomPrice::create([
                        'type_room_id' => $typeRoom->id,
                        'type_price' => (string)$key,
                        'price' => $price
                    ]);
                }
            }

            DB::commit();
            return $this->successResponse(
                'Cập nhật phân loại phòng thành công',
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

        if (!$typeRoom) {
            abort(404);
        }

        return $typeRoom;
    }

    /**
     * Lấy các loại giá niêm yết của loại phòng
     * @param TypeRoom $typeRoom
     * @return array
     */
    public function getRoomPrices(TypeRoom $typeRoom): array
    {
        $roomPrices = [];
        foreach (PriceType::asArray() as $key => $priceType) {
            //Khởi tạo giá trị cho từng loại giá
            $roomPrices[$key] = [
                'id' => $priceType['value'],
                'type' => $priceType['type'],
                'name' => $priceType['text'],
                'price' => 0,
            ];
            foreach ($typeRoom->roomPrices as $roomPrice) {
                if ($priceType['value'] == $roomPrice->type_price) {
                    //Cập nhật lại giá cho loại giá tương ứng
                    $roomPrices[$key]['price'] = $roomPrice->price;
                    break;
                }
            }
        }
        return $roomPrices;
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
    public function storeImages($files, TypeRoom $typeRoom, ?string $imageType = ImageType::ThumbNail): array
    {
        foreach ($files as $file) {
            $ext = $file->extension();
            $file_name = $typeRoom->name . '-' . time() . '.' . $ext;
            $file->move('storage/images/room_type', $file_name);

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
        foreach ($typeRoom->roomServices as $roomService) {
            $providedTypeService = $roomService->typeService; //Lấy thông tin loại dịch vụ
            if (!isset($servicesProvide[$providedTypeService->id])) { //Lưu thông tin loại dịch vụ nếu chưa có trong ds
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
        foreach ($typeServices as $key => $typeService) {
            $servicesUnProvide[] = [
                'type_service_id' => $typeService->id,
                'type_service_icon' => $typeService->icon,
                'type_service_name' => $typeService->name,
            ];
            foreach ($typeService->services as $service) {
                //Thêm vào danh sách các dịch vụ phòng chưa có
                if (!in_array($service->id, $serviceIds)) {
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

    /**
     * Lưu dịch vụ mới vào pivot table
     * @param array $newServices
     * @param TypeRoom $typeRoom
     * @return array
     */
    public function storeRoomService(array $newServices, TypeRoom $typeRoom): array
    {
        foreach ($newServices as $item) {
            // Check xem phòng đã có dịch vụ chưa
            if (!$typeRoom->roomServices->contains('id', $item)) {
                //Nếu chưa thì thêm vào, mặc định là miễn phí
                $typeRoom->roomServices()->attach([$item], ['discount' => 100]);
            }
        }
        $roomThumbNail = $this->getThumbNailImage($typeRoom);
        // Nếu chưa có ảnh thumbnail thì show pop up chuyển hướng
        if (!$roomThumbNail) {
            return $this->questionResponse(
                'admin.room-type.images',
                $typeRoom->id,
                'Thêm dịch vụ thành công', 'Tiếp tục cập nhật ảnh phòng');
        } else {
            return $this->successResponse('Thêm dịch vụ thành công');
        }
    }

    public function deleteRoomService(array $removeServices, TypeRoom $typeRoom)
    {
        foreach ($removeServices as $item) {
            // Check xem phòng đang có dịch vụ đó ko
            if ($typeRoom->roomServices->contains('id', $item)) {
                //Nếu có thì xóa
                $typeRoom->roomServices()->detach([$item]);
            }
            return $this->successResponse('Xóa dịch vụ thành công');
        }
    }

}
