@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Список предприятий
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications');
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Список предприятий</h4>
                        </div>
                        <div class="card-content table-full-width">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Название</th>
                                        <th>Действие</th>
                                        <th class="text-right">Активность</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($partners as $partner)
                                    <tr>
                                        <td class="text-center">{{ $partner->id }}</td>
                                        <td><a href="{{ route('dashboard.partner-page.get', ['partner_id' => $partner->id]) }}">{{ $partner->name }}</a></td>
                                        <td>

                                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Редактировать" data-toggle="modal" data-target="#edit-partner-{{ $partner->id }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Заменить логотип и фон" data-toggle="modal" data-target="#edit-logos-partner-{{ $partner->id }}">
                                                <i class="fa fa-file-image-o"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Галерея" data-toggle="modal" data-target="#edit-gallery-partner-{{ $partner->id }}">
                                                <i class="fa fa-picture-o"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Адреса" data-toggle="modal" data-target="#edit-addresses-partner-{{ $partner->id }}">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Скидки" data-toggle="modal" data-target="#edit-discounts-partner-{{ $partner->id }}">
                                                <i class="fa fa-percent"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Бонусы" data-toggle="modal" data-target="#edit-bonuses-partner-{{ $partner->id }}">
                                                <i class="fa fa-gift"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Удалить" data-toggle="modal" data-target="#delete-partner-{{ $partner->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            @if ($partner->is_active == 1)
                                            <input type="checkbox" data-id="{{ $partner->id }}" class="switch-plain toggle-activate-partner" checked disabled>
                                            @else
                                            <input type="checkbox" data-id="{{ $partner->id }}"" class="switch-plain toggle-activate-partner" disabled>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <?php echo $partners->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection
@foreach ($partners as $partner)
<div class="modal fade" id="delete-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header no-border-header">
                <div></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <h5>Удалить предприятие?</h5>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Нет</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <form action="{{ route('dashboard.delete_partner.post') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                        <button type="submit" class="btn btn-danger btn-link">Да</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($partners as $partner)
<div class="modal fade" id="edit-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Редактировать предприятие</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.edit_partner.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center">Основные данные предприятия</h5>
                    <div class="form-group">
                        <label class="control-label">
                            Краткое наименование
                        </label>
                        <input class="form-control" type="text" name="name" value="{{ $partner->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Полное наименование
                        </label>
                        <input class="form-control" type="text" name="fullname" required="true" value="{{ $partner->fullname }}" aria-required="true" required>
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Описание</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="6">{{ $partner->description }}</textarea>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label class="control-label">
                            Основной номер телефона
                        </label>
                        <input class="form-control" type="text" name="phone" value="{{ $partner->phone }}" aria-required="true" aria-invalid="true" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Основной адрес
                        </label>
                        <input class="form-control" type="text" name="address" value="{{ $partner->address }}" aria-required="true" aria-invalid="true" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Email
                        </label>
                        <input class="form-control" type="email" name="email" email="true" value="{{ $partner->email }}" aria-required="true" aria-invalid="true" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Сайт
                        </label>
                        <input class="form-control" type="text" name="site" value="{{ $partner->site }}">
                    </div>
                    <h5 class="text-center">Данные для подключения к системе</h5>
                    <div class="form-group">
                        <label class="control-label">
                            Комиссия (%)
                        </label>
                        <input class="form-control" type="text" name="comission" placeholder="" value ="{{ $partner->default_comission }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Скидка по умолчанию (%)
                        </label>
                        <input class="form-control" type="text" name="discount" placeholder="" value ="{{ $partner->default_discount }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Номер договора
                        </label>
                        <input class="form-control" type="text" name="contract_id" placeholder="17001" value ="{{ $partner->contract_id }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Юридический адрес
                        </label>
                        <input class="form-control" type="text" name="legal_address" placeholder="428000, город Чебоксары, ..." value ="{{ $partner->legal_address }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Физический адрес
                        </label>
                        <input class="form-control" type="text" name="physical_address" placeholder="428000, город Чебоксары, ..." value ="{{ $partner->physical_address }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            ИНН
                        </label>
                        <input class="form-control" type="text" name="inn" placeholder="" value ="{{ $partner->inn }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            КПП
                        </label>
                        <input class="form-control" type="text" name="kpp" placeholder="" value ="{{ $partner->kpp }}">
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="category" title="Выберите категорию" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="{{ $partner->category_id }}">{{ $partner->category_name }}</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <p class="category">Активировать/деактивировать</p>
                            @if ($partner->is_active == 0)
                            <input type="checkbox" class="switch-plain" name="is_active">
                            @else
                            <input type="checkbox" class="switch-plain" name="is_active" checked>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($partners as $partner)
<div class="modal fade" id="edit-logos-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить изображения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.edit_partner_logos.post') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                          <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                            <img src="{{ $partner->thumbnail }}" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                        <div>
                            <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать фон (1307 на 392)</span><span class="fileinput-exists">Изменить</span>
                            <input type="file" name="background_image" value="{{ $partner->thumbnail }}">
                        </span>
                        <a href="" class="btn btn-link btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                  <div class="fileinput-new thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;">
                    <img src="{{ $partner->logo }}" alt="">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail img-no-padding" style="max-width: 370px; max-height: 250px;"></div>
                <div>
                    <span class="btn btn-outline-default btn-round btn-file"><span class="fileinput-new">Выбрать логотип (150 на 150)</span><span class="fileinput-exists">Изменить</span>
                    <input type="file" name="logo_image" value="{{ $partner->logo }}">
                </span>
                <a href="" class="btn btn-link btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Удалить</a>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="left-side">
        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
    </div>
    <div class="divider"></div>
    <div class="right-side">
        <button type="submit" class="btn btn-success btn-link">Сохранить</button>
    </div>
</form>
</div>
</div>
</div>
</div>
@endforeach

@foreach ($partners as $partner)
<div class="modal fade" id="edit-gallery-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить изображения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="col-md-10 col-md-offset-1">
                    <div class="table-responsive">
                        <table class="table table-shopping">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gallery_items as $gallery_item)
                                @if ($gallery_item->partner_id == $partner->id)
                                <tr>
                                    <td>
                                        <div class="img-container">
                                            <img src="{{ $gallery_item->image_path }}" alt="">
                                        </div>
                                    </td>
                                    <td class="td-product">
                                        <form action="{{ route('dashboard.edit-gallery-item.post') }}" method="POST">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                                          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                          <input type="hidden" name="gallery_item_id" value="{{ $gallery_item->id }}">
                                          <div class="form-group">
                                            <input type="text" class="form-control" value="{{ $gallery_item->image_caption }}" name="image_caption">
                                        </div>
                                        <input type="submit" class="btn btn-info" value="Изменить описание">
                                    </form>
                                    <form action="{{ route('dashboard.delete-gallery-item.post') }}" method="POST">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                                      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                      <input type="hidden" name="gallery_item_id" value="{{ $gallery_item->id }}">
                                      <input type="hidden" name="gallery_item_path" value="{{ $gallery_item->image_path }}">
                                      <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>Удалить</button>
                                  </form>
                              </td>
                          </tr>
                          @endif
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="col-md-10 col-md-offset-1">
            <h5 class="text-center">Добавить фотографии</h5>
            <form action="{{ route('dashboard.load-gallery.post') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="file" class="btn-file" name="gallery[]" multiple>
                <button class="btn btn-info" type="submit"><i class="fa fa-download"></i>Загрузить</button>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <div class="left-side">
            <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
        </div>
        <div class="divider"></div>
        <div class="right-side">
            <button type="submit" class="btn btn-success btn-link">Сохранить</button>
        </div>
    </div>
</div>
</div>
</div>
@endforeach

@foreach ($partners as $partner)
<div class="modal fade" id="edit-addresses-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Адреса</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                @isset($addresses)
                @foreach ($addresses as $address)
                @if ($address->partner_id == $partner->id)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{ $address->name }}
                            </h4>
                        </div>
                        <div class="card-content">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Адрес</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $address->text }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Дополнительное поле</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $address->comment }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Режим работы</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $address->schedule }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Телефоны</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $address->phones }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <form action="{{ route('dashboard.delete-partner-address.post') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="address_id"  value="{{ $address->id }}">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endisset
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('dashboard.add-partner-address.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Добавить адрес
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Название точки</label>
                                    <input type="text" name="name" placeholder="филиал №..., дополнительный офис №..." class="form-control" maxlength="100">
                                    <span class="help-block">Если планируется только один адрес, то оставить поле пустым</span>
                                </div>
                                <div class="form-group">
                                    <label>Адрес</label>
                                    <input type="text" name="text" placeholder="г. Чебоксары, ул. Ленина, д.22" class="form-control" maxlength="255">
                                </div>
                                <div class="form-group">
                                    <label>Доп. поле</label>
                                    <input type="text" name="comment" placeholder="помещение, офис и т.п." class="form-control" maxlength="255">
                                </div>
                                <div class="form-group">
                                    <label>Режим работы</label>
                                    <input type="text" name="schedule" placeholder="пн-пт: с 8 до 17" class="form-control" maxlength="255">
                                </div>
                                <div class="form-group">
                                    <label>Телефоны</label>
                                    <input type="text" name="phones" placeholder="+79003454545," class="form-control" maxlength="255">
                                </div>
                                <button type="submit" class="btn btn-fill btn-info">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($partners as $partner)
<div class="modal fade" id="edit-discounts-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Скидки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                @isset($discounts)
                @foreach ($discounts as $discount)
                @if ($discount->partner_id == $partner->id)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Наименование</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $discount->description }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Размер скидки</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $discount->value }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Срок действия</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $discount->lifetime }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <form action="{{ route('dashboard.delete-partner-discount.post') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="discount_id"  value="{{ $discount->id }}">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endisset
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('dashboard.add-partner-discount.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Добавить адрес
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Наименование</label>
                                    <input type="text" placeholder="На весь ассортимент" class="form-control" maxlength="100" minlength="1" name="description" required>
                                </div>
                                <div class="form-group">
                                    <label>Размер скидки</label>
                                    <input type="text" name="value" placeholder="10" class="form-control" minlength="1" required>
                                    <span class="help-block">проценты указывать не нужно</span>
                                </div>
                                <div class="form-group">
                                        <label>Срок действия</label>
                                        <input type="text" name="lifetime" class="form-control datepicker" placeholder="Добавить" value="01/01/2030">
                                        <span class="help-block">по умолчанию до 1 января 2030 года</span>
                                    </div>
                                <button type="submit" class="btn btn-fill btn-info">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($partners as $partner)
<div class="modal fade" id="edit-bonuses-partner-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Бонусы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                @isset($bonuses)
                @foreach ($bonuses as $bonus)
                @if ($bonus->partner_id == $partner->id)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Наименование</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $bonus->description }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Размер бонуса</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $bonus->value }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Единица измерения</label>
                                    <div class="col-sm-10">
                                        <div class="radio">
                                        <input type="radio" name="type" id="radio1" value="1" checked>
                                        <label for="radio1">
                                            В рублях (р)
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="type" id="radio2" value="2">
                                        <label for="radio2">
                                            В процентах (%)
                                        </label>
                                    </div>
                                    </div>
                                </div>
                            </fieldset>
                            <form action="{{ route('dashboard.delete-partner-discount.post') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="discount_id"  value="{{ $discount->id }}">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endisset
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('dashboard.add-partner-discount.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Добавить адрес
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Наименование</label>
                                    <input type="text" placeholder="На весь ассортимент" class="form-control" maxlength="100" minlength="1" name="description" required>
                                </div>
                                <div class="form-group">
                                    <label>Размер бонуса</label>
                                    <input type="text" name="value" placeholder="10" class="form-control" minlength="1" required>
                                    <span class="help-block">только числовое значение</span>
                                </div>
                                <div class="form-group">
                                        <div class="radio">
                                        <input type="radio" name="type" id="radio1" value="1" checked>
                                        <label for="radio1">
                                            В рублях (р)
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="type" id="radio2" value="2">
                                        <label for="radio2">
                                            В процентах (%)
                                        </label>
                                    </div>
                                    </div>
                                <button type="submit" class="btn btn-fill btn-info">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
  var token = '{{ Session::token() }}';
</script>