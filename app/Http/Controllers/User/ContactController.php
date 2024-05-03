<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\User\ContactService;

class ContactController extends Controller
{

    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }
    public function sendContact(ContactRequest $request)
    {
        $response = $this->contactService->sendContact($request->all());

        return $this->showAlertAndRedirect($response);
    }

}
