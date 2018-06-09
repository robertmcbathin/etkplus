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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" href="{{ route('dashboard.partner.shop.add-product-item.get') }}">Добавить товар</a>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                @isset($products)
                <div class="card-content table-full-width">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th></th>
                                <th>Название</th>
                                <th>Цена продажи</th>
                                <th>Цена без скидки</th>
                                <th>Наличие</th>
                                <th>Категория</th>
                                <th>Продавец</th>
                                <th class="text-right">Добавлен</th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <div class="img-container">
                                                       <a href="{{ route('dashboard.shop.show-product.get',['product_id' => $product->id]) }}">
                                                           <img src="{{ $product->image_small }}" alt="" width="50px">
                                                       </a> 
                                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.shop.show-product.get',['product_id' => $product->id]) }}">{{ $product->name }}</a></td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->price_without_discount }}</td>
                                <td>{{ $product->availability_status }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->shop_name }} </td>
                                <td class="text-right">{{ $product->created_at }}</td>
                                <td>
                                    <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-product-{{$product->id}}">Изменить</button>

                                </td>
                                <td>
                                    <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-product-{{$product->id}}">Удалить</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <?php echo $products->render(); ?>
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


@foreach($products as $product)
  <div class="modal fade" id="edit-product-{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить товар</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-product.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="" required value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Полное название
                        </label>
                        <input class="form-control" type="text" name="fullname" placeholder="" value="{{ $product->fullname }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="" value="{{ $product->description }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Цена продажи
                        </label>
                        <input class="form-control" type="text" name="price" placeholder="" required value="{{ $product->price }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Цена без скидки (опционально)
                        </label>
                        <input class="form-control" type="text" name="price_without_discount" placeholder="" value="{{ $product->price_without_discount }}">
                    </div>
                    <hr>

                    <div class="form-group">
                        <select class="form-control" name="category_id" title="Выберите категорию" data-size="7" tabindex="-98" required>
                            <option class="bs-title-option" value="{{ $product->category_id }}">{{ $product->category }} ({{ $product->category_id }})</option>
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

@foreach($products as $product)
<div class="modal fade" id="delete-product-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить товар?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.partner.shop.delete-product.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
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