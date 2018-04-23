<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use JWTAuth;
use App\BData;
use App\BQuestion;

class TestOnlineController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiClientTestOnlineIndex(Request $request) {

        $slug = (string) $request->paramUrl;

    	$post = Post::with(['subcategory.category', 'author'])
    				->where('slug', $slug)
    				->where('status', 1)
    				->firstOrFail();

        // Lấy current user từ JWT
    	$token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        // Lấy câu hỏi của post
        $bquestions = BQuestion::select(['name', 'ans_a', 'ans_b', 'ans_c', 'ans_d', 'image'])->where('id_post', $post['id'])->get();


        // Nếu tồn tại post và post có câu hỏi thì thực hiện tiếp
        // Ngược lại trả về none
        
    	if(isset($post) && count($bquestions) > 0) {

            // Lấy dữ liệu đã thi bài post này của người dùng
    		$bdata = BData::where('id_post',$post['id'])
    					  ->where('id_user', $current_user->id)
    					  ->first();

    		// Lấy thời gian hiện tại
            $current_time = date('Y-m-d H:i:s',time());

            // Lấy thời gian bắt đầu thi thử của hệ thống
            $start_time = $post['time_start'];

            // Chuyển thời gian làm bài của bài thi sang giây
            $do_time_parse = date_parse($post['time_do']);
            $seconds_do = $do_time_parse['hour'] * 3600 + $do_time_parse['minute'] * 60 + $do_time_parse['second'];

            // Khoảng thời gian lúc bắt đầu của người dùng vào web so với thời gian bắt đầu trong hệ thống
            $delta_time_start_online = strtotime($current_time) - strtotime($start_time);

            // Khoảng thời gian còn lại của bài thi.
            // Sẽ hiển thị trong khi thi và chờ kết thúc bài thi
            
            $delta_time_end_online = strtotime($start_time) + $seconds_do - strtotime($current_time);


            // Nếu chưa đến thời gian thi. Không thêm vào CSDL
            // Nếu đến thời gian thi. Thí sinh vào đúng giờ hoặc muộn 15 phút thì vẫn cho thi. Status = 1. Submit = 0. Lưu vào CSDL
            // Trường hợp còn lại: Vào muộn 15 phút và trước khi kết thúc thì Không lưu vào CSDL. Và không được tham gia bài thi. Sẽ CountDown để được thi như offline.
            // Trường hợp vào sau khi đã kết thúc bài thi. Tính là offline. Status = 10. Submit = 0. Lưu vào CSDL
            
            // Ngoại lệ:
            // 1) Thí sinh đang thi online Status = 1, Submit = 0. Trong quá trình làm bài bị out ra. Mà khi vào lại thời gian hệ thống đã hết, thí sinh khi load trang sẽ tự động chuyển Submit = 1. Lưu.
            // 2) Thí sinh thi offline Status = 10, Submit = 0. Trong quá trình làm bài bị out ra. Thì khi vào lại sẽ tiếp tục bài thi dựa theo hiệu current_time và time_started so với time_do. Đương nhiên không có trong bảng xếp hạng

            if($delta_time_start_online < 0) {

                // Chưa đến thời gian thi.
                return response()->json([
		    		'post' => $post,
		    		'wait_start' => -$delta_time_start_online,

		    	]);

            } elseif($delta_time_start_online <= $seconds_do*0.2) {

                // Nằm tong 20% thời gian thi

                if($bdata == NULL) {

                    // Nếu chưa có bài thi
                    // Tạo một bài thi mới

                    $new_data = new BData;
          
                    $dataAns='';
                    for($i=0;$i<count($bquestions);$i++){
                        $dataAns .= '-';
                    }
                    $new_data->id_post = $post['id'];
                    $new_data->status = 1; // Thi Online
                    $new_data->id_user = $current_user->id;
                    $new_data->ans_data = $dataAns;
                    $new_data->time_started = date('Y-m-d H:i:s',time());
                    $new_data->time_did = '00:00:00';
                    $new_data->save();

                    return response()->json([
                    	'post' => $post,
                    	'dataAns' => $dataAns,
                        'bquestions' => $bquestions,
                        'timeSubmitOnline' => $delta_time_end_online
                    ]);
                } else {

                    // Nếu đã có bài thi
                    // Tiếp tục thi nếu chưa submit (=0)
                    // Hoặc chuyển sang trạng thái chờ kết thúc thi online khi submit = 1
                    if($bdata['submit']==0) {

                        $dataAns = $bdata['ans_data'];

                        return response()->json([
	                    	'post' => $post,
	                    	'dataAns' => $dataAns,
                            'bquestions' => $bquestions,
                            'timeSubmitOnline' => $delta_time_end_online
	                    ]);
                    } else {

                        // Chưa hết thời gian làm bài nên không được xem đáp án ngay.
                        
                        return response()->json([
	                    	'post' => $post,
	                    	'wait_end' => $delta_time_end_online
	                    ]);
                    }

                }

            } else {

                // 1) Thời gian hiện tại nằm trong thời gian thi online của hệ thống
                // 2) Năm ngoài thời gian thi online. Sẽ tính là thi offline.
                
                if($delta_time_start_online < $seconds_do) {

                    // Nếu đang trong thời gian thi của hệ thống.
                    
                    if($bdata == NULL) {

                        // Nếu chưa từng thi trước đó => Thí sinh này đến muộn. Không được thi

                        return response()->json([
	                    	'post' => $post,
	                    	'eliminate' => $delta_time_end_online
	                    ]);

                    } else {

                        // Nếu đã tham gia bài thi
                        // Nếu chưa submit thì sẽ continue. submit = 0
                        // Nếu đã submit bài thi thì sẽ chờ kết thúc thi online để xem kết quả. submit = 1
                         
                        if($bdata['submit'] == 0) {

                            $dataAns = $bdata['ans_data'];

                            return response()->json([
		                    	'post' => $post,
		                    	'dataAns' => $dataAns,
                                'bquestions' => $bquestions,
                                'timeSubmitOnline' => $delta_time_end_online
		                    ]);
                        
                        } else {

                            // Chưa hết thời gian làm bài nên không được xem đáp án ngay.

                            return response()->json([
		                    	'post' => $post,
		                    	'wait_end' => $delta_time_end_online
		                    ]);

                        }
                        

                    }
                    

                } else {

                    // Nếu ngoài thời gian thi của hệ thống
                    
                    if($bdata == NULL) {

                        // Tạo một bài thi OFFLINE mới. Status = 10
                        
                        $new_data = new BData;
              
                        $dataAns='';
                        for($i=0;$i<count($bquestions);$i++){
                            $dataAns .= '-';
                        }
                        $new_data->id_post = $post['id'];
                        $new_data->status = 10;
                        $new_data->id_user = $current_user->id;
                        $new_data->ans_data = $dataAns;
                        $new_data->time_started = date('Y-m-d H:i:s',time());
                        $new_data->time_did = '00:00:00';
                        $new_data->save();

                        return response()->json([
	                    	'post' => $post,
	                    	'dataAns' => $dataAns,
                            'bquestions' => $bquestions,
                            'timeSubmitOffline' => $seconds_do
	                    ]);

                    } else {

                        // Đã có bài thi. Nhưng bị out ra hoặc refresh

                        // 1) Nếu ngoài thời gian thi của hệ thống. Và submit vẫn bằng 0 thì tiến hành thi tiếp. Thời gian thi còn lại sẽ được tính tiếp từ time_started và current_time. Nếu Hiệu vượt quá thời gian cho phép thì submit luôn.
                        
                        if($bdata['submit'] == 0) {

                            // Thời gian bắt đầu thi thử của người dùng
                            $time_started = $bdata['time_started'];

                            // Khoảng thời gian hiện tại với thời gian bắt đầu dùng để so sánh với thời gian cho phép của hệ thống
                            // Nếu đã vượt quá thời gian thì submit luôn và không cho thi tiếp
                            
                            $delta_time_did = strtotime($current_time) - strtotime($time_started);

                            if($delta_time_did >= $seconds_do) {

                                $ans_true = BQuestion::where('id_post',$post['id'])->pluck('ans_true')->toArray();
                                $dataAns = $bdata['ans_data'];
                                $points = 0;
                                for($i = 0; $i < count($ans_true); $i++) {
                                    if($ans_true[$i] == $dataAns[$i]) {
                                        $points++;
                                    }
                                }
                                $bdata->point_exam = 10 / count($ans_true) * $points;
                                $bdata->submit = 1;
                                $bdata->save();

                                // Cập nhật GPA cho User
                                if($bdata['status'] == 1) {
                                    $getDataCurrentUser = BData::where('id_user', $current_user->id)
                                        ->where('status',1)
                                        ->pluck('point_exam')
                                        ->toArray();
                                    $total = 0;
                                    $key = 0;
                                    foreach ($getDataCurrentUser as $getData) {
                                        $total += $getData;
                                        $key++;
                                    }
                                    $gpa = $total / $key;

                                    $current_user->gpa = $gpa;
                                    $current_user->save();

                                }
                                // Lấy bảng xếp hạng thi online
                                
                                $users = BData::with(['user'])
                                              ->where('id_post',$post['id'])
                                              ->where('status',1)
                                              ->orderBy('point_exam','DESC')
                                              ->get();

                                return response()->json([
			                    	'post' => $post,
			                    	'dataAns' => $dataAns,
			                    	'ans_true' => $ans_true,
			                    	'points' => $points,
			                    	'users' => $users,
                                    'bquestions' => $bquestions
			                    ]);

                            } else {

                                // Nếu vẫn còn thời gian thi OFFLINE

                                $dataAns = $bdata['ans_data'];
                                return response()->json([
			                    	'post' => $post,
			                    	'dataAns' => $dataAns,
                                    'bquestions' => $bquestions,
                                    'timeSubmitOffline' => $seconds_do - $delta_time_did
			                    ]);

                            }

                        } else {

                            // Đã submit. Hoàn thành bài thi
                            // Gọi đáp án để người dùng xem lại
                            
                            $ans_true = BQuestion::where('id_post',$post['id'])->pluck('ans_true')->toArray();
                            $dataAns = $bdata['ans_data'];
                            $points = $bdata['point_exam'];

                            // Lấy bảng xếp hạng thi online
                            $users = BData::with(['user'])->where('id_post',$post['id'])->where('status',1)->orderBy('point_exam','DESC')->take(5)->get();

                            $all_rank = BData::where('id_post',$post['id'])->where('status',1)->orderBy('point_exam','DESC')->pluck('id_user')->toArray();

                            $current_user_rank_status = "Bạn không thi online, không có rank";

                            if(in_array($current_user->id, $all_rank)) {
                                $current_user_rank_status = "Bạn xếp thứ ".(array_search($current_user->id, $all_rank) + 1)." trong tổng số ".count($all_rank)." thí sinh dự thi online.";
                            }

                            return response()->json([
		                    	'post' => $post,
		                    	'dataAns' => $dataAns,
		                    	'ans_true' => $ans_true,
		                    	'points' => $points,
		                    	'users' => $users,
                                'bquestions' => $bquestions,
                                'current_user_rank_status' => $current_user_rank_status,

		                    ]);
                        }
                    }
                }
            }

    	} else {
    		return response()->json([
    			'error' => true
    		]);
    	}
    }

    public function apiClientAjaxAnswer(Request $request) {

        // Lấy current user từ JWT
        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $slug = (string) $request->paramUrl;
        $key = (string) $request->answerKey;
        $value = (string) $request->answerValue;

        $post = Post::with(['subcategory.category', 'author'])
                    ->where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();

        $data = BData::where('id_user',$current_user->id)->where('id_post',$post['id'])->first();

        // Lấy thời gian hiện tại
        $current_time = date('Y-m-d H:i:s',time());

                // Lấy thời gian bắt đầu thi thử của hệ thống
        $start_time = $post['time_start'];

        // Chuyển thời gian làm bài của bài thi sang giây
        $do_time_parse = date_parse($post['time_do']);
        $seconds_do = $do_time_parse['hour'] * 3600 + $do_time_parse['minute'] * 60 + $do_time_parse['second'];


        if($data['submit'] == 1) {

            // Nếu đã submit thì không cho submit đáp án nữa

            return response()->json([
                'error' => true
            ]);
        } else {

            // Nếu chưa submit bài thi
            // 1) Bài thi online. Kiểm tra thời gian có hợp lệ không.
            // 2) Bài thi offline. Kiểm tra thời gian có hợp lệ không

            if($data['status'] == 1) {
                $delta_time_end_online = strtotime($start_time) + $seconds_do - strtotime($current_time);

                if($delta_time_end_online <= 0) {
                    return response()->json([
                        'timeSubmitOnline' => 1
                    ]);
                } else {
                    $update = $data['ans_data'];
                    $update[$key] = $value;
                    $data->ans_data = $update;
                    $data->time_did = gmdate("H:i:s",strtotime($current_time) - strtotime($start_time));
                    $data->save();

                    return response()->json([
                        'timeSubmitOnline' => $delta_time_end_online,
                        'dataAns' => $update
                    ]);
                }
            } else {
                $time_started = $data['time_started'];  
                $delta_time_did = strtotime($current_time) - strtotime($time_started);
                if($delta_time_did >= $seconds_do) {
                    return response()->json([
                        'timeSubmitOffline' => 1
                    ]);
                } else {
                    $update = $data['ans_data'];
                    $update[$key] = $value;
                    $data->ans_data = $update;
                    $data->time_did = gmdate("H:i:s",$delta_time_did);
                    $data->save();

                    return response()->json([
                        'timeSubmitOffline' => $seconds_do - $delta_time_did,
                        'dataAns' => $update
                    ]);
                }
            }
        }
        
    }

    public function apiClientSubmitTest(Request $request) {
        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $slug = (string) $request->paramUrl;

        $post = Post::with(['subcategory.category', 'author'])
                    ->where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();
        $data = BData::where('id_user',$current_user->id)->where('id_post',$post['id'])->first();

        if($data['submit'] == 0) {
            $ans_true = BQuestion::where('id_post',$post['id'])->pluck('ans_true')->toArray();
            $ans_user = $data['ans_data'];

            $points = 0;
            for($i = 0; $i < count($ans_true); $i++) {
                if($ans_true[$i] == $ans_user[$i]) {
                    $points++;
                }
            }

            $data->point_exam = 10 / count($ans_true) * $points;
            $data->submit = 1;
            $data->save();

            if($data['status'] == 1) {
                $getDataCurrentUser = BData::where('id_user', $current_user->id)
                    ->where('status',1)
                    ->pluck('point_exam')
                    ->toArray();
                $total = 0;
                $key = 0;
                foreach ($getDataCurrentUser as $getData) {
                    $total += $getData;
                    $key++;
                }
                $gpa = $total / $key;

                $current_user->gpa = $gpa;
                $current_user->save();
            }

            return response()->json([
                'submit' => true
            ]);
        }
        return response()->json([
            'submit' => false
        ]);
    }

}
