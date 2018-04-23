<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use JWTAuth;
use JWTAuthException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Angular Login
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request) {

        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);

        // Kiểm tra đăng nhập là username hay email
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';

        // Xác thực chuẩn
        $credentials_confirmed = [
            $login_type => $request->input('login'),
            'password' => $request->password,
            'status' => 1
        ];
        // Xác thực khi chưa confirm email
        $credentials_simple = [
            $login_type => $request->input('login'),
            'password' => $request->password,
            'status' => 0
        ];

        // Xác thực khi bị khoá tài khoản
        $credentials_banned = [
            $login_type => $request->input('login'),
            'password' => $request->password,
            'status' => 2
        ];

        // Kiểm tra đăng nhập
        if(Auth::attempt($credentials_confirmed)) {

            Auth::attempt($credentials_confirmed);
            $email = Auth::user()->email;
            $password = $request->password;

            $token = JWTAuth::attempt(['email' => $email, 'password' => $password]);

            return response()->json([
                'token' => $token
            ]);
        }
        else {
            if(Auth::attempt($credentials_simple)) {
                Auth::logout();
                return response()->json([
                    'wrong_account'=>'Vui lòng xác nhận Email'
                ]);
            }
            else {
                if(Auth::attempt($credentials_banned)) {
                    Auth::logout();
                    return response()->json([
                        'wrong_account'=>'Tài khoản đã bị khoá'
                    ]);
                } else {
                    return response()->json([
                        'wrong_info'=>'Thông tin đăng nhập sai'
                    ]);
                } 
            }
            
        }
        
    }

}
