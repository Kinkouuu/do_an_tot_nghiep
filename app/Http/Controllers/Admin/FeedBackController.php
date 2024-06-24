<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FeedBack;
use App\Services\Admin\FeedBackService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{

    protected FeedBackService $feedBackService;

    public function __construct(FeedBackService $feedBackService)
    {
        $this->feedBackService = $feedBackService;
    }

    /**
     * Hiển thị feedback của khách hàng
     * @param Booking $booking
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function showFeedBack(Booking $booking)
    {
        return view('admin.pages.bookings.feed-back', [
            'title' => 'Đánh giá của khách hàng',
            'booking' => $booking,
            'feedBacks' => $booking->feedBacks
        ]);
    }

    /**
     * @param int $feedBackId
     * @param Request $request
     * @return array
     */
    public function replyFeedBack(int $feedBackId, Request $request)
    {
        $feedBack = $this->feedBackService->find($feedBackId);

        return $this->feedBackService->replyFeedBack($feedBack, $request->get('reply'));
    }
}
