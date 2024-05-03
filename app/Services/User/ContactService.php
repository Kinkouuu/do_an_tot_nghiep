<?php

namespace App\Services\User;

use App\Models\Contact;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class ContactService extends BaseService
{
    public function getModel()
    {
        return Contact::class;
    }

    public function sendContact(array $data)
    {
        $data['user_id'] = Auth::user()->id ?? null;
        $this->create($data);

        return $this->successResponse('Cảm ơn góp ý của bạn!','Chúng tôi sẽ phản hồi lại bạn sớm nhất');
    }
}
