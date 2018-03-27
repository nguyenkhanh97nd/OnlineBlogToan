@extends('editor.master')

@section('title-header')
    Add Questions
@endsection
@section('title')
    Add Questions
@endsection
@section('content')
<div class="content-section" style="padding-bottom:120px">

 @include('editor.blocks.error')

    <form action="{!! route('editor.questions.postAdd') !!}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
        <div class="form-group">
            <label>Post</label>
            <select class="form-control" name="id_post" id="id_post">
                <option></option>
                @foreach($posts as $post)
                    @if(count($post->question)==0)
                    <option value="{!! $post->id !!}">{!! $post->name !!}</option> 
                    @endif
                @endforeach
            </select>
        </div>
    
        <!--Dùng để thêm bài viết có đề thi thử -->
        <div class="form-group drop_test" >
        <div class="row">
            <div class="col-md-12">
                <span>Số câu: </span><input type="number" class="quess" name="quess" value="{!! old('quess') !!}" min="1" max="50">
            </div>
            <div class="col-md-12">
                <h3>Test Content</h3>
                <textarea class="col-md-12 test" rows="10" name="test" style="font-size: 16px">{!! old('test') !!}</textarea>
            </div>
            <div class="col-md-12">
                <h3>Result</h3>
                <textarea class="col-md-12 result" name="result" style="font-size: 16px">{!! old('result') !!}</textarea>
            </div>
            <div class="col-md-12">
                <h3>Preview</h3>
                <div class="col-md-12">
                <div class="row questions">
                    <!--Khu vực cho questions -->
                </div>
                </div>
            </div>
        </div>
        </div>

        <div style="clear:both"></div>
        <button type="submit" class="btn btn-default">Add</button>
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
    
});
</script>
@endsection