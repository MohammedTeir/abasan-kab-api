<div class="header">
    <div class="header-left active">
       <a href="{{route('dashboard.home')}}" class="logo logo-normal">
       <img src="{{asset('assets/img/logo.svg')}}" alt>
       </a>
       <a href="{{route('dashboard.home')}}" class="logo logo-white">
       <img src="{{asset('assets/img/logo-white.svg')}}" alt>
       </a>
       <a href="{{route('dashboard.home')}}" class="logo-small">
       <img src="{{asset('assets/img/logo-small.svg')}}" alt>
       </a>
       <a id="toggle_btn" href="javascript:void(0);">
       <i data-feather="chevrons-left" class="feather-16"></i>
       </a>
    </div>
    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
    <span class="bar-icon">
    <span></span>
    <span></span>
    <span></span>
    </span>
    </a>
    <ul class="nav user-menu">



        <li class="nav-item ">
            <div class="switch-wrapper">

                <div id="dark-mode-toggle">

                   <span class="light-mode active"><i class="far fa-sun"></i></span>
                   <span class="dark-mode"><i class="far fa-moon"></i> </span>
                </div>

             </div>
         </li>

       <li class="nav-item nav-item-box">
          <a href="javascript:void(0);" id="btnFullscreen">
          <i data-feather="maximize"></i>
          </a>
       </li>
       <li class="nav-item dropdown nav-item-box">
          <a  class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
          <i data-feather="bell"></i><span class="badge rounded-pill">{{$notifications->count()}}</span>
          </a>
          <div class="dropdown-menu notifications">
             <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                <a onclick="performClearAll()" class="clear-noti"> Clear All </a>
             </div>
             <div class="noti-content">
                <ul class="notification-list">

                   @foreach ($notifications as $notification)
                   <li class="notification-message">
                    <a href="{{route('notifications.index')}}">
                       <div class="media d-flex">
                          <span class="avatar flex-shrink-0">
                          <img alt src="{{$notification->user->imageurl}}">
                          </span>
                          <a onclick="performMarkAsRead({{$notification->id}})" class="mark-read-btn">
                            <i data-feather="check-circle"></i>
                        </a>

                          <div class="media-body flex-grow-1">
                             <p class="noti-details"><span class="noti-title">{{$notification->user->name}}</span> {{$notification->message}}</p>
                             <p class="noti-time"><span class="notification-time">{{$notification->notificationtime}}</span></p>

                            </div>
                       </div>
                    </a>
                 </li>

                   @endforeach



                </ul>
             </div>
             <div class="topnav-dropdown-footer">
                <a href="{{route('notifications.index')}}">View all Notifications</a>
             </div>
          </div>
       </li>
       <li class="nav-item dropdown has-arrow main-drop">
          <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
          <span class="user-info">
          <span class="user-letter">
          @if (Auth::user()->image_url==null)
          <img src="{{asset('assets/img/profiles/default-profile.png')}}" alt class="img-fluid">
          @else
          <img src="{{Auth::user()->image_url}}" alt class="img-fluid">
          @endif
          </span>
          <span class="user-detail">
            <span class="user-name">{{Auth::user()->name}}</span>
            <span class="user-role">{{Auth::user()->role->name}}</span>
          </span>
          </span>
          </a>
          <div class="dropdown-menu menu-drop-user">
             <div class="profilename">
                <div class="profileset">
                   <span class="user-img">@if (Auth::user()->image_url==null)
                    <img src="{{asset('assets/img/profiles/default-profile.png')}}" alt class="img-fluid">
                    @else
                    <img src="{{Auth::user()->image_url}}" alt class="img-fluid">
                    @endif
                   <span class="status online"></span></span>
                   <div class="profilesets">
                    <span class="user-name">{{Auth::user()->name}}</span>
                    <br>
                    <span class="user-role">{{Auth::user()->role->name}}</span>
                   </div>
                </div>
                <hr class="m-0">
                <a class="dropdown-item" href="{{route('dashboard.profile')}}"> <i class="me-2" data-feather="user"></i>حسابي</a>
                <hr class="m-0">
                <a class="dropdown-item logout pb-0" href="{{route('dashboard.logout')}}"><img src="{{asset('assets/img/icons/log-out.svg')}}" class="me-2" alt="img">تسجيل الخروج</a>
             </div>
          </div>
       </li>
    </ul>
    <div class="dropdown mobile-user-menu">
       <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{route('dashboard.profile')}}"> <i class="me-2" data-feather="user"></i>حسابي</a>
        <hr class="m-0">
        <a class="dropdown-item logout pb-0" href="{{route('dashboard.logout')}}"><img src="{{asset('assets/img/icons/log-out.svg')}}" class="me-2" alt="img">تسجيل الخروج</a>
       </div>
    </div>
 </div>
