<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BookingService;
use App\Services\Admin\RoomTypeService;
use App\Services\User\RoomService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
