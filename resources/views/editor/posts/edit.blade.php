@extends('editor.master')

@section('title-header')
    Edit Post
@endsection
@section('title')
    Edit {!! $findPost['name'] !!}
@endsection
@section('content')
<div class="content-section" style="padding-bottom:120px">

 @include('editor.blocks.error')

    <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category" id="category">
                <option>Trống</option>
                @foreach($category as $cate)
                   <option 
                        @if($findPost->subcategory->category->id == $cate->id)
                            {!! 'selected' !!}
                        @endif
                   value="{!! $cate->id !!}">{!! $cate->name !!}</option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Sub Category</label>
            <select class="form-control" name="subcategory" id="subcategory">
                @foreach($subcategory as $subcate)
                   <option 
                        @if($findPost['subcategory_id'] == $subcate->id)
                            {!! 'selected' !!}
                        @else
                            {!! 'hidden' !!}
                        @endif
                   value="{!! $subcate->id !!}">{!! $subcate->name !!}</option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" name="txtName" placeholder="Name Post" value="{!! $findPost['name'] !!}">
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input class="form-control" name="txtSlug" placeholder="Slug Post" value="{!! $findPost['slug'] !!}">
        </div>
        <div class="form-group">
            <label>Time Start</label>
            <input class="form-control" type="datetime" name="time_start" placeholder="Time Start" value="{!! $findPost['time_start'] !!}">
        </div>
        <div class="form-group">
            <label>Time Do</label>
            <input class="form-control" type="time" name="time_do" placeholder="Time Do" value="{!! $findPost['time_do'] !!}">
        </div>
        <div class="form-group">
            <label>Brief</label>
            <textarea class="form-control ckeditor" rows="3" name="txtBrief">{!! $findPost['brief'] !!}</textarea>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea class="form-control ckeditor" rows="5" name="txtContent" id="demo">{!! $findPost['content'] !!}</textarea>
        </div>
        <div class="form-group">
            <label>Image</label>
            <p><img width="200px" height="112px" src="{{ url('/upload/posts/'.$findPost['image']) }}"/></p>
            <input type="file" name="image" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-default">Edit</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </form>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{!! url('/editor/ckeditor/ckeditor.js') !!}"></script>
    <script>
        $(document).ready(function(){
            $('#category').change(function(){
                var idCategory = $(this).val();
                var _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type:'POST',
                    url:'/editor/posts/getSubcategory',
                    data: {"_token": _token, "idCategory": idCategory},
                    success:function(data) {
                        $("#subcategory").html(data);
                    }
                });
            });
        });
    </script>
@endsection