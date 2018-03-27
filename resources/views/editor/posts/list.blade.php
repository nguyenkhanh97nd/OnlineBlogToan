@extends('editor.master')

@section('title-header')
    All Posts
@endsection
@section('title')
    All Posts
@endsection
@section('content')
    <!-- /.col-lg-12 -->
    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>Number</th>
                <th>Name</th>
                <th>Time Start</th>
                <th>Time Do</th>
                <th>Brief</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Views</th>
                <th>Status</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
        
        <?php $stt=0; ?>
            @foreach($listEditorPosts as $item)
            <?php $stt++; ?>
            <tr class="table-content" align="center">
                <td>{{ $stt }}</td>
                <td>{!! $item["name"] !!}
                    <p><img width="150px" height="auto" src="{{ url('/upload/posts/'.$item['image']) }}"/></p>
                </td>
                <td>{!! date('d-m-Y H:i:s',strtotime($item["time_start"])) !!}</td>
                <td>{!! date('H:i:s',strtotime($item["time_do"])) !!}</td>
                <td>{!! $item['brief'] !!}</td>
                <td>{!! $item->subcategory->category->name !!}</td>
                <td>{!! $item->subcategory->name !!}</td>
                <td>{!! $item["count_views"] !!}</td>
                <td>@if($item['status']==1) {!! 'Active' !!} @else {!! 'Not active' !!} @endif</td>
                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Delete Post?')" href="{!! route('editor.posts.getDelete',$item['slug'] ) !!}"> Delete</a></td>
                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! route('editor.posts.getEdit',$item['slug']) !!}">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection