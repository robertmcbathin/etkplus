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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-tariff" >Добавить тариф</a>
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
                                    <td>
                                        <a href="#" rel="tooltip" title="" class="btn btn-success btn-simple btn-xs" data-original-title="Редактировать" data-toggle="modal" data-target="#edit-tariff-{{ $tariff->id }}">
                                        <i class="fa fa-edit"></i>
                                        </a>
                                        
                                    </td>
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

                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-fw btn-square btn-fill">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($tariffs as $tariff)
<div class="modal fade" id="edit-tariff-{{ $tariff->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить тариф</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('dashboard.edit-tariff.post') }}" method="POST">
                <div class="modal-body"> 
                  {{ csrf_field() }}
                  <input type="hidden" value="{{ $tariff->id }}" name="tariff_id">
                  <div class="form-group">
                      <label class="control-label">
                          Название
                      </label>
                      <input class="form-control" type="text" name="name" value="{{ $tariff->name }}" required>
                  </div>
                  <div class="form-group">
                      <label class="control-label">
                          Описание
                      </label>
                      <input class="form-control" type="text" name="description" value="{{ $tariff->description }}" required>
                  </div>
                  <div class="form-group">
                      <label class="control-label">
                          Макс. число операторов
                      </label>
                      <input class="form-control" type="text" name="max_operator_count" value="{{ $tariff->max_operator_count }}" required>
                  </div>
                  <div class="form-group">
                      <label class="control-label">
                          Макс. количество точек
                      </label>
                      <input class="form-control" type="text" name="max_service_points" value="{{ $tariff->max_service_points }}" required>
                  </div>
                  <div class="form-group">
                      <label class="control-label">
                          Комиссия
                      </label>
                      <input class="form-control" type="text" name="comission" value="{{ $tariff->comission }}" required>
                  </div>
                  <div class="form-group">
                      <label class="control-label">
                          Абонентская плата
                      </label>
                      <input class="form-control" type="text" name="monthly_payment" value="{{ $tariff->monthly_payment }}" required>
                  </div>
              </div>
              <div class="modal-footer">
                <div class="left-side">
                    <div class="right-side">
                        <button type="submit" class="btn btn-info btn-link btn-fill btn-square btn-fw">Сохранить изменения</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endforeach
<script>

</script>