@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $operator->name }} {{ $operator->lastname }}
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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <h6>оператор</h6>
                                            {{ $operator->name }} {{ $operator->lastname }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <h6>операций проведено</h6>
                                            {{ $visit_count }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    На сумму: {{ $visit_summary }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        @isset($operations)
                        <div class="row">
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
                                                    <th>Карта</th>
                                                    <th class="text-right">Счет</th>
                                                    <th class="text-right">Скидка</th>
                                                    <th class="text-right">Бонус</th>
                                                    <th class="text-right">Кэшбэк</th>
                                                    <th class="text-right">Дата</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($operations as $operation)
                                                <tr>
                                                    <td class="text-center">{{$operation->id }}</td>
                                                    <td><a href="{{ route('dashboard.partner.show-card.get', ['card_number' => $operation->card_number]) }}">{{ $operation->card_number }}</a></td>
                                                    <td class="text-right">{{ $operation->bill }}</td>
                                                    <td class="text-right">{{ $operation->discount }}</td>
                                                    <td class="text-right">{{ $operation->bonus }}</td>
                                                    <td class="text-right">{{ $operation->cashback }}</td>
                                                    <td class="text-right">{{ $operation->created_at }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <?php echo $operations->render(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
