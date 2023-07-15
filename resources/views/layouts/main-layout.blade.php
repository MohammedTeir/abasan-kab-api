<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <meta name="description" content="لوحة التحكم الادارية">
      <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
      <meta name="author" content="ATEAM - Abasan Admin Panel">
      <meta name="robots" content="noindex, nofollow">
      <title>@yield('title')</title>
      @include('includes.main.main-style')
   </head>
   <body>
      <div id="global-loader">
         <div class="whirly-loader"> </div>
      </div>
      <div class="main-wrapper">
         @include('includes.headers.header')
         @include('includes.asides.aside')
         <div class="page-wrapper">
            @yield('content')
         </div>
      </div>
     @include('includes.main.main-js')
   </body>
</html>
