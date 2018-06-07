@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Категории
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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-category" >Добавить категорию</a>
                </div>
            </div>
            <br>
            <div class="col-md-12">

               <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Категории</h4>
                    <p class="category">уровень {{ $level }}</p>
                </div>
                <div class="card-content">


                    <div class="card-content table-full-width">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Заголовок</th>
                                    <th></th>
                                    <th>Родительская категория</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($categories)
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id  }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->parent }}</td>
                                    @if($category->level != 1)
                                        <td>
                                    <div class="panel-group" id="accordion">
                                                                            <div class="panel panel-border panel-default">
                                        <a data-toggle="collapse" href="#show-attributes-{{$category->id}}" class="collapsed" aria-expanded="false">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    Атрибуты
                                                    <i class="ti-angle-down"></i>
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="show-attributes-{{$category->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                               <table class="table table-hover">
                                                <tbody>
                                                    @foreach($attributes as $attribute)
                                                    @if($attribute->category_id == $category->id)
                                                    <tr>
                                                        <td>{{ $attribute->title }}</td>
                                                        <td>{{ $attribute->attribute_type }}</td>
                                                        <td><button class="btn btn-success  btn-square btn-fill" data-toggle="modal" data-target="#edit-attr-{{$attribute->id}}"><i class="fa fa-pencil"></i></button></td>
                                                        <td><button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-attr-{{$attribute->id}}"><i class="fa fa-trash"></i></button></td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#add-attr-{{$category->id}}">Добавить атрибут</button>
                                    </div>
                                </div>
                            </div>
                                    </div>

                            </td>

                            @endif
                            <td>
                                <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-category-{{$category->id}}">Изменить</button>
                            </td>
                            <td>
                                <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-category-{{$category->id}}">Удалить</button>
                            </td>
                        </tr>
                        @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <?php echo $categories->render(); ?>
        </div>

    </div> 

</div>
</div>
</div>
@include('includes.dashboard.footer')
</div>
</div>


@endsection
<div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить категорию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-category.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            ID
                        </label>
                        <input class="form-control" type="text" name="id" placeholder="10000" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="title" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Уровень
                        </label>
                        <input class="form-control" type="text" name="level" placeholder="Если это корневая категория, то поставить 1, если имеет предка, то ничего ставить не нужно" minlength="1" maxlength="2">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="parent_id" title="Выберите родительскую категорию" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Выберите родительскую категорию</option>
                            @foreach ($categories_list as $category_item)
                            <option value="{{ $category_item->id }}">{{ $category_item->title }} (уровень {{ $category_item->level }})</option>
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

@foreach($categories as $category)
<div class="modal fade" id="edit-category-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить категорию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-category.post') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="title" placeholder="" required value="{{ $category->title }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="" value="{{ $category->description }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Фоновое изображение
                        </label>
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                            <img src="{{ $category->image }}" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                            <span class="btn btn-rose btn-round btn-file">
                              <span class="fileinput-new">Выберите изображение (1000 * 310)</span>
                              <span class="fileinput-exists">Изменить</span>
                              <input type="file" name="image" value="{{ $category->image }}">
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                      </div>
                  </div>
              </div>                    
              <div class="form-group">
                <label class="control-label">
                    Уровень
                </label>
                <input class="form-control" type="text" name="level" placeholder="Если это корневая категория, то поставить 1, если имеет предка, то ничего ставить не нужно" minlength="1" maxlength="2" value="{{ $category->level }}">
            </div>
            <div class="form-group">
                <select class="form-control" name="parent_id" title="Выберите родительскую категорию" data-size="7" tabindex="-98">
                    <option class="bs-title-option" value="{{ $category->parent }}">Выберите родительскую категорию</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }} (уровень {{ $category->level }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">
                    Активность
                </label>
                @if ($category->active == 0)
                <input type="checkbox" class="switch-plain" name="active">
                @else
                <input type="checkbox" class="switch-plain" name="active" checked>
                @endif
            </div>

        </div>
        <div class="modal-footer">
            <div class="left-side">

            </div>
            <div class="divider"></div>
            <div class="right-side">
                <button type="submit" class="btn btn-info btn-link btn-fw btn-square btn-fill">Изменить</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endforeach


@foreach($categories as $category)
<div class="modal fade" id="add-attr-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Атрибуты</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-category-attribute.post') }}" method="POST">
                   {{ csrf_field() }}
                   <input type="hidden" name="category_id" value="{{ $category->id }}">
                   <div class="form-group">
                    <label class="control-label">
                        Название
                    </label>
                    <input class="form-control" type="text" name="title" placeholder="Материал, вес, размер экрана..." required value="">
                </div>                    
                <div class="form-group">
                    <select class="form-control" name="type" title="Выберите тип" data-size="7" tabindex="-98">
                        <option class="bs-title-option" value="1">Выберите тип</option>
                        <option value="1">Текст</option>
                        <option value="2">Число</option>
                    </select>
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
</div>
@endforeach

@foreach($attributes as $attribute)
<div class="modal fade" id="edit-attr-{{$attribute->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменение атрибута</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-category-attribute.post') }}" method="POST">
                   {{ csrf_field() }}
                   <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                   <div class="form-group">
                    <label class="control-label">
                        Название
                    </label>
                    <input class="form-control" type="text" name="title" placeholder="Материал, вес, размер экрана..." required value="{{ $attribute->title }}">
                </div>                    
                <div class="form-group">
                    <select class="form-control" name="type" title="Выберите тип" data-size="7" tabindex="-98">
                        <option class="bs-title-option" value="{{ $attribute->type }}">Выберите тип</option>
                        <option value="1">Текст</option>
                        <option value="2">Число</option>
                    </select>
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
</div>
@endforeach

@foreach($attributes as $attribute)
<div class="modal fade" id="delete-attr-{{$attribute->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменение атрибута</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.delete-category-attribute.post') }}" method="POST">
                   {{ csrf_field() }}
                   <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">

                   <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link btn-fw btn-square btn-fill">Да, удалить атрибут</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach


@foreach($categories as $category)
<div class="modal fade" id="delete-category-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить категорию?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.delete-category.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
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