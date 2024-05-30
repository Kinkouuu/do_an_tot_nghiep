<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\BookingService;
use App\Services\User\RoomTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BookingController extends Controller
{
    protected BookingService $bookingService;
    protected RoomTypeService $roomTypeService;
    public function __construct(BookingService $bookingService, RoomTypeService $roomTypeService)
    {
        $this->bookingService = $bookingService;
        $this->roomTypeService = $roomTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        dd($request->all());
        $this->bookingService->storeBooking($request->get('roomIds'));
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'user' => $user,
            'condition' => $condition,
            'branch' => $data['branch'],
            'rooms' => $rooms,
            'total_price' => $data['total_price']
        ]);
    }
}
