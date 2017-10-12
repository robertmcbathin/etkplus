@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Операции
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


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Операции</h4>
                        </div>
                        <div class="card-content table-full-width">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Предприятие</th>
                                        <th>Номер карты</th>
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
                                        <td><a href="{{ route('dashboard.partner-page.get', ['partner_id' => $visit->partner_id]) }}">{{ $visit->partner_name }}</a></td>
                                        <td><a href="">{{ $visit->card_number }}</a></td>
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
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection
