@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Мои начисления
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')

                <div class="col-md-12">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="fa fa-money"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Всего к выплате</p>
                                            {{ $account->value }} <i class="fa fa-ruble"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    Без вычета НДФЛ (13%)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">История выплат</h4>
                        </div>
                        <div class="card-content table-responsive table-full-width">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Сумма</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($billings as $billing)
                                        <tr>
                                            <td>{{ $billing->accrued }}</td>
                                            <td>{{ $billing->created_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection