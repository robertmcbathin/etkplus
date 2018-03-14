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

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <div class="icon-big icon-danger text-center">
                                                <i class="fa fa-money"></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>Остаток по счету</p>
                                                {{ $to_pay }} <i class="fa fa-ruble"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr />
                                    <div class="stats">
                                         
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <div class="icon-big icon-danger text-center">
                                                <i class="fa fa-building"></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>Мои предприятия</p>
                                                {{ $partners_count }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr />
                                    <div class="stats">
                                         
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection