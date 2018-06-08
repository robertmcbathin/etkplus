@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $product->name }}
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
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user card-product">
                            <div class="image" style="height: 400px !important; width: 400px !important;" data-toggle="tooltip" data-placement="right" title="Изменить изображение">
                                <a href="#" >
                                    <img src="{{ $product->image }}" alt="" data-toggle="modal" data-target="#edit-product-image">
                                </a>
                            </div>
                            <div class="card-content">
                                <div class="author">
                                    <br>
                                    <br>
                                    <br>
                                    <h4 class="card-title">{{ $product->name }}<br>
                                    </h4>
                                </div>
                                <p class="description text-center">
                                    {{ $product->fullname }}
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-1">
                                        <h5>{{ $product->price }} <i class="fa fa-ruble"></i><br><small>Цена</small></h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>{{ $product->price_without_discount }} <i class="fa fa-ruble"></i><br><small>Цена без скидки</small></h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>{{ $product->price_cost }} <i class="fa fa-ruble"></i><br><small>Стоимость</small></h5>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Атрибуты <button class="btn btn-info btn-fill btn-wd btn-square pull-right" data-toggle="modal" data-target="#add-attribute">Добавить</button></h4>
                                <hr>
                            </div>
                            <div class="card-content">
                                @if( count($product_attributes) > 0)
                                @foreach($product_attributes as $product_attribute)
                                    <p><a href="#" data-toggle="modal" data-target="#edit-product-attribute-{{ $product_attribute->id }}">{{$product_attribute->attribute_name}}</a> <b class="pull-right">{{ $product_attribute->value }}</b></p>
                                @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <span><b> Внимание </b> Для данного товара еще не заданы атрибуты</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Редактирование товара</h4>
                            </div>
                            <div class="card-content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Название</label>
                                                <input type="text" class="form-control border-input" name="fullname" value="{{ $product->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Полное название</label>
                                                <input type="text" class="form-control border-input" name="fullname" value="{{ $product->fullname }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Описание</label>
                                                <textarea rows="5" class="form-control border-input" name="description" value="{{ $product->description }}">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Цена продажи</label>
                                                <input type="text" class="form-control border-input" name="price" value="{{ $product->price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Цена без скидки</label>
                                                <input type="text" class="form-control border-input" name="price_without_discount" value="{{ $product->price_without_discount }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Стоимость</label>
                                                <input type="text" class="form-control border-input" name="price_cost" value="{{ $product->price_cost }}">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Наличие</label>
                                                <select class="form-control" name="availability" title="Статус наличия" data-size="7" tabindex="-98" required>
                                                    <option class="bs-title-option" value="{{ $product->availability }}">{{ $product->availability_status }}</option>
                                                    @foreach ($availability_types as $availability_type)
                                                    <option value="{{ $availability_type->id }}">{{ $availability_type->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Страна-производитель</label>
                                                <select class="form-control" name="manufacturer" title="Страна-производитель" data-size="7" tabindex="-98" required>
                                                    <option class="bs-title-option" value="{{ $product->manufacturer }}">{{ $product->manufacturer_title }}</option>
                                                    @foreach ($manufacturers as $manufacturer)
                                                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Гарантия, мес.</label>
                                                <input type="text" class="form-control border-input" name="price_cost" value="{{ $product->guarantee }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd btn-square pull-right">Сохранить изменения</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
</div>


<div class="modal fade" id="edit-product-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменение главного изображения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-product-image.post') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="file" name="primary_image">
                </div>
                <div class="modal-footer">
                    <div class="left-side">

                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-fw btn-square btn-fill">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-attribute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавление атрибута</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-product-attribute.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label>Выберите атрибут</label>
                        <select class="form-control" name="attribute_id" title="Атрибут" data-size="7" tabindex="-98" required>
                            <option class="bs-title-option" value="">Атрибут</option>
                            @foreach ($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Значение</label>
                        <input type="text" class="form-control border-input" name="value">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">

                    </div>
                    <div class="divider"></div>

                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-square btn-fill pull-right">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($product_attributes as $product_attribute)
<div class="modal fade" id="edit-product-attribute-{{ $product_attribute->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">{{ $product_attribute->attribute_name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-product-attribute.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="attribute_id" value="{{ $product_attribute->attribute_id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label>Значение</label>
                        <input type="text" class="form-control border-input" name="value" value="{{ $product_attribute->value }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="submit" class="btn btn-success btn-link btn-square btn-fill pull-left">Сохранить изменения</button>
                    </div>
                    </form>
                    <div class="divider"></div>
                    <div class="right-side">
                        <form action="{{ route('dashboard.shop.delete-product-attribute.post') }}" method="POST">
                          {{ csrf_field() }}
                          <input type="hidden" name="product_id" value="{{ $product->id }}">
                          <input type="hidden" name="attribute_id" value="{{ $product_attribute->attribute_id }}">
                          <button type="submit" class="btn btn-danger btn-link btn-square btn-fill pull-right">Удалить</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection


