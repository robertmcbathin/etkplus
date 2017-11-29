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
                                            <p>Объем на счетах</p>
                                            {{ $accounts_sum }}
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
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Остаточные средства на счетах</h4>
                        </div>
                        <div class="card-content table-responsive table-full-width">
                            <table class="table table-hover">
                                <thead>
                                    <tr><th>ID</th>
                                        <th>Название</th>
                                        <th>Остаток</th>
                                    </tr></thead>
                                    <tbody>
                                        @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{ $account->id }}</td>
                                            <td>{{ $account->name }}</td>
                                            <td>{{ $account->value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-plain">
                            <div class="card-header">
                                <h4 class="card-title">Выставленные счета</h4>
                            </div>
                            <div class="card-content table-responsive table-full-width">
                               @if (count($billings) > 0)
                               <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Название</th>
                                        <th>Сумма</th>
                                        <th class="text-right">Тип</th>
                                        <th class="text-right">Статус</th>
                                        <th class="text-right">Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($billings as $billing)
                                    <tr>
                                        <td class="text-center">{{ $billing->id }}</td>
                                        <td>{{ $billing->name }}</td>
                                        <td>{{ $billing->value }}</td>
                                        @if($billing->type == 0)
                                        <td class="text-right">При создании</td>
                                        @endif
                                        @if($billing->type == 1)
                                        <td class="text-right">Банковский перевод</td>
                                        @endif
                                        @if($billing->type == 2)
                                        <td class="text-right">Интернет-эквайринг</td>
                                        @endif
                                        @if($billing->type == 3)
                                        <td class="text-right">Другой способ</td>
                                        @endif
                                        @if($billing->status == 0)
                                        <td class="text-right">Создан</td>
                                        @endif
                                        @if($billing->status == 1)
                                        <td class="text-right">Подтвержден</td>
                                        @endif
                                        @if($billing->status == 2)
                                        <td class="text-right">Проведен</td>
                                        @endif
                                        <td class="text-right">{{ $billing->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <?php echo $billings->render(); ?>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection