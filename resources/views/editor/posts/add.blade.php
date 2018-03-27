@extends('editor.master')

@section('title-header')
    Add Post
@endsection
@section('title')
    Add Post
@endsection
@section('content')
<div class="content-section" style="padding-bottom:120px">

 @include('editor.blocks.error')

    <form action="{!! route('editor.posts.postAdd') !!}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category" id="category">
                <option></option>
                @foreach($category as $cate)
                   <option value="{!! $cate->id !!}">{!! $cate->name !!}</option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Sub Category</label>
            <select class="form-control" name="subcategory" id="subcategory">   </select>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" name="txtName" placeholder="Name Post" value="{!! old('txtName') !!}">
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input class="form-control" name="txtSlug" placeholder="Slug Post" value="{!! old('txtSlug') !!}">
        </div>
        <div class="form-group">
            <label>Time Start</label>
            <input class="form-control" type="datetime-local" name="time_start" placeholder="Time Start" value="{!! old('time_start') !!}">
        </div>
        <div class="form-group">
            <label>Time Do</label>
            <input class="form-control" type="time" name="time_do" placeholder="Time Do" value="{!! old('time_do') !!}">
        </div>
        <div class="form-group">
            <label>Brief</label>
            <textarea class="form-control ckeditor" rows="3" name="txtBrief">{!! old('txtBrief') !!}</textarea>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea class="form-control ckeditor" rows="5" name="txtContent" id="demo">{!! old('txtContent') !!}</textarea>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control"/>
        </div>
       
        <button type="submit" class="btn btn-default">Add</button>
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