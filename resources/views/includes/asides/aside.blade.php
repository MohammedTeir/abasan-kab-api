<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
       <div id="sidebar-menu" class="sidebar-menu">
          <ul>
             <li class="submenu-open">
                <h6 class="submenu-hdr">الرئيسية</h6>
                <ul>
                   <li class="active">
                      <a href="{{route('dashboard.home')}}"><i data-feather="grid"></i><span>لوحة التحكم</span></a>
                   </li>

                </ul>
             </li>

             @if (Auth::user()->role->name=="مدير النظام" || Auth::user()->role->name=="مدير محتوى" )

             <li class="submenu-open">
                <h6 class="submenu-hdr">نظام إدارة المحتوى</h6>
                <ul>
                    <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="file"></i><span>المستندات</span><span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="{{route('document-categories.index')}}">التصنيف</a></li>
                           <li><a href="{{route('documents.index')}}">المستندات</a></li>
                        </ul>
                     </li>


                     <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="feather"></i><span>الأخبار</span><span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="{{route('news.index')}}">الأخبار</a></li>
                           <li><a href="{{route('news.create')}}">إضافة خبر</a></li>
                        </ul>
                     </li>

                     <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="briefcase"></i><span>المشاريع</span><span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="{{route('project-categories.index')}}">التصنيف</a></li>
                           <li><a href="{{route('projects.index')}}">المشاريع</a></li>
                           <li><a href="{{route('projects.create')}}">إضافة مشروع</a></li>
                        </ul>
                     </li>

                     <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="radio"></i><span>الإعلانات</span><span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="{{route('ads.index')}}">الإعلانات</a></li>
                           <li><a href="{{route('ads.create')}}">إضافة إعلان</a></li>
                        </ul>
                     </li>

                     <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="trello"></i><span>لوحة التوظيف</span><span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="{{route('vacancies.index')}}">الوظائف</a></li>
                           <li><a href="{{route('vacancies.create')}}">إضافة وظيفة</a></li>
                        </ul>
                     </li>

                     <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="grid"></i><span>الوسائط</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="aperture"></i><span>البومات الصور</span><span class="menu-arrow"></span></a>
                                <ul>
                                   <li><a href="{{route('albums.index')}}">الالبومات</a></li>
                                   <li><a href="{{route('albums.create')}}">إضافة البوم</a></li>
                                </ul>
                             </li>
                             <li >
                                <a href="{{route('videos.index')}}"><i data-feather="youtube"></i><span>الفيديوهات</span></a>

                             </li>
                        </ul>
                     </li>

                     <li><a href="{{route('informations.index')}}"><i data-feather="pen-tool"></i><span>معلومات البلدية</span></a></li>



                </ul>
             </li>
             @endif

             @if (Auth::user()->role->name=="مدير النظام")
             <li class="submenu-open">
                <h6 class="submenu-hdr">إدارة المستخدمين</h6>
                <ul>
                   <li class="submenu">
                      <a href="javascript:void(0);"><i data-feather="users"></i><span>مستخدمين النظام</span><span class="menu-arrow"></span></a>
                      <ul>
                         <li><a href="{{route('admins.create')}}">مستخدم جديد</a></li>
                         <li><a href="{{route('admins.index')}}">قائمة المستخدمين</a></li>
                      </ul>
                   </li>

                   <li>
                    <a href="{{route('dashboard.usersList')}}"><i data-feather="users"></i><span>المواطنين</span></a>
                   </li>

                 <li >
                    <a href="{{route('roles.index')}}"><i data-feather="sliders"></i><span>الأدوار</span></a>
                 </li>

                 <li >
                    <a href="{{route('members.index')}}"><i data-feather="users"></i><span>أعضاء المجلس البلدي</span></a>
                 </li>

                </ul>
             </li>

             @endif


             @if (Auth::user()->role->name=="مدير النظام" || Auth::user()->role->name=="خدمات جمهور")




             <li class="submenu-open">
                <h6 class="submenu-hdr">إدارة الخدمات</h6>
                <ul>


                   <li class="submenu">
                      <a href="javascript:void(0);"><i data-feather="layers"></i><span>الخدمات</span><span class="menu-arrow"></span></a>
                      <ul>
                         <li><a href="{{route('service-categories.index')}}">التصنيف</a></li>
                         <li><a href="{{route('services.index')}}">الخدمات</a></li>
                      </ul>
                   </li>

                   <li>
                    <a href="{{route('service-requests.in-progress')}}"><i data-feather="clock"></i><span>قيد الطلب</span></a>
                   </li>

                   <li>
                    <a href="{{route('service-requests.accepted')}}"><i data-feather="check-circle"></i><span>تم الموافقة عليها</span></a>
                   </li>

                   <li>
                    <a href="{{route('service-requests.rejected')}}"><i data-feather="x-circle"></i><span>تم رفضها</span></a>
                   </li>

                </ul>


             </li>

             @endif

             @if (Auth::user()->role->name=="مدير النظام" || Auth::user()->role->name=="خدمات جمهور")

             <li class="submenu-open">
                <h6 class="submenu-hdr">إدارة الشكاوي</h6>
                <ul>
                   <li class="submenu">
                      <a href="javascript:void(0);"><i data-feather="layers"></i><span>الشكاوي</span><span class="menu-arrow"></span></a>
                      <ul>
                         <li><a href="{{route('complaints.index')}}">الشكاوي</a></li>
                      </ul>
                   </li>

                   <li>
                    <a href="{{route('departments.index')}}"><i data-feather="hexagon"></i><span>الدوائر</span></a>
                    </li>


                   <li>
                    <a href="{{route('complaints.open')}}"><i data-feather="clock"></i><span>شكاوي مفتوحة</span></a>
                   </li>

                   <li>
                    <a href="{{route('complaints.in-progress')}}"><i data-feather="check-circle"></i><span>شكاوي قيد المراجعة</span></a>
                   </li>

                   <li>
                    <a href="{{route('complaints.closed')}}"><i data-feather="x-circle"></i><span>شكاوي مغلقة</span></a>
                   </li>

                </ul>
             </li>

             @endif

             <li class="submenu-open">
                <h6 class="submenu-hdr">الإعدادات</h6>
                <ul>
                    <li>
                        <a href="{{route('dashboard.logout')}}"><i data-feather="log-out"></i><span>تسجيل الخروج</span> </a>
                     </li>

                </ul>
             </li>
          </ul>
       </div>
    </div>
 </div>
