@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Бренды
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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-brand">Добавить бренд</a>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                @isset($brands)
                <div class="card-content table-full-width">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Изображение</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th class="text-right">Дата создания</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>
                                    <div class="img-container">
                                                        <img src="{{ $brand->image }}" alt="" width="50px">
                                                    </div>
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->description }}</td>
                                <td class="text-right">{{ $brand->created_at }}</td>
                                <td>
                                    <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-brand-{{$brand->id}}">Изменить</button>

                                </td>
                                <td>
                                    <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-brand-{{$brand->id}}">Удалить</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <?php echo $brands->render(); ?>
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


@foreach($brands as $brand)
  <div class="modal fade" id="edit-brand-{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить бренд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-brand.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="brand_id" value="{{ $brand->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="" required value="{{ $brand->name }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="" value="{{ $brand->description }}">
                    </div>
                    <hr>

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

<div class="modal fade" id="add-brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить бренд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-brand.post') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                    <input class="form-control" type="text" name="description" placeholder="" required>
                    </div>
                    <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                          <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                            <img src="/assets/img/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                        <div>
                            <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать основное изображение (100*100px)</span><span class="fileinput-exists">Изменить</span>
                            <input type="file" name="image">
                        </span>
                        <a href="#paper-kit" class="btn btn-link btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                    </div>
                </div>
                    <hr>
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

@foreach($brands as $brand)
<div class="modal fade" id="delete-brand-{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить товар?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.delete-brand.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="brand_id" value="{{ $brand->id }}">
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