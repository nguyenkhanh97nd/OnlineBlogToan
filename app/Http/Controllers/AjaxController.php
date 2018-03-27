<?php

namespace App\Http\Controllers;

use App\SubCategory;
use App\BData;
use App\BQuestion;
use App\Post;
use App\User;

use Auth;
use Request;
use Carbon\Carbon;

class AjaxController extends Controller
{

    /**
     * ADMIN ================================
     */

    // Lấy sub Category trong phần backend khi chọn category
    public function getSubcategory() {
        if(Request::ajax()) {
            $idCategory = Request::get('idCategory');
            $subCategory = SubCategory::where('category_id',$idCategory)->where('status', 1)->get();
            $res = '';
            foreach($subCategory as $subcate) {
                 $res .= "<option value='".$subcate->id."'>".$subcate->name."</option>";
            }
            return $res;
        }
    }

    // Xoá hình ảnh của câu hỏi
    public function postDeleteImageQuestion() {
        if(Request::ajax()) {
            $idPost = Request::get('idPost');
            $nameImage = Request::get('nameImage');

            $question = BQuestion::where('id_post',$idPost)->where('image',$nameImage)->first();
            
            if(file_exists('upload/questions/'.$nameImage)) {
                unlink('upload/questions/'.$nameImage);
            }
            $question->image = '';
            $question->save();

            return 1;

        }
    }

    // Biểu đồ thành viên đăng kí mới theo ngày
    public function chartMember() {
        if(Request::ajax()) {
            $members = User::where('created_at','>',Carbon::now()->subDays(6)->toDateString())->pluck('created_at')->toArray();
            return $members;
        }
    }

    // Biểu đồ giới tính
    public function chartGender() {
        if(Request::ajax()) {
            $members = User::pluck('gender')->toArray();
            return $members;
        }
    }



    /**
     * FRONTEND ==================
     */

    // Update đáp án của người dùng ngay khi người dùng lựa chọn
    public function postAnswer() {
    	if( Request::ajax() ) {
            $idAns = Request::get('idAns');
            $valueAns = Request::get('valueAns');
            $idPost = Request::get('idPost');
            $idUser = Auth::id();

            $data = BData::where('id_user',$idUser)->where('id_post',$idPost)->first();
            $update = $data['ans_data'];
            $update[$idAns] = $valueAns;
            $data->ans_data = $update;
            $data->save();

            return $valueAns;
        }
    }

    // Lấy thời gian bắt đầu bài thi của hệ thống
    public function getTimeStart() {
        if(Request::ajax()) {
            $idPost = Request::get('idPost');
            $post = Post::where('id',$idPost)->first();

            $get_time_start = $post['time_start'];
            $get_current_time = date('Y-m-d H:i:s',time());

            $parsed_time_start = date_parse($get_time_start);
            $seconds_start = $parsed_time_start['hour'] * 3600 + $parsed_time_start['minute'] * 60 + $parsed_time_start['second'];

            $parsed_current_time = date_parse($get_current_time);
            $seconds_current = $parsed_current_time['hour'] * 3600 + $parsed_current_time['minute'] * 60 + $parsed_current_time['second'];


            $years = $parsed_time_start['year'] - $parsed_current_time['year'];
            $months = $parsed_time_start['month'] - $parsed_current_time['month'];
            $days = $parsed_time_start['day'] - $parsed_current_time['day'];

            if($years > 0) {
                return 'Next year';
            }else if($months > 0) {
                return 'Next month';
            } else if(($days == 1 && $seconds_start - $seconds_current > 0) || $days >=2) {
                return 'More than 1 day';
            } else {
                $seconds = $seconds_start + 86400 - $seconds_current;
                if($seconds != 86400) {
                    $count_down_start = gmdate('H:i:s', $seconds_start + 86400 - $seconds_current);
                } else {
                    $seconds = 86400;
                    $count_down_start = 0;
                }
                return $count_down_start;
            }

        }
    }

    // Lấy thời gian kết thúc bài thi của hệ thống
    public function getTimeEnd() {
        if(Request::ajax()) {
            $idPost = Request::get('idPost');
            $post = Post::where('id',$idPost)->first();

            $get_time_start = $post['time_start'];
            $get_time_do = $post['time_do'];
            $get_current_time = date('Y-m-d H:i:s',time());

            $parsed_time_start = date_parse($get_time_start);
            $seconds_start = $parsed_time_start['hour'] * 3600 + $parsed_time_start['minute'] * 60 + $parsed_time_start['second'];

            $parsed_time_do = date_parse($get_time_do);
            $seconds_do = $parsed_time_do['hour'] * 3600 + $parsed_time_do['minute'] * 60 + $parsed_time_do['second'];

            $parsed_current_time = date_parse($get_current_time);
            $seconds_current = $parsed_current_time['hour'] * 3600 + $parsed_current_time['minute'] * 60 + $parsed_current_time['second'];

            if($seconds_start + $seconds_do - $seconds_current >0) {
                $count_down_waiting_end = gmdate('H:i:s', $seconds_start + $seconds_do - $seconds_current);
            } else {
                $count_down_waiting_end = 0;
            }
            return $count_down_waiting_end;
        }
    }

    public function getTime() {
        if(Request::ajax()) {

            // Lấy dữ liệu từ ajax gửi đi
            $idPost = Request::get('idPost');
            $idUser = Auth::id();

            // Lấy thời gian đã làm bài trong bảng Data
            $data = BData::where('id_user',$idUser)->where('id_post',$idPost)->first();
            $get_time_did = $data['time_did'];
            $get_time_started = $data['time_started'];
            $get_current_time = date('Y-m-d H:i:s',time());

            

            // Lấy thời gian tối được làm trong bảng Post
            $post = Post::where('id',$idPost)->first();
            $get_time_do = $post['time_do'];

            // Chuyển dữ liệu từ string sang dạng time.
            // Đưa thời gian về giây. Sau đó tăng lên ++ để cập nhật thời gian đã làm
            $seconds_did = strtotime($get_current_time) - strtotime($get_time_started);
            
            

            $parsed_time_do = date_parse($get_time_do);
            $seconds_do = $parsed_time_do['hour'] * 3600 + $parsed_time_do['minute'] * 60 + $parsed_time_do['second'];

            if($seconds_do-$seconds_did>0) {
                $get_time_show = gmdate("H:i:s", ($seconds_do-$seconds_did));
                $get_time_did = gmdate("H:i:s",$seconds_did);
                // $seconds_did++;
                $data->time_did = $get_time_did;
                $data->save();

                return $get_time_show;
            } else {
                $ans_true = BQuestion::where('id_post',$idPost)->pluck('ans_true')->toArray();
                $ans_user = $data['ans_data'];
                $points = 0;
                for($i = 0; $i < count($ans_true); $i++) {
                    if($ans_true[$i] == $ans_user[$i]) {
                        $points++;
                    }
                }
                $data->point_exam = $points;
                $data->submit = 1;
                $data->save();
                return 0;
            }
        }
    }

    public function postExam() {
        if(Request::ajax()) {
            $idPost = Request::get('idPost');
            $idUser = Auth::id();

            // Lấy thời gian đã làm bài trong bảng Data
            $data = BData::where('id_user',$idUser)->where('id_post',$idPost)->first();
            $ans_true = BQuestion::where('id_post',$idPost)->pluck('ans_true')->toArray();
            $ans_user = $data['ans_data'];
            $points = 0;
            for($i = 0; $i < count($ans_true); $i++) {
                if($ans_true[$i] == $ans_user[$i]) {
                    $points++;
                }
            }
            $data->point_exam = $points;
            $data->submit = 1;
            $data->save();
            return 1;
        }
    }

}
