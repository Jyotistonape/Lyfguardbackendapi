<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FCMService;

class TestController extends Controller
{

    public function sendTestNotificationToUser()
    {
        try {
            $user = User::findOrFail(auth()->user()->id);

            FCMService::send(
                $user->fcm_token,
                [
                    'title' => 'Test Notification',
                    'body' => 'Hlw User',
                ]
            );
            return Response::suc('Testing');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}
