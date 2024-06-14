<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Booking\BookingStatus;
use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Admin\BookingService;
use App\Services\Admin\RoomTypeService;
use App\Services\User\RoomService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected BookingService $bookingService;
    protected RoomService $roomService;
    protected RoomTypeService $roomTypeService;

    public function __construct(BookingService $bookingService, RoomService $roomService, RoomTypeService $roomTypeService)
    {
        $this->bookingService = $bookingService;
        $this->roomService = $roomService;
        $this->roomTypeService = $roomTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $bookings = $this->bookingService->getAll($request->all());
        return view('admin.pages.bookings.index', [
            'title' => 'Danh sách đơn đặt phòng',
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(int $id)
    {
        $booking = $this->bookingService->find($id);
        $bookingData = $this->roomService->retrieveBookingOrderRooms($booking);
        $rooms = $this->roomTypeService->getRoomTypesGlobalInfo($bookingData['rooms']);
        return view('admin.pages.bookings.edit', [
            'title' => 'Cập nhật thông tin đơn đặt phòng',
            'branch' => $bookingData['branch'],
            'booking' => $bookingData['booking'],
            'rooms' => $rooms,
            'total' => $bookingData['total'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Booking $booking
     * @param Request $request
     * @return RedirectResponse
     */
    public function refuseBooking(Booking $booking, Request $request)
    {
        $validated =Validator::make($request->all(), [
            'reason' => ['required', 'max:255', 'string'],
        ]);
        if($validated->fails()) {
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Error,
                'title'  => 'Vui lòng chọn/nhập lý do.'
            ]);
        }
            $booking->status = BookingStatus::Refuse['key'];
            $booking->refuse_reason = $request->get('reason');
            $booking->save();
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Success,
                'title' => 'Đã từ chối đơn đặt!',
            ]);
    }
}
