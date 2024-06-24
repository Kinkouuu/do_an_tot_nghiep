<?php

namespace App\Services\Admin;
use App\Models\FeedBack;
use App\Services\User\FeedBackService as UserFeedBackService;
use Carbon\Carbon;
use DB;

class FeedBackService extends UserFeedBackService
{

    /**
     * @param FeedBack $feedBack
     * @param string $reply
     * @return array
     */
    public function replyFeedBack(FeedBack $feedBack, string $reply): array
    {
        DB::beginTransaction();
        try {
            $feedBack->reply = $reply;
            $feedBack->reply_at = Carbon::now();
            $feedBack->admin_id = \Auth::guard('admins')->user()->id;
            $feedBack->save();
            DB::commit();
            return $this->successResponse('Phản hồi khách hàng thành công!');
        } catch (\Exception $exception)
        {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage());
        }
    }
}
