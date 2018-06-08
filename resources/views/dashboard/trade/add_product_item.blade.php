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
                        <form id="wizardForm" method="POST" action="{{ route('dashboard.shop.add-product.post') }}" novalidate="novalidate" enctype="multipart/form-data">
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
                                                            <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98" id="ap-category" required>
                                                                <option class="bs-title-option" value="">Выберите категорию</option>
                                                                @foreach($categories as $category)
                                                                @if($category->level == 1)
                                                                <option class="bs-title-option" value="{{ $category->id }}">{{$category->level}} | {{$category->id}} | {{ $category->title }}</option>
                                                                @endif
                                                                @if($category->level == 2)
                                                                <option class="bs-title-option" value="{{ $category->id }}">---{{$category->level}} | {{$category->id}} | {{ $category->title }}</option>
                                                                @endif
                                                                @if($category->level == 3)
                                                                <option class="bs-title-option" value="{{ $category->id }}">------{{$category->level}} | {{$category->id}} | {{ $category->title }}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <span><b> Внимание! </b> Не забудьте добавить товару атрибуты после создания</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>          

                                    </div>
                                    <h5 class="text-center">Бренд</h5>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="form-group">
                                                <select class="form-control" name="brand" title="Выберите бренд" data-size="7" tabindex="-98">
                                                    <option class="bs-title-option" value="0">Выберите бренд</option>
                                                    @foreach($brands as $brand)
                                                    <option class="bs-title-option" value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="text-center">Цены</h5>
                                    <div class="row">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    Цена продажи
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" id="" name="price" placeholder="599" minlength="1" maxlength="10" required>    
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    Цена без скидки (указывается, если товар по акции)
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" id="" name="price_without_discount" placeholder="689" value="" minlength="1" maxlength="10">
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    Цена закупки (Если это товар от внешнего интернет-магазина или свой собственный)
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="price_cost" placeholder="450" value ="" minlength="1" maxlength="10">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <h5 class="text-center">Прикрепите изображения</h5>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="text-center" data-provides="fileinput">
                                                <h6>Выберите основное изображение</h6>
                                                <div>
                                                    <input type="file" name="primary_image">
                                                    <a href="#paper-kit" class="btn btn-fill btn-danger btn-square fileinput-exists pull-right" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="text-center" data-provides="fileinput">
                                                <h6>Выберите второстепенные изображения</h6>
                                                <div>
                                                    <input type="file" name="secondary_images[]" multiple>
                                                    <a href="#paper-kit" class="btn btn-fill btn-danger btn-square fileinput-exists pull-right" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="tab-pane" id="tab3">
                                    <div class="row">
                                        <h5 class="text-center">Наличие товара</h5>
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="form-group">
                                                <select class="form-control" name="availability" title="Наличие товара" data-size="7" tabindex="-98">
                                                    <option class="bs-title-option" value="4">Наличие товара</option>
                                                    @foreach($availability_types as $availability_type)
                                                    <option class="bs-title-option" value="{{ $availability_type->id }}">{{ $availability_type->title }}</option>
                                                    @endforeach
                                                </select>
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
                                    <h5 class="text-center">Страна-производитель</h5>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="form-group">
                                                <select class="form-control" name="manufacturer" title="Страна-производитель" data-size="7" tabindex="-98">
                                                    <option class="bs-title-option" value="">Страна-производитель</option>
                                                    @foreach($manufacturers as $manufacturer)
                                                    <option class="bs-title-option" value="{{ $manufacturer->id }}">{{ $manufacturer->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="text-center">Гарантия</h5>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    Гарантия, месяцев
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" id="" name="guarantee" placeholder="12 мес." value="" minlength="1" maxlength="10">
                                                </div>
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
                                <hr>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-default btn-fill btn-wd btn-back pull-left btn-square disabled" style="display: none;">Назад</button>
                            <button type="button" class="btn btn-info btn-fill btn-wd btn-next btn-square pull-right">Далее</button>
                            <button type="submit" class="btn btn-info btn-fill btn-finish btn-square pull-right" onclick="onFinishWizard()">Готово</button>
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
