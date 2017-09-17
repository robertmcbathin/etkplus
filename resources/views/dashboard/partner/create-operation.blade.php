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
                @include('includes/notifications');
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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Информация по карте <i id="co-card-info-loader"></i>
                                </h4>
                            </div>
                            <div class="card-content">

                                        <div class="form-group">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-8 control-label">Номер</label>
                                                    <div class="col-sm-10">
                                                        <p class="form-control-static" id="co-card-number"></p>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-8 control-label">Бонусы по карте</label>
                                                    <div class="col-sm-10">
                                                        <p class="form-control-static" id="co-bonuses"></p>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="form-group">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-8 control-label">Всего операций</label>
                                                    <div class="col-sm-10">
                                                        <p class="form-control-static" id="co-operations-count"></p>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-8 control-label">На сумму</label>
                                                    <div class="col-sm-10">
                                                        <p class="form-control-static" id="co-operations-summary"></p>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                            </div> <!-- end card -->
                        </div>
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