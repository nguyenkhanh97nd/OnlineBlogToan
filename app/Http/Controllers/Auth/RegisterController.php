<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:40',
            'username' => 'required|unique:users,username|min:6|max:20',
            'email' => 'required|email|max:255|unique:users|email',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required',
        ],[
            'name.max' => 'Tên tối đa 40 kì tự',
            'username.min' => 'Tên tài khoản từ 6 kí tự trở lên',
            'username.max' => 'Tên tài khoản không quá 20 kí tự',
            'email.email' => 'Email không đúng',
            'email.max' => 'Email không đúng',
            'username.unique' => 'Tài khoản đã tồn tại',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự',       
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'gender.required' => 'Vui lòng chọn giới tính'
        ]);
    }

 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmation_code = time().uniqid(true);
        $data['confirmation_code'] = $confirmation_code;

        Mail::send('pages.mail.verify', $data, function($message) use ($data){
            $message->from('blogtoan.com@gmail.com', 'Blog Toán');
            $message->subject('Xác nhận đăng kí tài khoản tại Blog Toán');
            $message->to($data['email']);
        });
        
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
            'gender' => $data['gender'],
            'confirmation_code' => $confirmation_code,
        ]);
    }
    public function verify($code) {
        $user = User::where('confirmation_code', $code)->first();

        if (count($user) > 0) {
            $user->update([
                'status' => 1,
                'confirmation_code' => null
            ]);

            $data = array();
            $data['email'] = $user['email'];
            $data['name'] = $user['name'];
            $data['username'] = $user['username'];  

            Mail::send('pages.mail.verified', $data, function($message) use ($data){
                $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                $message->subject('Chào mừng bạn đến với hệ thống thi thử Online của Blog Toán');
                $message->to($data['email']);
            });

            $notification_status = 'Xác nhận thành công tài khoản';
        } else {
            $notification_status ='Vui lòng đăng nhập';
        }

        return redirect()->route('login')->withErrors(['confirm_email' => $notification_status]);
    }


       /**
     * Validate Angular API
     * @param  array  $data [Request post]
     * @return [json]       [After validate]
     */
    protected function angularValidate(array $data)
    {
        $validate = null;

        if(!isset($data['name']) || !isset($data['username']) || !isset($data['email'])
            || !isset($data['password']) || !isset($data['repassword']) || !isset($data['gender']) ) {
            $validate = ['wrong_form' => 'Cần điền đủ thông tin'];
            return $validate;
        }

        if(count(User::where('username', $data['username'])->first()) != 0) {

            $validate = ['wrong_username' => 'Tài khoản đã tồn tại'];
            return $validate;

        }
        if(count(User::where('email', $data['email'])->first()) != 0) {

            $validate = ['wrong_email' => 'Email đã tồn tại'];
            return $validate;

        }

        if(strlen($data['name']) <= 0 || strlen($data['name']) > 40 ) {

            $validate = ['wrong_name' => 'Nhập họ tên chính xác dưới 40 ký tự'];
            return $validate;

        } else if (strlen($data['username']) < 6 || strlen($data['username']) > 20) {

            $validate = ['wrong_username' => 'Tên tài khoản 6-20 ký tự'];
            return $validate;

        } else if(! filter_var($data['email'], FILTER_VALIDATE_EMAIL )) {

            $validate = ['wrong_email' => 'Email không đúng'];
            return $validate;

        } else if(strlen($data['password']) < 6) {

            $validate = ['wrong_password' => 'Mật khẩu tối thiểu 6 kí tự'];
            return $validate;

        } else if($data['password'] != $data['repassword']) {

            $validate = ['wrong_password' => 'Xác nhận mật khẩu không đúng'];
            return $validate;

        } else if(! in_array($data['gender'], [0, 1, 3])) {

            $validate = ['wrong_gender' => 'Vui lòng chọn giới tính'];
            return $validate;

        } else {
            $validate = 0;
        }
        return $validate;
    }

    /**
     * Angular API Register
     * @param  Request $request [Request post]
     * @return [json]           [Success or not]
     */
    public function apiClientRegister(Request $request) {

        if($this->angularValidate($request->all())) {
            return $this->angularValidate($request->all());
        }

        $confirmation_code = time().uniqid(true);

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->gender = $request->gender;
        $user->confirmation_code = $confirmation_code;
        $user->save();


        $data = array();
        $data['email'] = $request->email;
        $data['confirmation_code'] = $confirmation_code;

        Mail::send('pages.mail.verify', $data, function($message) use ($data){
            $message->from('blogtoan.com@gmail.com', 'Blog Toán');
            $message->subject('Xác nhận đăng kí tài khoản tại Blog Toán');
            $message->to($data['email']);
        });

        return response()->json([
            'success' => 'Đăng ký thành công tài khoản'
        ]);
    }

    
}
