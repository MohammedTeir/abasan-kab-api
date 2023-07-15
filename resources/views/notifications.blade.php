@extends('layouts.main-layout')

@section('title',' لوحة التحكم - الاٍشعارات')

@section('css-ext')
@endsection

@section('content')

<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>كل الاٍشعارات</h4>
       </div>
    </div>
    <div class="activity">
       <div class="activity-box">
          <ul class="activity-list">
             @foreach ($notifications as $notification)

             <li>
                <div class="activity-user">
                   <a  title data-toggle="tooltip">
                   <img alt="User" src="{{$notification->user->imageurl}}" class=" img-fluid">
                   </a>
                </div>
                <div class="activity-content">
                   <div class="timeline-content">
                      <a  class="name">{{$notification->user->name}} </a> {{$notification->message}}
                      <span class="time">{{$notification->notificationtime}}</span>
                   </div>
                </div>
             </li>


             @endforeach
          </ul>
       </div>
    </div>
 </div>

@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
@endsection

