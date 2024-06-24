<?php

namespace App\Http\Controllers\User;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedBackRequest;
use App\Models\FeedBack;
use App\Services\User\BookingService;
use App\Services\User\FeedBackService;
use App\Services\User\RoomService;
use App\Services\User\RoomTypeService;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FeedBackController extends Controller
{
    protected BookingService $bookingService;
    protected FeedBackService $feedBackService;
    protected RoomService $roomService;
    protected RoomTypeService $roomTypeService;


    public function __construct(
        BookingService $bookingService,
        FeedBackService $feedBackService,
        RoomService $roomService,
        RoomTypeService $roomTypeService,
    ) {
        $this->bookingService = $bookingService;
        $this->feedBackService = $feedBackService;
        $this->roomService = $roomService;
        $this->roomTypeService = $roomTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * @param string $bookingId
     * @param FeedBackRequest $request
     * @return RedirectResponse
     */
    public function store(FeedBackRequest $request, string $bookingId)
    {
        DB::beginTransaction();;
        try {
            $booking = $this->bookingService->find(base64_decode($bookingId));
            $data = $request->get('feedback');
            foreach ($data as $key => $rating) {
                $roomType = $this->roomTypeService->find($key);
                $this->feedBackService->store($booking, $roomType, $rating);
            }
            DB::commit();
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Success,
                'title' => 'Đánh giá chuyến đi thành công!',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Success,
                'title' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        //

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
        $feedBacks = $booking->feedBacks;
        if($feedBacks->isEmpty()) {
            return view('user.pages.feedbacks.create', [
                'page_title' => 'Đánh giá chuyến đi',
                'branch' => $bookingRooms['branch'],
                'booking' => $bookingRooms['booking'],
                'rooms' => $rooms,
            ]);
        } else {
            return view('user.pages.feedbacks.show', [
                'page_title' => 'Đánh giá của bạn',
                'branch' => $bookingRooms['branch'],
                'booking' => $bookingRooms['booking'],
                'feedBacks' => $feedBacks,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FeedBack $feedBack
     * @return Response
     */
    public function edit(FeedBack $feedBack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param FeedBack $feedBack
     * @return Response
     */
    public function update(Request $request, FeedBack $feedBack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FeedBack $feedBack
     * @return Response
     */
    public function destroy(FeedBack $feedBack)
    {
    }
}
