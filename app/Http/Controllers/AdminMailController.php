<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;

use App\User;
use Mail;

class AdminMailController extends Controller
{
    /**
     * Get Master Blade Template View
     * Let Vuejs Backend
     * @return [view] [admin.master]
     */
    public function getMasterView() {

    	return view('admin.master');

    }

    /**
     * API use Vuejs Backend
     * An API Restfull use Vuejs + Laravel
     */
    
    /**
     * Send Mail to users
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function apiPostMail(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'title' => 'required',
            'content' => 'required',
            'users' => 'required'
        ], [
            'name.required' => '* Fill Name Mail',
            'title.required' => '* Fill Title Mail',
            'content.required' => '* Fill Content Mail',
            'users.required' => '* Chose Mail Send To'
        ]);

        switch ($request->users) {
            case 0:
                $receivers = User::all();
                break;
            case 1:
                $receivers = User::where('level', 1)->get();
                break;
            case 2:
                $receivers = User::where('level', 2)->get();
                break;
            case 3:
                $receivers = User::where('level', 3)->get();
                break;
            case 4:
                $mails = $request->data;
                break;
            
            default:
                $receivers = null;
                break;
        }
        if(isset($receivers) && $receivers != null) {
            $data = array();
            $data['name'] = $request->name;
            $data['title'] = $request->title;
            $data['content'] = $request->content;       

            foreach($receivers as $receiver) {
                $data['email'] = $receiver['email'];
                $data['user'] = $receiver['name'];
                $data['username'] = $receiver['username'];
                $data['level'] = $receiver['level'];
                Mail::send('admin.mail.mail.form', $data, function($message) use ($data){
                    $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                    $message->subject($data['name']);
                    $message->to($data['email']);
                });
            }

        } else if($mails) {
            $arrMail = explode(', ', $mails);

            $data = array();
            $data['name'] = $request->name;
            $data['title'] = $request->title;
            $data['content'] = $request->content;

            foreach($arrMail as $mail) {
                $data['email'] = $mail;
                Mail::send('admin.mail.mail.form', $data, function($message) use ($data){
                    $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                    $message->subject($data['name']);
                    $message->to($data['email']);
                });
            }
        } else {
            return response()->json([
                'sended' => false,
                'message' => 'Error! Check again!'
            ]);
        }

        return response()->json([
            'sended' => true,
            'message' => 'Success Send Mail'
        ]);
    }
}
