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
                <div class="row" id="co-card-search">
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
                                <button class="btn btn-fill btn-danger btn-square btn-fw away-link" id="co-find-card">Найти</button>
                            </div>
                        </div> <!-- end card -->
                    </div>
                </div>
                <div class="row" id="co-card-search-result">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Данные по операции
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-md-6">
                                      <div class="card">
                                        <div class="card-content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="numbers">
                                                        <p>Информация по карте</p>
                                                        <h6 class="card-category" id="co-card-number"></h6>
                                                        <h6 class="card-category" id="co-bonuses"></h6>
                                                        <h6 class="card-category" id="co-operations-count"></h6>
                                                        <h6 class="card-category" id="co-operations-summary"></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="numbers">
                                                            <p>Активные скидки</p>
                                                            @foreach ($discounts as $discount)
                                                            <h6 class="card-category"><span class="upper-text">{{ $discount->value }}%</span>   {{ $discount->description }}</h6>
                                                            @endforeach
                                                            <p class="form-control-static"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="numbers">
                                                            <p>Активные бонусы</p>
                                                            @foreach ($bonuses as $bonus)
                                                            <h6 class="card-category"><span class="upper-text">{{ $bonus->value }}@if ($bonus->type == 1) руб. @elseif ($bonus->type == 2) % @endif </span>   {{ $bonus->description }}</h6>
                                                            @endforeach
                                                            <p class="form-control-static"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-md-offset-5">
                                    <i id="co-create-operation-loader"></i>
                                </div>
                                <div class="col-md-12" id="co-create-operation-form"">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                Создание операции
                                            </h4>
                                        </div>
                                        <div class="card-content">
                                            <form method="POST" action="{{ route('dashboard.partner.create-operation.post') }}">
                                             <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                                             <input type="hidden" name="operator_id"  value="{{ Auth::user()->id }}">
                                             <input type="hidden" name="card_number" id="co-card-number-input" value="">
                                             {{ csrf_field() }}
                                             <fieldset>
                                                 <div class="form-group">
                                                     <label class="col-sm-2 control-label">Счет</label>
                                                     <div class="col-sm-10">
                                                         <input type="text" id="co-form-bill" name="bill" class="form-control co-form-summary" minlength="1" placeholder="1000">

                                                         <span class="help-block">в рублях</span>
                                                     </div>
                                                 </div>
                                             </fieldset>
                                            <fieldset>
                                                 <div class="form-group">
                                                     <label class="col-sm-2 control-label">Скидка</label>
                                                     <div class="col-sm-10">
                                                         <input type="text" id="co-form-discount" name="discount" class="form-control co-form-summary" minlength="1" placeholder="10">

                                                         <span class="help-block">в процентах (%)</span>
                                                     </div>
                                                 </div>
                                             </fieldset>
                                            <fieldset>
                                                 <div class="form-group">
                                                     <label class="col-sm-2 control-label">Начислить бонусы</label>
                                                     <div class="col-sm-10">
                                                         <input type="text" name="bonus" class="form-control" minlength="1" placeholder="50" value="0">

                                                         <span class="help-block">в рублях</span>
                                                     </div>
                                                 </div>
                                             </fieldset>
                                            <fieldset>
                                                 <div class="form-group">
                                                     <label class="col-sm-2 control-label">Списать бонусы</label>
                                                     <div class="col-sm-10">
                                                         <input type="text" id="co-form-bonuses" name="sub_bonus" class="form-control co-form-summary" minlength="1" placeholder="50" value="0">

                                                         <span class="help-block">Не более <b id="co-max-bonuses"></b></span>
                                                     </div>
                                                 </div>
                                             </fieldset>
                                            <fieldset>
                                                 <div class="form-group">
                                                     <label class="col-sm-2 control-label">Итоговый счет</label>
                                                     <div class="col-sm-10">

                                                         <b id="co-bill-with-discount"></b>
                                                     </div>
                                                 </div>
                                             </fieldset>
                                             <button type="submit" class="btn btn-fill btn-danger btn-square btn-fw away-link">Подтвердить</button>
                                         </form>  
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