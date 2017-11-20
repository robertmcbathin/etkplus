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
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <div class="icon-big icon-success text-center">
                                                        <i class="fa fa-file-text"></i>
                                                    </div>
                                                </div>
                                                <div class="col-xs-7">
                                                    <div class="numbers">
                                                        <p>Cчет для оплаты в банке</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <hr>
                                            <div class="stats">
                                                Период зачисления на виртуальный счет - <b>до 3-х рабочих дней</b>
                                                <button class="btn btn-danger btn-xs btn-fill pull-right btn-square" data-toggle="modal" data-target="#add-invoice">Выписать счет</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <div class="icon-big icon-success text-center">
                                                        <i class="fa fa-credit-card"></i>
                                                    </div>
                                                </div>
                                                <div class="col-xs-7">
                                                    <div class="numbers">
                                                        <p>Оплата банковской картой</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <hr>
                                            <div class="stats">
                                                Период зачисления на виртуальный счет - <b>моментально</b> 
                                                <a class="btn btn-danger btn-xs btn-fill pull-right btn-square">Перейти к оплате</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Оплата услуг</h4>
                        </div>
                        <div class="card-content table-full-width">
                          @isset($billings)
                          @if (count($billings) > 0)
                          <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
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
                                    @if($billing->status == 3)
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
                        @else 
                        <h6>Операций по счету нет</h6>
                        @endif
                        @endisset
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@include('includes.dashboard.footer')
</div>
<div class="modal fade" id="add-invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="exampleModalLabel">Выписать счет</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <p>Будет выписан счет для абонента <b>{{ $partner->name }}</b> по договору <b>{{ $partner->contract_id }}</b>.</p>
                <p>Реквизиты предприятия:</p>
                <p class="text-primary">ИНН: <b class="pull-right">{{ $partner->inn }}</b></p>
                <p class="text-primary">КПП: <b class="pull-right">{{ $partner->kpp }}</b></p>
                <p class="text-primary">ОГРН: <b class="pull-right">{{ $partner->ogrn }}</b></p>
                <p class="text-primary">Юридический адрес: <b class="pull-right">{{ $partner->legal_address }}</b></p>
                <p class="text-primary">Физический адрес: <b class="pull-right">{{ $partner->physical_address }}</b></p>
                <p class="text-primary">Телефон: <b class="pull-right">{{ $partner->phone }}</b></p>
                <p class="text-primary">Email: <b class="pull-right">{{ $partner->email }}</b></p>
                <form action="{{ route('dashboard.partner.add-invoice.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <div class="form-group">
                        <label class="control-label">
                            Сумма
                        </label>
                        <input class="form-control" type="text" name="value" placeholder="1000" minlength="1" maxlength="5" required>
                        <small class="description">в рублях без НДС</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-fill btn-square btn-fw">Выписать счет</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>