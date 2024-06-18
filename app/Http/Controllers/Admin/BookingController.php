<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Booking\BookingStatus;
use App\Enums\ResponseStatus;
use App\Enums\RoleAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminBookingRequest;
use App\Models\Booking;
use App\Models\Branch;
use App\Services\Admin\BookingService;
use App\Services\Admin\RoomService;
use App\Services\Admin\RoomTypeService;
use App\Services\Admin\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected BookingService $bookingService;
    protected RoomService $roomService;
    protected RoomTypeService $roomTypeService;
    protected UserService $userService;

    public function __construct(
        BookingService $bookingService,
        RoomService $roomService,
        RoomTypeService $roomTypeService,
        UserService $userService,
    ) {
        $this->bookingService = $bookingService;
        $this->roomService = $roomService;
        $this->roomTypeService = $roomTypeService;
        $this->userService = $userService;
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
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch' => ['required', 'numeric'],
            'roomType' => ['nullable', 'numeric'],
            'checkin' => ['required', 'date', 'after:' . Carbon::now()->toDateTimeString()],
            'checkout' => ['required', 'date', 'after:' . Carbon::now()->addHours(2)->toDateTimeString()],
        ]);
        $rooms = [];
        if ($validator->passes()) {
            $roomList = $this->roomService->searchByCondition($request->all());
            $rooms = $this->roomService->calculateCapacity($roomList);
        }
        $admin = Auth::guard('admins')->user();
        $branches = collect();
        if ($admin->role == RoleAccount::Admin || is_null($admin->branch))
        {
            $branches = Branch::all();
        } else {
            $branches = $branches->push($admin->branch);
        }
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        $users = $this->userService->getActiveUserAccount();
        return view('admin.pages.bookings.create', [
           'title' => 'Tạo đơn đặt phòng',
           'branches' => $branches,
           'roomTypes' => $roomTypes,
           'rooms' => $rooms,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminBookingRequest $request
     * @return RedirectResponse|void
     */
    public function store(AdminBookingRequest $request)
    {
        $checkIn = Carbon::parse($request['checkin']);
        $checkOut = Carbon::parse($request['checkout']);

        //Check phòng có đơn đặt chưa
        $roomsBooked = $this->roomService->roomsHasBooked($request['rooms'], $checkIn, $checkOut);
        if ($roomsBooked->isNotEmpty()) {
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Error,
                'title' => 'Phòng ' . $roomsBooked->first()->name . ' đã có đơn đặt phòng đặt trước!',
                'message' => 'Vui lòng chọn lại phòng khác',
            ]);
        } else {
            $roomPrices = [];
            $bookingHour = $checkOut->diffInHours($checkIn);
            foreach ($request['rooms'] as $roomId) {
                $room = $this->roomService->find($roomId);
                $prices = $this->roomService->getPrices($room, $bookingHour);
                $roomPrices[] = [
                    'room' => $room,
                    'price' => $prices,
                ];
            }
        }

        // Tạo booking
        $response = $this->bookingService->createBooking($request->except('token'), $roomPrices);
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

    /**
     * Tính giá của các phòng đã chọn
     * @param Request $request
     * @return array
     */
    public function chooseRoom(Request $request)
    {
        $room = $this->roomService->find($request->get('room_id'));
        $bookingHour = Carbon::parse($request->get('check_out'))->diffInHours($request->get('check_in'));
        return $this->roomService->getPrices($room, $bookingHour);
    }
}
