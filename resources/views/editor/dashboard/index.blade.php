@extends('editor.master')

@section('title-header')
    Dashboard Editor
@endsection
@section('content')


<div class="row tile-count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
              <span class="count-top"><span class="glyphicon glyphicon-user"></span> Accepted Posts</span>
              <div class="count">{!! count($acceptedPosts) !!}</div>
              <span class="count-bottom"><font color="#42b72a">{!! '+' . count($acceptedPosts) !!}</font>{!! ' in this Week' !!}</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
              <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Pending Posts</span>
              <div class="count">{!! count($pendingPosts) !!}</div>
              <span class="count-bottom"><font color="#42b72a">{!! '+' . count($pendingPosts) !!}</font>{!! ' in this Week' !!}</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count-top"><span class="glyphicon glyphicon-signal"></span> Posts With Questions</span>
              <div class="count">{!! count($posts_with_questions) !!}</div>
              <span class="count-bottom"><font color="#42b72a">{!! '+' . count($posts_with_questions) !!}</font>{!! ' in this Week' !!}</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
              <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Total Questions</span>
              <div class="count">{!! count($questions) !!}</div>
              <span class="count-bottom"><font color="#42b72a">{!! '+' . count($questions) !!}</font>{!! ' in this Week' !!}</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
              <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Total Comments</span>
              <div class="count">{!! count($comments) !!}</div>
              <span class="count-bottom"><font color="#42b72a">{!! '+' . count($comments) !!}</font>{!! ' in this Week' !!}</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
              <span class="count-top"><span class="glyphicon glyphicon-time"></span> Total Data</span>
              <div class="count">{!! count($datas) !!}</div>
              <span class="count-bottom"><font color="#42b72a">{!! '+' . count($datas) !!}</font>{!! ' in this Week' !!}</span>
            </div>
</div>
@endsection