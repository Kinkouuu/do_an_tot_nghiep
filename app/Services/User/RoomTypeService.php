<?php

namespace App\Services\User;

use App\Enums\Room\ImageType;
use App\Enums\Room\PriceType;
use App\Enums\Room\RoomTypeStatus;
use App\Enums\Service\ServiceStatus;
use App\Models\Branch;
use App\Models\TypeRoom;
use App\Models\TypeService;
use App\Services\BaseService;

class RoomTypeService extends BaseService
{
    public function getModel()
    {
        return TypeRoom::class;
    }

    /**
     * Lấy thông tin các phân loại phòng đang hoạt động
     * @return mixed
     */
    public function getActiveRoomType(): mixed
    {
        $data = [];
        $roomTypes = TypeRoom::where('status', RoomTypeStatus::Active)->orderBy('name', 'ASC')->get();
        foreach ($roomTypes as $roomType) {
            $thumbNail = $roomType->roomImages->filter(function ($item) {
                return ($item['type'] == ImageType::ThumbNail);
            })->first();
            //Lấy từng loại giá của loại phòng
            $prices = [];
            foreach ($roomType->roomPrices as $price) {
                switch ($price['type_price']) {
                    case PriceType::ListedHourPrice['value']:
                        $prices[PriceType::ListedHourPrice['value']] = [
                            'text' => PriceType::ListedHourPrice['text'],
                            'price' => $price['price'],
                            'type' => PriceType::ListedHourPrice['type'],
                        ];
                        break;
                    case PriceType::ListedDayPrice['value']:
                        $prices[PriceType::ListedDayPrice['value']] = [
                            'text' => PriceType::ListedDayPrice['text'],
                            'price' => $price['price'],
                            'type' => PriceType::ListedDayPrice['type'],
                        ];
                        break;
                    case PriceType::First2Hours['value']:
                        $prices[PriceType::First2Hours['value']] = [
                            'text' => PriceType::First2Hours['text'],
                            'price' => $price['price'],
                            'type' => PriceType::First2Hours['type'],
                        ];
                        break;
                    case PriceType::LateCheckOut['value']:
                        $prices[PriceType::LateCheckOut['value']] = [
                            'text' => PriceType::LateCheckOut['text'],
                            'price' => $price['price'],
                            'type' => PriceType::LateCheckOut['type'],
                        ];
                        break;
                    case PriceType::EarlyCheckIn['value']:
                        $prices[PriceType::EarlyCheckIn['value']] = [
                            'text' => PriceType::EarlyCheckIn['text'],
                            'price' => $price['price'],
                            'type' => PriceType::EarlyCheckIn['type'],
                        ];
                        break;
                }
            }

            $data[] = [
                'id' => $roomType->id,
                'name' => $roomType->name,
                'thumb_nail' => $thumbNail?->path,
                'prices' => $prices,
            ];
        }

        return $data;
    }

    /**
     * @param TypeRoom $typeRoom
     * @return array
     */
    public function getRoomTypeGlobalInfo(TypeRoom $typeRoom): array
    {
        $images = $this->getRoomImages($typeRoom);
        $prices = $this->getRoomPrices($typeRoom);
        $services = $this->getRoomServices($typeRoom);
        $branches = $this->getRoomTypeBranches($typeRoom);
        $branches = collect($branches)->where('count', '>', 0);

        return [
            'name' => $typeRoom['name'],
            'description' => $typeRoom['description'],
            'images' => $images,
            'prices' => $prices,
            'services' => $services,
            'branches' => $branches,
        ];
    }

    /**
     * @param TypeRoom $typeRoom
     * @return array
     */
    private function getRoomImages(TypeRoom $typeRoom): array
    {
        $thumbImg = $this->getThumbNail($typeRoom);

        $detailImg = $this->getDetailImg($typeRoom);

        return [
            'thumb_nail' => $thumbImg,
            'details_img' => $detailImg,
        ];
    }

    private function getThumbNail(TypeRoom $typeRoom)
    {
        return $typeRoom->roomImages->filter(function ($item) {
            return ($item['type'] == ImageType::ThumbNail);
        })->pluck('path')->first();
    }

    private function getDetailImg(TypeRoom $typeRoom)
    {
        return $typeRoom->roomImages->filter(function ($item) {
            return ($item['type'] == ImageType::Detail);
        })->pluck('path');
    }

    /**
     * @param TypeRoom $typeRoom
     * @return array
     */
    private function getRoomPrices(TypeRoom $typeRoom): array
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

    /*
     *
     */
    private function getRoomServices(TypeRoom $typeRoom): array
    {
        $provideServiceIds = [];
        $services = [
            'provide' => [],
            'unProvide' => []
        ];
        // lấy các dịch vụ sẵn có của loại phòng
        foreach ($typeRoom->roomServices as $service) {
            if ($service->status == ServiceStatus::Active) {
                $services['provide'][] = [
                    'service_id' => $service['id'],
                    'service_name' => $service['name'],
                    'price' => (1 - ($service->pivot->discount / 100)) * $service['price'],
                    'discount' => $service->pivot->discount
                ];
                $provideServiceIds[] = $service['id'];
            }
        }

        $serviceTypes = TypeService::has('services', '>', 0)->with(['services' => function ($query) {
            $query->where('status', ServiceStatus::Active);
        }])->get();
        // lấy các dịch vụ cung cấp thêm bên ngoài
        foreach ($serviceTypes as $serviceType) {
            $unProvideServices = $serviceType->services->filter(function ($item) use ($provideServiceIds) {
                return $item['status'] == ServiceStatus::Active && !in_array($item['id'], $provideServiceIds);
            });
            $services['unProvide'][] = [
                'service_type_id' => $serviceType['id'],
                'name' => $serviceType['name'],
                'icon' => $serviceType['icon'],
                'services' => $unProvideServices,
            ];
        }
        return $services;
    }

    /**
     * @param TypeRoom $typeRoom
     * @return array
     */
    private function getRoomTypeBranches(TypeRoom $typeRoom): array
    {
        $branches = [];
        foreach (Branch::all() as $branch) {
            $count = $branch->rooms->filter(function ($item) use ($typeRoom) {
                return $item['room_type_id'] == $typeRoom['id'];
            })->count();

            $branches[] = [
                'branch_id' => $branch['id'],
                'branch_name' => $branch['name'],
                'branch_city' => $branch['city'],
                'count' => $count,
            ];
        }
        return $branches;
    }

    /**
     * @param array $rooms
     * @return array
     */
    public function getRoomTypesGlobalInfo(array $rooms): array
    {
        $data = [];
        foreach ($rooms as $room)
        {
            $roomType = $this->find($room['room_type_id']);
            $thumbNail = $this->getThumbNail($roomType);
            $detailImages = $this->getDetailImg($roomType);
            $services = $this->getRoomServices($roomType);
            $data[] = array_merge($room, [
                'thumb_nail' => $thumbNail,
                'detail_images' => $detailImages,
                'services' => $services,
            ]);
        }
        return $data;
    }
}
