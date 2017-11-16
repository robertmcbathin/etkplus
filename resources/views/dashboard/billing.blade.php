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

                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="fa fa-file"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Неоплаченных счетов</p>
                                            {{ $bills_count }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    На сумму: {{ $bills_sum }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Оплата услуг</h4>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="left-vertical-tabs">
                                    <ul class="nav nav-stacked" role="tablist">
                                        <li class="active">
                                            <a href="#to-pay" role="tab" data-toggle="tab" aria-expanded="false">
                                               Зачисление
                                           </a>
                                       </li>
                                       <li class="">
                                        <a href="#history" role="tab" data-toggle="tab" aria-expanded="true">
                                           Архив
                                       </a>
                                   </li>
                               </ul>
                           </div>
                           <div class="right-text-tabs">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="to-pay">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Новые счета</h4>
                                        </div>
                                        <div class="card-content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr><th>ID</th>
                                                        <th>Наименование партнера</th>
                                                        <th>№ счета</th>
                                                        <th>Сумма</th>
                                                        <th>Статус</th>
                                                        <th>Дата создания</th>
                                                        <th></th>
                                                    </tr></thead>
                                                    <tbody>
                                                        @foreach ($payments as $payment)
                                                        <tr>
                                                            <td>{{ $payment->id }}</td>
                                                            <td>{{ $payment->name }}</td>
                                                            <td>{{ $payment->bill_number }}</td>
                                                            <td>{{ $payment->value }}</td>
                                                            @if ($payment->status == 0)
                                                            <td>Счет выписан</td>
                                                            @elseif ($payment->status == 1)
                                                            <td>Счет оплачен</td>
                                                            @endif
                                                            <td>{{ $payment->created_at }}</td>
                                                            <td><button class="btn btn-danger btn-square btn-fill" data-toggle="modal" data-target="#increase-account-{{ $payment->partner_id }}">Зачислить</button></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <?php echo $payments->render(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="history">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Архивные счета</h4>
                                        </div>
                                        <div class="card-content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr><th>ID</th>
                                                        <th>Наименование партнера</th>
                                                        <th>№ счета</th>
                                                        <th>Сумма</th>
                                                        <th>Статус</th>
                                                        <th>Дата создания</th>
                                                    </tr></thead>
                                                    <tbody>
                                                        @foreach ($archive_payments as $archive_payment)
                                                        <tr>
                                                            <td>{{ $archive_payment->id }}</td>
                                                            <td>{{ $archive_payment->name }}</td>
                                                            <td>{{ $archive_payment->bill_number }}</td>
                                                            <td>{{ $archive_payment->value }}</td>
                                                            @if ($archive_payment->status == 0)
                                                            <td>Счет выписан</td>
                                                            @elseif ($archive_payment->status == 2)
                                                            <td>Зачислено</td>
                                                            @endif
                                                            <td>{{ $archive_payment->created_at }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <?php echo $payments->render(); ?>
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
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection
@foreach ($payments as $payment)
<div class="modal fade" id="increase-account-{{ $payment->partner_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Зачислить</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('dashboard.increase-account.post') }}" method="POST">
                <div class="modal-body"> 
                  <div class="form-group">
                      <label class="control-label">
                          Сумма, которая будет зачислена
                      </label>
                      {{ csrf_field() }}
                      <input type="hidden" value="{{ $payment->id }}" name="bill_id">
                      <input type="hidden" value="{{ $payment->partner_id }}" name="partner_id">
                      <input class="form-control" type="text" name="to_increase" value="{{ $payment->value }}" required>
                  </div>
              </div>
              <div class="modal-footer">
                <div class="left-side">
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link btn-square btn-fill">Зачислить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endforeach