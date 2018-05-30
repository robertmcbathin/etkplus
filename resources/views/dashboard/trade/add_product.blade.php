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
                                                    <input class="form-control" type="text" value="sdsd" name="name" placeholder="Батончик шоколадный молочный" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Полное наименование
                                                    </label>
                                                    <input class="form-control" type="text" value="sdsd" name="fullname" required="true" placeholder="Батончик шоколадный молочный большой" aria-required="true">
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
                                        <h5 class="text-center">Категория и атрибуты</h5>
                                        <div class="row">
                                             <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Категория (выбрать уровень 3)
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <div class="form-group">
                                                                <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98" id="ap-category">
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

                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Категория (выбрать уровень 3)
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <div class="form-group">
                                                                <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98" id="ap-category">
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
                                        <h5 class="text-center">Цены</h5>
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-1">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Цена продажи
                                                    </label>
                                                    <input class="form-control" type="text" id="" name="price" placeholder="599" value="500" minlength="1" maxlength="10" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Цена без скидки (указывается, если товар по акции)
                                                    </label>
                                                    <input class="form-control" type="text" id="" name="price_without_discount" placeholder="689" value="" minlength="1" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Цена закупки (Если это товар от внешнего интернет-магазина или свой собственный)
                                                    </label>
                                                    <input class="form-control" type="text" name="price_cost" placeholder="450" value ="" minlength="1" maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Продавец</h5>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="shop" title="Выберите магазин" data-size="7" tabindex="-98">
                                                        <option class="bs-title-option" value="">Выберите магазин</option>
                                                        @foreach($shops as $shop)
                                                        <option class="bs-title-option" value="{{ $shop->id }}">{{ $shop->name }} ({{ $shop->type_name }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center">Специальное предложение</h5>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <p class="category">Отметить товар как специальный</p>
                                                <input type="checkbox" class="switch-plain" name="is_spec">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <h5 class="text-center">Прикрепите изображения</h5>
                                        <div class="row">
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                                  <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                                                    <img src="/assets/img/image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                                                <div>
                                                    <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать основное изображение</span><span class="fileinput-exists">Изменить</span>
                                                    <input type="file" name="primary_image">
                                                </span>
                                                <a href="#paper-kit" class="btn btn-link btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                          <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                                            <img src="/assets/img/image_placeholder.jpg" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                                        <div>
                                            <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать второстепенные изображения</span><span class="fileinput-exists">Изменить</span>
                                            <input type="file" name="secondary_images[]" multiple>
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
                <button type="submit" class="btn btn-info btn-fill btn-finish btn-fw btn-square pull-right" onclick="onFinishWizard()">Готово</button>
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
