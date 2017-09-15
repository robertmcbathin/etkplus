@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Операции по предприятию
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications');
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
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
                                        <i class="fa fa-ruble"></i> обещанный платеж: {{ $balance->min_value }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-lg-3 col-sm-6">
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
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Операции по предприятию</h4>
                        </div>
                        <div class="card-content table-full-width">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Клиент</th>
                                        <th class="text-right">Счет</th>
                                        <th class="text-right">Скидка</th>
                                        <th class="text-right">Бонус</th>
                                        <th class="text-right">Кэшбэк</th>
                                        <th class="text-right">Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visits as $visit)
                                    <tr>
                                        <td class="text-center">{{ $visit->id }}</td>
                                        <td>{{ $visit->user_name }}</td>
                                        <td class="text-right">{{ $visit->bill }}</td>
                                        <td class="text-right">{{ $visit->discount }}</td>
                                        <td class="text-right">{{ $visit->bonus }}</td>
                                        <td class="text-right">{{ $visit->cashback }}</td>
                                        <td class="text-right">{{ $visit->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <?php echo $visits->render(); ?>
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
