@extends('editor.master')

@section('title-header')
    All Questions
@endsection
@section('title')
    All Questions
@endsection
@section('content')
    <!-- /.col-lg-12 -->
    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>Number</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Time Start</th>
                <th>Time Do</th>
                <th>Status</th>
                <th>Delete Questions Exam</th>
                <th>Edit Questions</th>
            </tr>
        </thead>
        <tbody>
        
        <?php $stt=0; ?>
            @foreach($listPost as $item)
                @if(count($listPost[$stt]->question)>0)
                <?php $stt++; ?>
            
            <tr class="table-content" align="center">
                <td>{{ $stt }}</td>
                <td>{!! $item["name"] !!}
                    <p><img width="200px" height="112px" src="{{ url('/upload/posts/'.$item['image']) }}"/></p>
                </td>
                <td>{!! $item["slug"] !!}</td>
                <td>{!! date('d-m-Y H:i:s',strtotime($item["time_start"])) !!}</td>
                <td>{!! date('H:i:s',strtotime($item["time_do"])) !!}</td>
                <td>@if($item['status']==1) {!! 'Active' !!} @else {!! 'Not active' !!} @endif</td>
                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Delete Questions Exam?')" href="{!! route('editor.questions.getDelete',$item['slug'] ) !!}"> Delete</a></td>
                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! route('editor.questions.getEdit',$item['slug']) !!}">Edit</a></td>
            </tr>
                @endif
            @endforeach
        
        </tbody>
    </table>
@endsection