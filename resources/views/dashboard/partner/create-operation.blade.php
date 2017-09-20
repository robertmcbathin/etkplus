@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $partner->name }}
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Активные скидки</p>
                                            <p class="form-control-static"></p>
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
                                <h4 class="card-title">
                                    Введите номер карты
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="form-group" id="co-search-status">
                                    <input id="co-card-input-number" type="text" value="023333092" placeholder="023000000" class="form-control" maxlength="9" minlength="9">
                                </div>
                                <button class="btn btn-fill btn-info" id="co-find-card">Найти</button>
                            </div>
                        </div> <!-- end card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Информация по карте <i id="co-card-info-loader"></i>
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-md-3">
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
                                                        <p>Номер</p>
                                                        <p class="form-control-static" id="co-card-number"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <div class="icon-big icon-success text-center">
                                                        <i class="fa fa-gift"></i>
                                                    </div>
                                                </div>
                                                <div class="col-xs-7">
                                                    <div class="numbers">
                                                        <p>Количество бонусов</p>
                                                        <p class="form-control-static" id="co-bonuses"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-3">
                                   <div class="card">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <div class="icon-big icon-success text-center">
                                                    <i class="fa fa-handshake-o"></i>
                                                </div>
                                            </div>
                                            <div class="col-xs-7">
                                                <div class="numbers">
                                                    <p>Всего операций</p>
                                                    <p class="form-control-static" id="co-operations-count"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-3">
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
                                                    <p>Сумма операций</p>
                                                    <p class="form-control-static" id="co-operations-summary"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div>
            </div>
            <div class="col-md-12">

            </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>

<script>
  var token = '{{ Session::token() }}';
  var checkCardUrl = '{{ route('ajax.check_card_and_operations.post') }}';
  var partnerId = '{{ $partner->id }}';
</script>