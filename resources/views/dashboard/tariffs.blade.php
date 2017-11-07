@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Тарифы
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
                    <a class="btn btn-danger btn-fill btn-wd" data-toggle="modal" data-target="#add-tariff" >Добавить тариф</a>
                </div>

            </div>
            <br>
            <div class="col-md-12">
                <div class="card" id="partner-list-results">
                    <div class="card-header">
                        <h4 class="card-title">Тарифы</h4>
                    </div>
                    <div class="card-content table-full-width">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Число операторов</th>
                                    <th>Количество точек</th>
                                    <th>Комиссия</th>
                                    <th>Абонентская плата</th>
                                    <th>Кем создано</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tariffs as $tariff)
                                <tr>
                                    <td class="text-center">{{ $tariff->id }}</td>
                                    <td>{{ $tariff->name }}</td>
                                    <td>{{ $tariff->description }}</td>
                                    <td>{{ $tariff->max_operator_count }}</td>
                                    <td>{{ $tariff->max_service_points }}</td>
                                    <td>{{ $tariff->comission }}</td>
                                    <td>{{ $tariff->monthly_payment }}</td>
                                    <td>{{ $tariff->created_by }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection
<div class="modal fade" id="add-tariff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить Тариф</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.add-tariff.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="Старт" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="Тариф с комиссией за операцию без абонентской платы" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Количество операторов 
                        </label>
                        <input class="form-control" type="text" name="max_operator_count" placeholder="2" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Количество торгово-сервисных точек
                        </label>
                        <input class="form-control" type="text" name="max_service_points" placeholder="1" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Комиссия (в %, не менее 2)
                        </label>
                        <input class="form-control" type="text" name="comission" placeholder="8" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Абонентская плата (в месяц)
                        </label>
                        <input class="form-control" type="text" name="monthly_payment" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>