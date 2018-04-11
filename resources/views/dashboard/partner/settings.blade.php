@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Настройки
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                <h4 class="card-title">Настройки</h4>
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-content">
                            <form action="{{ route('dashboard.partner.save-settings.post') }}" method="POST">
                            <div class="row">
                                <div class="col-xs-10">
                                    <p>Фиксированная скидка</p>
                                    <p class="text-muted">Если задать параметр скидки как фиксированный, то при проведении операций нельзя будет изменить размер скидки. Оставьте это поле пустым, если хотите редактировать скидку при проведении операции</p>
                                </div>
                                <div class="col-xs-2">

                                    <div class="form-group">
                                            <label>Размер скидки</label>
                                            <input type="text" placeholder="Размер скидки в процентах" minlength="1" maxlength="4" class="form-control" name="fixed_discount" value="{{ $default_discount }}">
                                        </div>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-10">
                                    <p>Фиксированный бонус</p>
                                    <p class="text-muted">Если задать параметр бонуса как фиксированный, то при проведении операций бонусы будут начисляться автоматически в зависимости от размера чека. Оставьте это поле пустым, если хотите редактировать размер бонуса при проведении операции</p>
                                </div>
                                <div class="col-xs-2">

                                    <div class="form-group">
                                            <label>Размер бонуса</label>
                                            <input type="text" placeholder="Размер бонуса в процентах" minlength="1" maxlength="4" class="form-control" name="fixed_bonus" value="{{  $default_bonus}}">
                                        </div>
                                </div>
                                
                            </div>
                            <hr>
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger btn-fill btn-wd btn-square" value="Сохранить изменения">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection
