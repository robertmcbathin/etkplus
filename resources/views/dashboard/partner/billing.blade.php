@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Оплата услуг
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                <div class="row">
                   <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Оплата услуг</h4>
                            <p class="muted">Вам доступны следующие способы оплаты услуг</p>
                        </div>
                        <div class="card-content">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-3">
                                <div class="card card-circle-chart" data-background-color="blue">
                                <div class="card-header text-center">
                                    <h5 class="card-title"><i class="fa fa-file-text"></i> Счет</h5>
                                    <p class="description">Выписать счет для оплаты в банке</p>
                                    <p class="description">Период зачисления на виртуальный счет - <b>до 3-х рабочих дней</b></p>
                                </div>
                                <div class="card-content">
                                    <button class="btn btn-lg btn-fill btn-danger">Выписать счет</button>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-circle-chart" data-background-color="green">
                                <div class="card-header text-center">
                                    <h5 class="card-title"><i class="fa fa-credit-card"></i> Оплата банковской картой</h5>
                                    <p class="description">Оплата через интернет</p>
                                    <p class="description">Период зачисления на виртуальный счет - <b>моментально</b></p>
                                </div>
                                <div class="card-content">
                                    <button class="btn btn-lg btn-fill btn-danger" disabled>Перейти к оплате</button>
                                </div>
                            </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
