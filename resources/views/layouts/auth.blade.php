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
      @include('includes.auth.auth-style')
   </head>


      @yield('content')

   @include('includes.auth.auth-js')

</html>
