<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;

use JWTAuth;

class FriendshipController extends Controller
{


    public function apiClientAddFollow(Request $request) {

        $username = (string) $request->username;
        $findUser = User::where('username', $username)->first();

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        if(count($findUser) > 0 && $findUser->id != $current_user->id) {
            $current_user->add_follow($findUser->id);
        } else {
            return response()->json([
                'fail' => 'Lỗi'
            ]);
        }

        return response()->json([
            'success' => 'Đã theo dõi'
        ]);

    }


    public function apiClientRemoveFollow(Request $request) {

        $username = (string) $request->username;
        $findUser = User::where('username', $username)->first();

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        if(count($findUser) > 0 && $findUser->id != $current_user->id) {
            $current_user->remove_follow($findUser->id);
        } else {
            return response()->json([
                'fail' => $username
            ]);
        }

        return response()->json([
            'success' => 'Bỏ theo dõi'
        ]);

    }


    public function apiClientFollowingList(Request $request) {

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);
        $users = '';

        if(isset($request->search_user)) {
            $search_user = (string) $request->search_user;
            $users = User::where('username', 'like', "%$search_user%")
                     ->orWhere('name', 'like', "%$search_user%")
                     ->orderBy('id', 'DESC')
                     ->get();

            foreach($users as $key => $user) {
                if($user->id == $current_user->id) {
                    unset($users[$key]);
                    break;
                }
            }
        }
        return response()->json([
            'followings' => $current_user->followings(),
            'followers' => $current_user->followers(),
            'users' => $users,

        ]);

    }

    public function apiClientFollowersList() {

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $followers = $current_user->followers();

        return response()->json([
            'followers' => $followers,
        ]);

    }


}
