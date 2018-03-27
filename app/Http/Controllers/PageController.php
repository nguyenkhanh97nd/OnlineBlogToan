<?php

namespace App\Http\Controllers;


/*-- Cần import thư viện Facades cho Lar5.4--*/
use Illuminate\Support\Facades\Hash;
/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Post;
use App\BData;
use App\BQuestion;


class PageController extends Controller
{

/**
 * Gọi bài thi cua 1 Post
 * Tham số vào $slug của post
 * Kết quả trả về là bài thi hoặc kết quả bài thi
 */
    public function getTest($slug){

        $findPost = Post::where('status', 1)->where('slug',$slug)->first();
        if(isset($findPost) && count($findPost->question) > 0) {

            $idUser = Auth::id();
            $bdata = BData::where('id_post',$findPost['id'])->where('id_user',$idUser)->first();
            
            // Lấy thời gian hiện tại
            $current_time = date('Y-m-d H:i:s',time());

            // Lấy thời gian bắt đầu thi thử của hệ thống
            $start_time = $findPost['time_start'];

            

            // Chuyển thời gian làm bài hệ thống sang giây
            $do_time_parse = date_parse($findPost['time_do']);
            $seconds_do = $do_time_parse['hour'] * 3600 + $do_time_parse['minute'] * 60 + $do_time_parse['second'];

            // Khoảng thời gian lúc bắt đầu của người dùng so với thời gian bắt đầu trong hệ thống
            $delta_time = strtotime($current_time) - strtotime($start_time);



            // Nếu chưa đến thời gian thi. Status = 0. Submit = 0
            // Nếu đến thời gian thi. Thí sinh vào đúng giờ hoặc muộn 15 phút thì vẫn cho thi. Status = 1. Submit = 0.
            // Trường hợp còn lại: Vào muộn 15 phút và trước khi kết thúc thì Status = 10. Và không được tham gia bài thi. Sẽ CountDown để được thi như offline. Status sẽ chuyển từ 10 -> 10. Submit = 0.
            // Trường hợp vào sau đó. Cũng tính là offline. Status = 10. Submit = 0.
            
            
            if($delta_time < 0) {

                // Gọi view chờ.
                $message = 'wait_start';
                return view('pages.testonline.waiting',compact(['findPost','message']));

            } elseif($delta_time <= $seconds_do*0.2) {

                if($bdata == NULL) {

                    // Tạo một bài thi mới
                    $new_data = new BData;
          
                    $data='';
                    for($i=0;$i<count($findPost->question);$i++){
                        $data .= '-';
                    }
                    $new_data->id_post = $findPost['id'];
                    $new_data->status = 1;
                    $new_data->id_user = $idUser;
                    $new_data->ans_data = $data;
                    $new_data->time_started = date('Y-m-d H:i:s',time());
                    $new_data->time_did = '00:00:00';
                    $new_data->save();

                    return view('pages.testonline.new',compact(['findPost','data']));
                } else {

                    // Đã tồn tại bài thi
                    if($bdata['submit']==0) {
                        $data = $bdata['ans_data'];
                        return view('pages.testonline.continue',compact(['findPost','data']));
                    } else {

                        // Chưa hết thời gian làm bài nên không được xem đáp án ngay.
                        $message = 'wait_end';
                        return view('pages.testonline.waiting',compact(['findPost','message']));
                    }

                }

            } else {

                
                if($delta_time < $seconds_do) {

                    // Nếu đang trong thời gian thi của hệ thống.
                    
                    if($bdata == NULL) {

                        // Nếu chưa từng thi trước đó. Thí sinh này đến muộn
                        $message = 'eliminate';
                        return view('pages.testonline.waiting',compact(['findPost','message']));

                    } else {

                        // Nếu đã tham gia bài thi và submit bài thi thì gọi result
                        // Nếu chưa submit thì sẽ continue
                         
                        if($bdata['submit'] == 0) {

                            $data = $bdata['ans_data'];
                            return view('pages.testonline.continue',compact(['findPost','data']));
                        
                        } else {

                            // Chưa hết thời gian làm bài nên không được xem đáp án ngay.
                            $message = 'wait_end';
                            return view('pages.testonline.waiting',compact(['findPost','message']));
                        }
                        

                    }
                    

                } else {
                    // Nếu ngoài thời gian thi của hệ thống
                    if($bdata == NULL) {
                        // Tạo một bài thi mới
                        $new_data = new BData;
              
                        $data='';
                        for($i=0;$i<count($findPost->question);$i++){
                            $data .= '-';
                        }
                        $new_data->id_post = $findPost['id'];
                        $new_data->status = 10;
                        $new_data->id_user = $idUser;
                        $new_data->ans_data = $data;
                        $new_data->time_started = date('Y-m-d H:i:s',time());
                        $new_data->time_did = '00:00:00';
                        $new_data->save();

                        return view('pages.testonline.new',compact(['findPost','data']));
                    } else {
                        // Nếu ngoài thời gian thi của hệ thống. và submit vẫn bằng 0 thì tiến hành thi tiếp
                        if($bdata['submit'] == 0) {

                            // Thời gian bắt đầu thi thử của người dùng
                            $time_started = $bdata['time_started'];

                            // Khoảng thời gian hiện tại với thời gian bắt đầu dùng để so sánh với thời gian cho phép của hệ thống
                            // Nếu đã vượt quá thời gian thì submit luôn và không cho thi tiếp
                            
                            $delta_time_did = strtotime($current_time) - strtotime($time_started);
                            if($delta_time_did > $seconds_do) {

                                $ans_true = BQuestion::where('id_post',$findPost['id'])->pluck('ans_true')->toArray();
                                $data = $bdata['ans_data'];
                                $points = 0;
                                for($i = 0; $i < count($ans_true); $i++) {
                                    if($ans_true[$i] == $data[$i]) {
                                        $points++;
                                    }
                                }
                                $bdata->point_exam = $points;
                                $bdata->submit = 1;
                                $bdata->save();

                                $users = BData::where('id_post',$findPost['id'])->where('status',1)->orderBy('point_exam','DESC')->get();

                                return view('pages.testonline.result',compact(['ans_true','findPost','data','points','users']));
                            } else {
                                $data = $bdata['ans_data'];
                                return view('pages.testonline.continue',compact(['findPost','data']));
                            }

                        } else {

                            // Gọi đáp án để người dùng xem lại
                            $ans_true = BQuestion::where('id_post',$findPost['id'])->pluck('ans_true')->toArray();
                            $data = $bdata['ans_data'];
                            $points = $bdata['point_exam'];

                            $users = BData::where('id_post',$findPost['id'])->where('status',1)->orderBy('point_exam','DESC')->get();

                            return view('pages.testonline.result',compact(['ans_true','findPost','data','points','users']));
                        }
                    }

                }

            }
        } else {
            return view('pages.errors');
        }
    }
}
