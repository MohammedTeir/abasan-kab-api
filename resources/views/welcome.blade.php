@extends('layouts.main-layout')

@section('title',' لوحة التحكم بلدية عبسان الكبيرة')

@section('css-ext')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .content-image {
        min-height: 100%;
    }
</style>
@endsection

@section('content')
<div class="content-image">
    <img src="{{asset('assets/img/logo.svg')}}" alt="MAIN">
</div>
@endsection

