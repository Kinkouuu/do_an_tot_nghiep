<?php

namespace App\Http\Controllers\User;

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\PaymentType;
use App\Enums\ResponseStatus;
use App\Events\BookingChangeStatus;
use App\Events\BookingEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Services\User\BookingService;
use App\Services\User\RoomService;
use App\Services\User\RoomTypeService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected BookingService $bookingService;
    protected RoomTypeService $roomTypeService;
    protected RoomService $roomService;
    public function __construct(BookingService $bookingService, RoomTypeService $roomTypeService, RoomService $roomService)
    {
        $this->bookingService = $bookingService;
        $this->roomTypeService = $roomTypeService;
        $this->roomService = $roomService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $bookingOrders = $this->bookingService->getBookingOrders($user);
        $bookingRooms = $this->roomService->retrieveBookingOrdersRooms($bookingOrders);

        return view('user.pages.bookings.list', [
            'page_title' => 'Đơn đã đặt',
            'booking_rooms' => $bookingRooms,
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
     * @param BookingRequest $request
     * @return RedirectResponse|void
     */
    public function store(BookingRequest $request)
    {
        $user = Auth::user();
        $customerInfo = $request->except('_token');
        $roomInfo = Cache::get('cart_' . $user->id);
        if (!$roomInfo)
        {
            Log::info('Not found Room Information on Cart of user ' . $user->id);
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Error,
                'title' => 'Đã có lỗi xảy ra!',
            ]);
        }
        $response = $this->bookingService->storeBooking($user, $customerInfo, $roomInfo);
        return $this->showAlertAndRedirect($response);
    }

    /**
     * Display the specified resource.
     *
     * @param string $bookingId
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function show(string $bookingId)
    {
       $booking = $this->bookingService->find(base64_decode($bookingId));
       $bookingRooms = $this->roomService->retrieveBookingOrderRooms($booking);
       $rooms = $this->roomTypeService->getRoomTypesGlobalInfo($bookingRooms['rooms']);
       return view('user.pages.bookings.detail', [
           'page_title' => 'Thông tin đơn hàng',
           'branch' => $bookingRooms['branch'],
           'booking' => $bookingRooms['booking'],
           'rooms' => $rooms,
           'total' => $bookingRooms['total'],
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function bookingCancel(int $id)
    {
        $booking = $this->bookingService->find($id);
        if($booking && in_array( $booking->status, BookingStatus::getAwaitingBooking()))
        {
            return $this->bookingService->cancel($booking);
        }

        return $this->bookingService->errorResponse(
            'Đã có lỗi xảy ra',
             'Vui lòng thử lại sau ít phút',
        );
    }

    public function bookingConfirm()
    {
        $user = Auth::user();
        $data = Cache::get('cart_' . $user->id);
        if(!$data)
        {
            return redirect()->route('homepage');
        }

        $rooms = $this->roomTypeService->getRoomTypesGlobalInfo($data['rooms']);
        $condition = $this->bookingService->retrieveCondition($data['condition']);

        return view('user.pages.bookings.booking-confirm', [
            'page_title' => 'Xác nhận đặt phòng',
            'user' => $user,
            'condition' => $condition,
            'branch' => $data['branch'],
            'rooms' => $rooms,
            'total_amount' => $data['total_amount']
        ]);
    }

    public function showPaymentResponse(string $bookingId, Request $request)
    {
        $booking = $this->bookingService->find(base64_decode($bookingId));
        $roomInfo = Cache::get('booking_' . $booking->id);
        $response = $request->all();
        if($response['vnp_ResponseCode'] == '00' && $roomInfo)
        {
            //Cập nhật trạng thái đơn đặt và xếp phòng cho khách
            $booking->status = BookingStatus::Approved['key'];
            $booking->deposit = $response['vnp_Amount']/100;
            $booking->save();
            BookingChangeStatus::dispatch($booking, $roomInfo);
            $data = [
                'status' => ResponseStatus::Success,
                'title' => 'Thanh toán thành công!',
                'code' => $response['vnp_TransactionNo'],
                'amount' => $response['vnp_Amount']/100,
            ];
        } else {
            // Xóa đơn hàng khỏi DB nếu giao dịch thất bại
            $booking->forceDelete();
            $data = [
                'status' => ResponseStatus::Error,
                'title' => 'Thanh toán thất bại!',
                'code' => $response['vnp_ResponseCode'],
            ];
        }
        Cache::forget('booking_' . $booking->id);
        return view('user.pages.bookings.payment-response', [
            'page_tile' => 'Thanh toán VNPay',
            'data' => $data,
            'booking_id' => $bookingId,
        ]);
    }

    public function bookingPayment(string $bookingId)
    {
        $booking = $this->bookingService->find(base64_decode($bookingId));
        $roomInfo = Cache::get('booking_' . $booking->id);
        if ($booking->status == BookingStatus::AwaitingPayment['key'] && $booking->payment != PaymentType::Cash && $roomInfo)
        {
            $this->bookingService->vnPay($booking, $roomInfo);
        }

        return redirect()->back();
    }
}

