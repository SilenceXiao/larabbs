@extends('layouts.app')
@section('title','消息通知')
@section('content')
    @if($notifications->count())
        @foreach($notifications as $notification)
        <a href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title'] }}</a>
        @endforeach
    @else
        <div class="empty-block"> 没有消息通知</div>
    @endif
@stop