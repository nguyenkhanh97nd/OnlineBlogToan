@extends('editor.master')

@section('title-header')
    Edit Questions
@endsection
@section('title')
    Edit Questions
@endsection
@section('content')
<div class="content-section" style="padding-bottom:120px">

 @include('editor.blocks.error')

    <form action="{!! route('editor.questions.postEdit',$findPost->slug) !!}" enctype="multipart/form-data" method="POST" >
    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
    <input type="hidden" id="slug_post" name="slug_post" value="{{ $findPost->slug }}">
        <div class="form-group">
            <label>Post</label>
            <select class="form-control" name="id_post" id="id_post">
                <option value={!! $findPost->id !!} selected>{!! $findPost->name !!}</option>
                @foreach($posts as $post)
                    @if(count($post->question) == 0)
                        <option value="{!! $post->id !!}">{!! $post->name !!}</option> 
                    @endif
                @endforeach
            </select>
        </div>
    
        <!--Dùng để thêm bài viết có đề thi thử -->
        <div class="form-group drop_test" >
        <div class="row">

            <div class="col-md-12">
                <span>Số câu: </span><input type="number" class="quess" name="quess" value="{!! count($findPost->question) !!}" min="1" max="50">
            </div>

            <div class="col-md-12">
                <h3>Test Content</h3>
                @for($i=0;$i<count($findPost->question);$i++)
                    <?php $sentence[] = 'Câu '.($i+1).': '.$findPost->question[$i]['name']."\n".'A. '.$findPost->question[$i]['ans_a']."\n".'B. '.$findPost->question[$i]['ans_b']."\n".'C. '.$findPost->question[$i]['ans_c']."\n".'D. '.$findPost->question[$i]['ans_d']."\n"; ?>              
                @endfor

                <textarea class="test col-md-12" rows="10" name="test" style="font-size: 16px">{!! trim(implode($sentence)); !!}</textarea>
             </div>   
            <div class="col-md-12">
                    <h3>Result</h3>
                    @for($i=0;$i<count($findPost->question);$i++)
                        <?php $result[] = $findPost->question[$i]['ans_true']; ?>
                      
                    @endfor
                <textarea class="result col-md-12" name="result"  style="font-size: 16px">{!! implode($result); !!}</textarea>
             </div> 
             <div class="col-md-12">
                <h3>Preview</h3>
                <div class="col-md-12 questions">
                <div class="row">
                    <!--Khu vực cho questions -->

                    @for($i=0;$i<count($findPost->question);$i++)
                        <div class="input-group">
                            <span class="input-group-addon">Question {{ $i+1 }}: </span>
                            <input class="ques-{{ $i }} form-control" type="text" name="ques-{{ $i }}" value="{{ $findPost->question[$i]['name'] }}">
                        </div>
                        @if($findPost->question[$i]['image'] != NULL)
                        <center>
                            <img width="200px" height="112px" src="{{ url('upload/questions/'.$findPost->question[$i]['image']) }}"/>
                            <button type="button" name="{{ $findPost->question[$i]['image'] }}" class="delete-image btn btn-default">Xoá ảnh</button>
                        </center>
                        @endif
                        <div class="form-control">
                            <input class='img-{{ $i }}' type='file' name='img-{{ $i }}'/>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Answer A: </span>
                            <input class="ans-a{{ $i }} form-control" type="text" name="ans-a{{ $i }}" value="{{ $findPost->question[$i]['ans_a'] }}">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Answer B: </span>
                            <input class="ans-b{{ $i }} form-control" type="text" name="ans-b{{ $i }}" value="{{ $findPost->question[$i]['ans_b'] }}">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Answer C: </span>
                            <input class="ans-c{{ $i }} form-control" type="text" name="ans-c{{ $i }}" value="{{ $findPost->question[$i]['ans_c'] }}">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Answer D: </span>
                            <input class="ans-d{{ $i }} form-control" type="text" name="ans-d{{ $i }}" value="{{ $findPost->question[$i]['ans_d'] }}">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">True: </span>
                            <input class="ans-true{{ $i }} form-control" type="text" name="ans-true{{ $i }}" value="{{ $findPost->question[$i]['ans_true'] }}">
                        </div>

                    @endfor
                </div>
                </div>
            </div>
        </div>
        </div>

        <div style="clear:both"></div>

        <button type="submit" class="btn btn-default">Edit</button>
    </form>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){


/**
* Nhập số lượng câu hỏi
*/
    

    $('.quess').keyup(function(){

        $questions = $(this).val();
        $('.questions').html('');
        for($i = 0; $i< $questions; $i++){

/**
 * Xuất html lựa chọn
 */
            $('.questions').append("<div class='input-group'><span class='input-group-addon'>Question "+($i+1)+ ": </span><input class='ques-"+($i)+" form-control' type='text'  name='ques-"+($i)+"'></div><div class='form-group'><input class='img-"+($i)+" form-control' type='file' name='img-"+($i)+"'/></div><div class='input-group'><span class='input-group-addon'>Answer A: </span><input type='text' name='ans-a"+($i)+"' class='ans-a"+($i)+" form-control' value=''></div><div class='input-group'><span class='input-group-addon'>Answer B: </span><input type='text' name='ans-b"+($i)+"' class='ans-b"+($i)+" form-control' value=''></div><div class='input-group'><span class='input-group-addon'>Answer C: </span><input type='text' name='ans-c"+($i)+"' class='ans-c"+($i)+" form-control' value=''></div><div class='input-group'><span class='input-group-addon'>Answer D: </span><input type='text' name='ans-d"+($i)+"' class='ans-d"+($i)+" form-control' value=''></div><div class='input-group'><span class='input-group-addon'>True: </span><input type='text' name='ans-true"+($i)+"' class='ans-true"+($i)+" form-control' value=''></div><br/>"
            );

        }

    });

/**
* Input tự động vào form các câu hỏi và trả lời
*/

    $('.test').keyup(function(){

        $questions= $('.quess').val();

        $text = $('.test').val().trim();

        $array_text = $text.split("\n");     

        for($i=$questions-1;$i>=0;$i--){
            $('.ans-d' + $i).val( $array_text.pop().replace('D.','').trim()  );
            $('.ans-c' + $i).val( $array_text.pop().replace('C.','').trim()  );
            $('.ans-b' + $i).val( $array_text.pop().replace('B.','').trim()  );
            $('.ans-a' + $i).val( $array_text.pop().replace('A.','').trim() );
            $('.ques-' + $i).val( $array_text.pop().replace('Câu '+($i+1)+':','').trim() );
        }
    });

    $('.result').keyup(function(){

        $questions = $('.quess').val();

        $result = $('.result').val().trim();

        $array_result = $result.split("");

        for($i=$questions-1;$i>=0;$i--){
            $('.ans-true' + $i).val( $array_result.pop() );
        }
    });
    var idPost = {{ $findPost->id }}
    var _token = $('meta[name="csrf-token"]').attr('content');

    $('.delete-image').click(function(){
        var nameImage = $(this).attr('name');
        $.ajax({
            type:'POST',
            url:'../delete-image',
            data:{"_token": _token, "idPost": idPost, "nameImage": nameImage},
            async:false,
            success:function(data){
                if(data == true) {
                    alert('Xoá thành công');
                    location.reload();
                } else {
                    alert('Lỗi');
                }
            }
        });
    });


});
</script>
@endsection