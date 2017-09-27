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
            <a href="/" class="simple-text logo-mini">
                ЕТК+
            </a>

            <a href="/" class="simple-text logo-normal">
                ЕТКплюс
            </a>
        </div>
        @include('includes.dashboard.sidebar')
    </div>

    <div class="main-panel">
        @include('includes.dashboard.top_nav')

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="card info-block">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="fa fa-money"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Счет</p>
                                            {{ $balance->value }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-ruble"></i> минимальный остаток: {{ $balance->min_value }} <a class="btn btn-danger btn-xs btn-fill pull-right">Пополнить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card info-block">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="fa fa-refresh"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Выручка</p>
                                            {{ $earnings }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-calendar"></i> За все время
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card info-block">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Рейтинг</p>
                                            {{ $partner->rating }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <a href="{{ route('dashboard.partner.show-reviews.get') }}" class="btn btn-danger btn-xs btn-fill pull-right">Смотреть отзывы</a>
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