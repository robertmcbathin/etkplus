@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Товары
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                <div class="col-md-10 col-md-offset-1">
                    <div class="card card-wizard" id="wizardCard">
                        <form id="wizardForm" method="POST" action="{{ route('dashboard.create-partner.post') }}" novalidate="novalidate" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="card-header text-center">
                                <h4 class="card-title">Мастер создания товара</h4>
                                <p class="category">Здесь можно было добавить некоторую полезную информацию, но ее нет</p>
                            </div>
                            <div class="card-content">
                                <ul class="nav nav-pills">
                                    <li class="active" style="width: 33.3333%;"><a href="#tab1" data-toggle="tab" aria-expanded="true">Общие данные</a></li>
                                    <li style="width: 33.3333%;"><a href="#tab2" data-toggle="tab">Изображения</a></li>
                                    <li style="width: 33.3333%;"><a href="#tab3" data-toggle="tab">Наличие и способы доставки</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <h5 class="text-center">Основные данные </h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Краткое наименование
                                                    </label>
                                                    <input class="form-control" type="text" name="name" placeholder="Батончик шоколадный молочный" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Полное наименование
                                                    </label>
                                                    <input class="form-control" type="text" name="fullname" required="true" placeholder="Батончик шоколадный молочный большой" aria-required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Описание</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" name="description" placeholder="Этот батончик невероятно полезный. Об этом говорят результаты последних исследований..." rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Категория</h5>
                                        <div class="row">
                                             <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Категория (выбрать уровень 3)
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <div class="form-group">
                                                                <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98">
                                                                    <option class="bs-title-option" value="">Выберите категорию</option>
                                                                    @foreach($categories as $category)
                                                                        @if($category->level == 1)
                                                                        <option class="bs-title-option" value="{{ $category->id }}">{{$category->level}} | {{$category->id}} | {{ $category->title }}</option>
                                                                        @endif
                                                                        @if($category->level == 2)
                                                                        <option class="bs-title-option" value="{{ $category->id }}">___{{$category->level}} | {{$category->id}} | {{ $category->title }}</option>
                                                                        @endif
                                                                        @if($category->level == 3)
                                                                        <option class="bs-title-option" value="{{ $category->id }}">______{{$category->level}} | {{$category->id}} | {{ $category->title }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                           
                                        </div>
                                        <h5 class="text-center">Данные для подключения к системе</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Тариф
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <div class="form-group">
                                                                <select class="form-control" name="tariff" title="Выберите тариф" data-size="7" tabindex="-98">
                                                                    <option class="bs-title-option" value="">Выберите тариф</option>
                                                                    @foreach($categories as $category)
                                                                        @if($category->level == 1)
                                                                        <option class="bs-title-option" value="{{ $category->id }}">{{ $category->title }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Номер договора
                                                    </label>
                                                    <input class="form-control" type="text" id="cp-contract-id" name="contract_id" placeholder="YYNNN" value="" minlength="5" maxlength="5">
                                                </div>
                                            </div>
                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        ФИО администратора
                                                    </label>
                                                    <input class="form-control" type="text" name="admin_name" placeholder="Петров Петр Петрович" value ="">
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Контрагент</h5>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="company_id" title="Выберите категорию" data-size="7" tabindex="-98" required>
                                                        <option class="bs-title-option" value="">Выберите контрагента</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Категория</h5>
                                        <p class="muted-text text-center">в системе лояльности</p>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98">
                                                        <option class="bs-title-option" value="">Выберите категорию</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Магазин</h5>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <p class="category">Включить функционал магазина</p>
                                                <input type="checkbox" class="switch-plain" name="is_shop">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <h5 class="text-center">Прикрепите медиафайлы</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                                  <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                                                    <img src="../assets/img/image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                                                <div>
                                                    <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать фон (1307 на 392)</span><span class="fileinput-exists">Изменить</span>
                                                    <input type="file" name="background_image">
                                                </span>
                                                <a href="#paper-kit" class="btn btn-link btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                          <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                                            <img src="../assets/img/image_placeholder.jpg" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                                        <div>
                                            <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать логотип (150 на 150)</span><span class="fileinput-exists">Изменить</span>
                                            <input type="file" name="logo_image">
                                        </span>
                                        <a href="#paper-kit" class="btn btn-link btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <p class="category">Активировать учетную запись</p>
                                <input type="checkbox" class="switch-plain" name="is_active">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-default btn-fill btn-wd btn-back pull-left btn-square disabled" style="display: none;">Назад</button>
                <button type="button" class="btn btn-info btn-fill btn-wd btn-next btn-square pull-right">Далее</button>
                <button type="submit" class="btn btn-info btn-fill btn-wd btn-finish btn-fw btn-square pull-right" onclick="onFinishWizard()">Готово</button>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>
            <br>
            <div class="col-md-12">
            
            </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection
