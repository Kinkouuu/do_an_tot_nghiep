<?php

namespace App\Services\User;

use App\Enums\Room\ImageType;
use App\Enums\Room\PriceType;
use App\Enums\Room\RoomTypeStatus;
use App\Models\TypeRoom;
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
        $data =[];
        $roomTypes = TypeRoom::where('status', RoomTypeStatus::Active)->orderBy('name', 'ASC')->get();
        foreach ($roomTypes as $roomType)
        {
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
}
