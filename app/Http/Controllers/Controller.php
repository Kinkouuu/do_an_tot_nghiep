<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirect(array $response, ?string $nextUrl = null)
    {
        if ($response['status'] == 'success') {
            Alert::success($response['title'], $response['message']);
            return redirect()->route($nextUrl);
        } elseif ($response['status'] == 'error') {
            Alert::error($response['message']);
            return back();
        } else {
            return view($nextUrl);
        }
    }
}
