@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Создание предприятия
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
                                <h4 class="card-title">Мастер создания и настройки предприятия</h4>
                                <p class="category">Здесь можно было добавить некоторую полезную информацию, но ее нет</p>
                            </div>
                            <div class="card-content">
                                <ul class="nav nav-pills">
                                    <li class="active" style="width: 33.3333%;"><a href="#tab1" data-toggle="tab" aria-expanded="true">Общая информация</a></li>
                                    <li style="width: 33.3333%;"><a href="#tab2" data-toggle="tab">Медиа</a></li>
                                    <li style="width: 33.3333%;"><a href="#tab3" data-toggle="tab">Завершение</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <h5 class="text-center">Основные данные предприятия</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Краткое наименование
                                                    </label>
                                                    <input class="form-control" type="text" name="name" placeholder="пример: ООО Рога и копыта" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Полное наименование
                                                    </label>
                                                    <input class="form-control" type="text" name="fullname" required="true" placeholder="" aria-required="true" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Описание</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" name="description" placeholder="Основная информация об организации" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Контактные данные предприятия</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Основной номер телефона
                                                    </label>
                                                    <input class="form-control" type="text" name="phone" placeholder="пример: +79008007060" aria-required="true" aria-invalid="true" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Основной адрес
                                                    </label>
                                                    <input class="form-control" type="text" name="address" placeholder="пример: г.Чебоксары, ул. Мошенников, д.1, офис 15" aria-required="true" aria-invalid="true" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Email
                                                    </label>
                                                    <input class="form-control" type="email" name="email" email="true" placeholder="пример: info@mail.ru" aria-required="true" aria-invalid="true" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Сайт
                                                    </label>
                                                    <input class="form-control" type="text" name="site" placeholder="http://example.com" value="http://">
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Данные для подключения к системе</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Комиссия (%)
                                                    </label>
                                                    <input class="form-control" type="text" name="comission" placeholder="" value ="10">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Номер договора
                                                    </label>
                                                    <input class="form-control" type="text" name="contract_id" placeholder="17001" value ="">
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Данные по счету</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Начальный баланс
                                                    </label>
                                                    <input class="form-control" type="text" name="account_value" placeholder="" value ="2500" maxlength="5" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Минимальный баланс
                                                    </label>
                                                    <input class="form-control" type="text" name="account_min_value" placeholder="0" value ="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Юридические данные</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Юридический адрес
                                                    </label>
                                                    <input class="form-control" type="text" name="legal_address" placeholder="428000, город Чебоксары, ..." value ="">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Физический адрес
                                                    </label>
                                                    <input class="form-control" type="text" name="physical_address" placeholder="428000, город Чебоксары, ..." value ="">
                                                </div>
                                            </div>  
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        ИНН
                                                    </label>
                                                    <input class="form-control" type="text" name="inn" placeholder="" value ="" minlength="10" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        КПП
                                                    </label>
                                                    <input class="form-control" type="text" name="kpp" placeholder="" value ="" minlength="9" maxlength="9">
                                                </div>
                                            </div>  
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        ОГРН
                                                    </label>
                                                    <input class="form-control" type="text" name="ogrn" placeholder="" value ="" minlength="1" maxlength="20">
                                                </div>
                                            </div>  
                                        </div>
                                        </div>
                                        <h5 class="text-center">Категория</h5>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98">
                                                        <option class="bs-title-option" value="">Выберите категорию</option>
                                                        @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
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
                                    <button type="button" class="btn btn-default btn-fill btn-wd btn-back pull-left disabled" style="display: none;">Назад</button>
                                    <button type="button" class="btn btn-info btn-fill btn-wd btn-next pull-right">Далее</button>
                                    <button type="submit" class="btn btn-info btn-fill btn-wd btn-finish pull-right" onclick="onFinishWizard()">Готово</button>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('includes.dashboard.footer')
        </div>
    </div>


    @endsection