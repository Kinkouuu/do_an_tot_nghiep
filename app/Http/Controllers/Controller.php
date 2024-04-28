<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @param array $response
     * @return RedirectResponse
     */
    public function showAlertAndRedirect(array $response)
    {
        $nextUrl = $response['nextUrl'] ?? null;
        $title = $response['title'] ?? null;
        $message = $response['message'] ?? null;

        switch ($response['status']) {
            case 'success':
                Alert::success($title, $message);
                break;
            case 'error':
                Alert::error($title, $message);
                break;
            case 'warning':
                Alert::warning($title, $message);
                break;
            case 'info':
                Alert::info($title, $message);
                break;
            case 'question':
                Alert::question($title,$message)
                    ->showCancelButton('Hủy')
                    ->showConfirmButton('<a href=\''. route($nextUrl, ['code' => $response['code'] ?? null]) .'\'>Xác nhận</a>');
                break;
            default:
                Alert::alert($title, $message);
        }

        if (!is_null($nextUrl) && $response['status'] != 'question' ) {
            sleep(3);
            return redirect()->route($nextUrl);
        } else {
            return back();
        }
    }
}
