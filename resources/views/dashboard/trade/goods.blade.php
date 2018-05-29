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
                <div class="row">
                 <div class="col-md-12">
                    <a class="btn btn-danger btn-fill btn-wd btn-square" href="{{ route('dashboard.shop.add-product.get') }}">Добавить товар</a>
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-goods-csv" >Загрузить CSV</a>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                @isset($goods)
                <div class="card-content table-full-width">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th></th>
                                <th>Название</th>
                                <th>Цена продажи</th>
                                <th>Цена без скидки</th>
                                <th>Цена закупки</th>
                                <th>Категория</th>
                                <th>Продавец</th>
                                <th class="text-right">Добавлен</th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goods as $good)
                            <tr>
                                <td>{{ $good->id }}</td>
                                <td>
                                    <div class="img-container">
                                                        <img src="{{ $good->image_small }}" alt="Agenda" width="50px">
                                                    </div>
                                </td>
                                <td>{{ $good->name }}</td>
                                <td>{{ $good->price }}</td>
                                <td>{{ $good->price_without_discount }}</td>
                                <td>{{ $good->price_cost }}</td>
                                <td>{{ $good->category }}</td>
                                <td>{{ $good->shop_name }} </td>
                                <td class="text-right">{{ $good->created_at }}</td>
                                <td>
                                    <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-good-{{$good->id}}">Изменить</button>

                                </td>
                                <td>
                                    <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-good-{{$good->id}}">Удалить</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <?php echo $goods->render(); ?>
                    </div>
                </div>
                @endisset

            </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection


@foreach($goods as $good)
  <div class="modal fade" id="edit-good-{{ $good->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить товар</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-good.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="" required value="{{ $good->name }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Полное название
                        </label>
                        <input class="form-control" type="text" name="fullname" placeholder="" value="{{ $good->fullname }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="" value="{{ $good->description }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Цена продажи
                        </label>
                        <input class="form-control" type="text" name="price" placeholder="" required value="{{ $good->price }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Цена без скидки (опционально)
                        </label>
                        <input class="form-control" type="text" name="price_without_discount" placeholder="" value="{{ $good->price_without_discount }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Стоимость закупки
                        </label>
                        <input class="form-control" type="text" name="price_cost" placeholder="" required value="{{ $good->price_cost }}">
                    </div>
                    <hr>

                    <div class="form-group">
                        <select class="form-control" name="shop_id" title="Выберите продавца" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="{{ $good->shop_id }}">Выберите продавца</option>
                            @foreach ($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="category_id" title="Выберите категорию" data-size="7" tabindex="-98" required>
                            <option class="bs-title-option" value="{{ $good->category_id }}">{{ $good->category }} ({{ $good->category_id }})</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"> {{$category->id}} | {{ $category->title }} ( ур. {{$category->level}}), ({{ $category->parent }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-square btn-fill btn-fw">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  
@endforeach

<div class="modal fade" id="add-goods-csv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить товар (загрузить CSV)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-goods-csv.post') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Файл каталога
                        </label>
                        <input type="file" class="btn-file" name="catalog" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <select class="form-control" name="shop_id" title="Выберите продавца" data-size="7" tabindex="-98" required>
                            <option class="bs-title-option" value="3">Выберите продавца* (по умолчанию ЕТКплюс)</option>
                            @foreach ($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="category_id" title="Выберите категорию" data-size="7" tabindex="-98" required>
                            <option class="bs-title-option" value=" ">Выберите категорию (уровня 3)</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"> {{$category->id}} | {{ $category->title }} ( ур. {{$category->level}}), ({{ $category->parent }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-square btn-fill btn-fw">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($goods as $good)
<div class="modal fade" id="delete-good-{{$good->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить товар?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.delete-good.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                </div>
                <div class="modal-footer">
                    <div class="left-side">

                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link btn-fw btn-square btn-fill">Да, удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach