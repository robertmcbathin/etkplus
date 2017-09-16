@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $partner->name }}
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications');
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">

                                        <h4 class="card-title"> {{ $partner->name }}                                             <div class="avatar avatar-logo pull-left">
                                          <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="img-circle img-responsive">
                                      </div></h4>
                                      <p class="category">{{ $partner->fullname }}</p>
                                  </div>
                                  <div class="card-content">
                                    <div class="table-full-width table-tasks">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>

                                                    </td>
                                                    <td>
                                                        <h5>Общие данные</h5>
                                                        <p><b>Описание: </b>{{ $partner->description }}</p>
                                                        <p><b>Создан: </b>{{ $partner->created_at }}</p>
                                                        <p><b>Номер телефона: </b>{{ $partner->phone }}</p>
                                                        <p><b>Email: </b>{{ $partner->email }}</p>
                                                        <p><b>Адрес: </b>{{ $partner->address }}</p>
                                                        <p><b>Сайт: </b>{{ $partner->site }}</p>
                                                        <h5>Данные договора</h5>
                                                        <p><b>Номер: </b>{{ $partner->contract_id }}</p>
                                                        <p><b>Юридический адрес: </b>{{ $partner->legal_address }}</p>
                                                        <p><b>Физический адрес: </b>{{ $partner->physical_address }}</p>
                                                        <p><b>ИНН: </b>{{ $partner->inn }}</p>
                                                        <p><b>КПП: </b>{{ $partner->kpp }}</p>
                                                        <p><b>ОГРН: </b>{{ $partner->ogrn }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
                                                            @if ($gallery_items)
                                                           @foreach ($gallery_items as $gallery_item)
                                                           <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="col-md-3 col-sm-4 gallery-item">
                                                             <a href="{{ $gallery_item->image_path }}" itemprop="contentUrl" data-size="{{ $gallery_item->image_width }}x{{ $gallery_item->image_height }}">
                                                               <img src="{{ $gallery_item->image_path }}" itemprop="thumbnail" alt="" class="horizontal-image img-rounded img-responsive">
                                                           </a>
                                                           <figcaption itemprop="caption description">{{ $gallery_item->image_caption }}</figcaption>
                                                       </figure>
                                                       @endforeach
                                                       @else 
                                                       <h2>Нет изображений</h2>
                                                       @endif
                                                   </div>
                                                   <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                                   <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. 
        It's a separate element, as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

          <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
          <!-- don't modify these 3 pswp__item elements, data is added later on. -->
          <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

              <!--  Controls are self-explanatory. Order can be changed. -->

              <div class="pswp__counter"></div>

              <button class="pswp__button pswp__button--close" title="Закрыть (Esc)"></button>

              <button class="pswp__button pswp__button--share" title="Скачать"></button>

              <button class="pswp__button pswp__button--fs" title="Полный экран"></button>

              <button class="pswp__button pswp__button--zoom" title="Увеличить / уменьшить"></button>

              <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
              <!-- element will get class pswp__preloader--active when preloader is running -->
              <div class="pswp__preloader">
                <div class="pswp__preloader__icn">
                  <div class="pswp__preloader__cut">
                    <div class="pswp__preloader__donut"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
      <div class="pswp__share-tooltip"></div> 
  </div>

  <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
  </button>

  <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
  </button>

  <div class="pswp__caption">
      <div class="pswp__caption__center"></div>
  </div>

</div>

</div>

</div>
</td>
<td></td>
</tr>
<tr>
    <td>

    </td>
    <td>
        <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Редактировать" data-toggle="modal" data-target="#edit-partner">
            <i class="fa fa-pencil"></i>
        </a>
        <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Заменить логотип и фон" data-toggle="modal" data-target="#edit-logos-partner">
            <i class="fa fa-file-image-o"></i>
        </a>
        <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Галерея" data-toggle="modal" data-target="#edit-gallery-partner">
            <i class="fa fa-picture-o"></i>
        </a>
        <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Адреса" data-toggle="modal" data-target="#edit-addresses-partner">
            <i class="fa fa-map-marker"></i>
        </a>
        <a href="#" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Удалить" data-toggle="modal" data-target="#delete-partner">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-4">
  <div class="row">
    <div class="col-lg-6 col-sm-6">
        <div class="card info-block">
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-success text-center">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Счет</p>
                            {{ $balance->value }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <hr>
                <div class="stats">
                    <i class="fa fa-ruble"></i> обещанный платеж: {{ $balance->min_value }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="card info-block">
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-info text-center">
                            <i class="fa fa-refresh"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Выручка</p>
                            {{ $earnings }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <hr>
                <div class="stats">
                    <i class="fa fa-calendar"></i> За все время
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="card info-block">
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-warning text-center">
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Рейтинг</p>
                            {{ $partner->rating }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <hr>
                <div class="stats">
                    Среднее значение
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="card info-block">
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-success text-center">
                            <i class="fa fa-percent"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Комиссия</p>
                            {{ $partner->default_comission }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <hr>
                <div class="stats">
                    По умолчанию
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="card info-block">
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-danger text-center">
                            <i class="fa fa-percent"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Кэшбэк</p>
                            {{ $partner->default_cashback }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <hr>
                <div class="stats">
                    По умолчанию
                </div>
            </div>
        </div>
    </div>
</div>  
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Операции по предприятию</h4>
            </div>
            <div class="card-content table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Клиент</th>
                            <th class="text-right">Счет</th>
                            <th class="text-right">Скидка</th>
                            <th class="text-right">Бонус</th>
                            <th class="text-right">Кэшбэк</th>
                            <th class="text-right">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visits as $visit)
                        <tr>
                            <td class="text-center">{{ $visit->id }}</td>
                            <td>{{ $visit->user_name }}</td>
                            <td class="text-right">{{ $visit->bill }}</td>
                            <td class="text-right">{{ $visit->discount }}</td>
                            <td class="text-right">{{ $visit->bonus }}</td>
                            <td class="text-right">{{ $visit->cashback }}</td>
                            <td class="text-right">{{ $visit->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <?php echo $visits->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('includes.dashboard.footer')
</div>
</div>


<div class="modal fade" id="delete-partner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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

<div class="modal fade" id="edit-partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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

<div class="modal fade" id="edit-logos-partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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

<div class="modal fade" id="edit-gallery-partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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

<div class="modal fade" id="edit-addresses-partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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
                                    <input type="text" placeholder="филиал №..., дополнительный офис №..." class="form-control" maxlength="100">
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