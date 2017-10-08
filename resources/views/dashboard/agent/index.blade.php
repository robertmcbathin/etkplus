@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Панель управления
@endsection
@section('content')
<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="info">
        <div class="logo">
        </div>
        @include('includes.dashboard.sidebar')
    </div>

    <div class="main-panel">
        @include('includes.dashboard.top_nav')

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection