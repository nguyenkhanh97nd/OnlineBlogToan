<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request) {
        $this->validateEmail($request);

        $data = array();
        $data['email'] = $request->email;

        Mail::send('pages.mail.verify', $data, function($message) use ($data){
            $message->from('blogtoan.com@gmail.com', 'Blog Toán');
            $message->subject('Quên mật khẩu');
            $message->to($data['email']);
        });
    }
}
