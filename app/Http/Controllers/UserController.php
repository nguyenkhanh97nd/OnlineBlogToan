<?php

namespace App\Http\Controllers;

/*-- Cần import thư viện Facades cho Lar5.4--*/
use Illuminate\Support\Facades\Hash;
/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests\UserRequest;
use App\Feed;
use App\BData;

use JWTAuth;

class UserController extends Controller
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
     * Get List Members
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List members]
     */
    public function apiGetIndex() {
        $users = User::select('id','username','name','email','info','gender','level','status','avatar','created_at')->orderBy('id','DESC')->paginate(10);
        return response()->json($users);
    }

    /**
     * Create new member
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {

        $this->validate($request,
            [   'name'=>'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'repassword' => 'required|same:password',
                'gender' => 'required',
                'level' => 'required',
                'status' => 'required'
            ],
            [   'name.required' => '* Input name',
                'username.required' => '* Input username',
                'username.unique' => '* Username exist',
                'email.required' => '* Input email',
                'email.unique' => '* Email exist',
                'password.required' => '* Input password',
                'repassword.required' => '* Confirm password wrong',
                'repassword.same' => '* Confirm password wrong',
                'gender.required' => '* Chose gender',
                'level.required' => '* Chose level',
                'status.required' => '* Chose status'
            ]
        );

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->info = $request->info;
        $user->gender = $request->gender;
        $user->level = $request->level;
        $user->status = $request->status;

        if($request->image_upload) {
            $exploded = explode(',', $request->image_upload);
            $decoded = base64_decode($exploded[1]);

            $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';

            $username = $request->username;
            $name = str_random(4)."_".$username.'.'.$extension;
            while(file_exists("upload/users/".$name)){
                $name = str_random(4)."_".$username.'.'.$extension;
            }
            $path = 'upload/users/'.$name;
            file_put_contents($path, $decoded);
            $user->avatar = $name;
        }
        $user->save();

        return response()->json([
            'saved' => true,
            'message' => 'Success Create New User'
        ]);

    }

    public function apiShow($id) {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function apiUpdate(Request $request, $id) {

        $this->validate($request,
            [   'name'=>'required',
                'repassword' => 'same:password',
                'gender' => 'required',
                'level' => 'required',
                'status' => 'required'
            ],
            [   'name.required' => '* Input name',
                'repassword.same' => '* Confirm password wrong',
                'gender.required' => '* Chose gender',
                'level.required' => '* Chose level',
                'status.required' => '* Chose status'
            ]
        );
        $user = User::findOrFail($id);

        $user->name = $request->name;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->gender = $request->gender;
        $user->level = $request->level;
        $user->status = $request->status;

        if($request->avatar == 'deleted') {
            if(file_exists('upload/users/'.$user->avatar)) {
                unlink('upload/users/'.$user->avatar);
            }
            $user->avatar = NULL;
        }

        if($request->avatar == 'filled') {
            $exploded = explode(',', $request->image_upload);
            $decoded = base64_decode($exploded[1]);

            $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';

            $username = $request->username;
            $name = str_random(4)."_".$username.'.'.$extension;
            while(file_exists("upload/users/".$name)){
                $name = str_random(4)."_".$username.'.'.$extension;
            }
            $path = 'upload/users/'.$name;

            if($user->avatar && file_exists('upload/users/'.$user->avatar)) {
                unlink('upload/users/'.$user->avatar);
            }

            file_put_contents($path, $decoded);

            $user->avatar = $name;
        }

        $user->save();

        return response()->json([
            'saved' => true,
            'message' => 'Success Update User'
        ]);
    }

    public function apiDelete($id) {
        $user = User::with(['comment', 'bdata'])->findOrFail($id);

        if(count($user->comment) > 0 || count($user->bdata) > 0) {
            return response()->json([
                'deleted' => false,
                'message' => "Can't remove this User because it has comments or test data"
            ]);
        }
        
        if($user->avatar && file_exists('upload/users/'.$user->avatar)) {
            unlink('upload/users/'.$user->avatar);
        }        
        $user->delete($id);
        return response()->json([
            'deleted' => true,
            'message' => "Success Delete This User"
        ]);
    }

    public function apiSearch($search) {
        $users = User::where('name', 'like', "%$search%")->orWhere('username', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($users);
    }



   

    /**
     * API Angular
     * @return [json] [Current Logged User]
     */
    public function apiClientGetLoggedUser() {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * API Angular
     * @param  [string] $username [username in url]
     * @return [json]           [user found info]
     */
    public function apiClientGetUser(Request $request, $username) {
        $username = (string) $username;

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $getUser = User::with(['bdata', 'post', 'comment', 'feed.user', 'feed.like_feed'])->where('username', $username)->where('status', 1)->firstOrFail();

        $feeds = Feed::with(['user', 'like_feed', 'comment_feed.user', 'sub_cate_question.cate_question'])
                     ->orderBy('id', 'DESC')
                     ->where('id_user', $getUser['id'])
                     ->paginate(10);

        $max_points = BData::with(['post.subcategory'])->where('id_user', $getUser->id)->where('submit', 1)->where('status', 1)->where('point_exam', 10)->paginate(10);

        $getUser['is_following'] = $user->is_following($getUser->id);

        return response()->json([
            'getUser' => $getUser,
            'feeds' => $feeds,
            'max_points' => $max_points
        ]);
    }

    /**
     * API AngularJS lấy danh sách bảng xếp hạng theo GPA của User
     * @param  Request $request [token JWTAuth nếu có]
     * @return [json]           [Bảng xếp hạng GPA]
     */
    public function apiClientGetRank(Request $request) {

        // Sắp xếp danh sách User kèm theo Bdata theo GPA
        $users = User::with(['bdata'])->orderBy('gpa', 'DESC')->get();

        // Lọc loại bỏ các User chưa tham gia đủ 10 bài thi online
        foreach ($users as $key => $user) {
            $count_status_online = 0;
            foreach($user->bdata as $user_bdata) {
                if($user_bdata['status'] == 1) {
                    $count_status_online++;
                }
                if($count_status_online >= 10) {
                    break;
                }
            }
            if($count_status_online < 10) {
                unset($users[$key]);
            }
        }

        $users_sort = array();
        if(count($users) > 10) {
            for($i = 0; $i < 10; $i++) {
                $users_sort[] = $users[$i];
            }
        } else {
            $users_sort = $users;
        }


        // Kiểm tra sự tồn tại của User đang đăng nhập. Nếu có User đăng nhập thì sẽ return thêm rank user hiện tại
        $current_user = null;
        $token = JWTAuth::getToken();
        if($token) {
            $current_user = JWTAuth::toUser($token);
        } 
        
        // Kiểm tra user hiện tại có trong danh sách ranking không (đã tham gia trên 10 bài thi online)
        // Nếu chưa có thì return số bài cần phải làm để có rank
        if(count($current_user) > 0) {

            $current_rank = null;

            foreach ($users as $key => $user) {
                if($current_user->id == $user->id) {
                    $current_rank = $key + 1;
                    break;
                }
            }

            if($current_rank == null) {

                $count_status_online = BData::where('id_user', $current_user->id)->where('status', 1)->get();
                $current_rank_status = 10 - count($count_status_online);

                return response()->json([
                    'users_sort' => $users_sort,
                    'current_rank_status' => $current_rank_status
                ]);
            }

            return response()->json([
                'users_sort' => $users_sort,
                'current_rank' => $current_rank
            ]);
        }

        return response()->json([
            'users_sort' => $users_sort
        ]);
        
        
    }
}
