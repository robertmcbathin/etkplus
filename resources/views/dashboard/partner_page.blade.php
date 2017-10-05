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
                @include('includes/notifications')
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user">
                            <div class="image">
                                <img src="{{ $partner->thumbnail }}">
                            </div>
                            <div class="card-content">
                                <div class="author">
                                  <img class="avatar border-white" src="{{ $partner->logo }}">
                                  <h4 class="card-title">{{ $partner->name }}<br>
                                   <a><small>{{ $partner->fullname }}</small></a>
                               </h4>
                           </div>
                           <div class="row">
                            <div class="left-vertical-tabs">
                                <ul class="nav nav-stacked" role="tablist">
                                    <li class="active">
                                        <a href="#info" role="tab" data-toggle="tab">
                                           Описание
                                       </a>
                                   </li>
                                   <li>
                                    <a href="#contacts" role="tab" data-toggle="tab">
                                       Контактные данные
                                   </a>
                               </li>
                               <li>
                                <a href="#agreement" role="tab" data-toggle="tab">
                                   Данные договора
                               </a>
                           </li>
                           <li>
                             <a href="#discounts" role="tab" data-toggle="tab">
                                Скидки и бонусы
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right-text-tabs">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="info">
                            <p>{{ $partner->description }}</p>
                            <p>Создано: <b class="pull-right">{{ $partner->created_at }}</b></p>
                        </div>
                        <div class="tab-pane" id="contacts">
                            <p>тел.: <b class="pull-right">{{ $partner->phone }}</b></p>
                            <p>email: <b class="pull-right">{{ $partner->email }}</b></p>
                            <p>адрес: <b class="pull-right">{{ $partner->address }}</b></p>
                            <p>сайт: <b class="pull-right">{{ $partner->site }}</b></p>
                        </div>
                        <div class="tab-pane" id="agreement">
                            <p>Номер: <b class="pull-right">{{ $partner->contract_id }}</b></p>
                            <p>Юридический адрес: <b class="pull-right">{{ $partner->legal_address }}</b></p>
                            <p>Физический адрес: <b class="pull-right">{{ $partner->physical_address }}</b></p>
                            <p>ИНН: <b class="pull-right">{{ $partner->inn }}</b></p>
                            <p>КПП: <b class="pull-right">{{ $partner->kpp }}</b></p>
                            <p>ОГРН: <b class="pull-right">{{ $partner->ogrn }}</b></p>
                        </div>
                        <div class="tab-pane" id="discounts">
                          @if (count($discounts) > 0)
                          @foreach ($discounts as $discount)
                          <h6 class="card-category"><span class="upper-text">{{ $discount->value }}%</span>   {{ $discount->description }}</h6>
                          @endforeach
                          @else
                          <h6 class="card-category">Действующих скидок нет</h6>
                          @endif
                          @if (count($bonuses) > 0)
                          @foreach ($bonuses as $bonus)
                          <h6 class="card-category"><span class="upper-text">{{ $bonus->value }}@if ($bonus->type == 1) руб. @elseif ($bonus->type == 2) % @endif </span>   {{ $bonus->description }}</h6>
                          @endforeach
                          @else
                          <h6 class="card-category">Действующих бонусов нет</h6>
                          @endif
                      </div>
                  </div>
              </div>
          </div>


      </div>
      <hr>
      <div class="text-center">
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                <h5>{{ $balance->value }} <i class="fa fa-ruble"></i><br><small><i class="fa fa-money"></i> Баланс</small></h5>
            </div>
            <div class="col-md-4">
                <h5>{{ $balance->min_value }} <i class="fa fa-ruble"></i><br><small>Лимит</small></h5>
            </div>
            <div class="col-md-3">
                <h5>{{ $earnings }} <i class="fa fa-ruble"></i><br><small>Выручка (за все время)</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                <h5>{{ $partner->rating }}<br><small><i class="fa fa-star"></i> Рейтинг</small></h5>
            </div>
            <div class="col-md-4">
                <h5>{{ $partner->default_cashback }} <i class="fa fa-percent"></i><br><small><i class="fa fa-gift"></i> Кэшбэк</small></h5>
            </div>
            <div class="col-md-3">
                <h5>{{ $partner->default_comission }} <i class="fa fa-percent"></i><br><small><i class="fa fa-percent"></i> Комиссия</small></h5>
            </div>
        </div>
        <div class="dropup">
          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              Редактировать
              <b class="caret"></b>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#" rel="tooltip" title="" data-toggle="modal" data-target="#edit-partner">
                <i class="fa fa-pencil"></i>
            Общие данные </a></li>
            <li><a href="#" rel="tooltip" title=""  data-toggle="modal" data-target="#edit-logos-partner">
                <i class="fa fa-file-image-o"></i>
            Заменить логотип и фон</a></li>
            <li><a href="#" rel="tooltip" title=""  data-toggle="modal" data-target="#edit-gallery-partner">
                <i class="fa fa-picture-o"></i> Галерея
            </a></li>
            <li>                                            <a href="#" rel="tooltip" title="" data-toggle="modal" data-target="#edit-addresses-partner">
                <i class="fa fa-map-marker"></i> Адреса
            </a></li>
            <li class="divider"></li>
            <li><a href="#" rel="tooltip" title="" data-toggle="modal" data-target="#edit-discounts-partner">
                <i class="fa fa-percent"></i> Скидки
            </a></li>
            <li><a href="#" rel="tooltip" title="" data-toggle="modal" data-target="#edit-bonuses-partner">
                <i class="fa fa-gift"></i> Бонусы
            </a></li>
            <li class="divider"></li>
            <li><a href="#" rel="tooltip" title="" data-toggle="modal" data-target="#delete-partner">
                <i class="fa fa-trash"></i> Удалить
            </a></li>
        </ul>
    </div>
</div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Аккаунты</h4>
    </div>
    <div class="card-content">
        <ul class="list-unstyled team-members">
            @foreach ($accounts as $account)
            <li>
                <div class="row">
                    <div class="col-xs-3">
                        <div class="avatar">
                            <img src="{{ $account->profile_image }}" class="img-circle img-no-padding img-responsive">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        {{ $account->name }}
                        <br>
                        <span class="text-success"><small>{{ $account->post }}</small></span>
                    </div>
                    <div class="col-xs-3 text-right">

                    </div>
                </div>
            </li>     
            @endforeach
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Адреса</h4>
    </div>
    <div class="card-content">
        @if (count($addresses) > 0)
        <ul class="list-unstyled team-members">
            @foreach ($addresses as $address)
            <li>
                <div class="row">
                    <div class="col-xs-3">
                        <div class="avatar">
                            <i class="fa fa-map-marker"></i>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        {{ $address->name }}
                        <br>
                        <span class="text-success"><small>{{ $address->text }}</small></span>
                    </div>
                    <div class="col-xs-3 text-right">

                    </div>
                </div>
            </li>     
            @endforeach
        </ul>
        @else
            <p>Не указано ни одного адреса</p>
        @endif
    </div>
</div>


</div>
<div class="col-lg-8 col-md-7">
    @isset($visits)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Операции</h4>
            </div>
            <div class="card-content table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Карта</th>
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
                            <td>{{ $visit->card_number }}</td>
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
@endisset
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Оплата услуг</h4>
            </div>
            <div class="card-content table-full-width">
              @isset($billings)
              @if (count($billings) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Сумма</th>
                            <th class="text-right">Тип</th>
                            <th class="text-right">Статус</th>
                            <th class="text-right">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($billings as $billing)
                        <tr>
                            <td class="text-center">{{ $billing->id }}</td>
                            <td>{{ $billing->value }}</td>
                            @if($billing->type == 0)
                            <td class="text-right">При создании</td>
                            @endif
                            @if($billing->type == 1)
                            <td class="text-right">Банковский перевод</td>
                            @endif
                            @if($billing->type == 2)
                            <td class="text-right">Интернет-эквайринг</td>
                            @endif
                            @if($billing->type == 3)
                            <td class="text-right">Другой способ</td>
                            @endif
                            @if($billing->status == 0)
                            <td class="text-right">Начислен</td>
                            @endif
                            @if($billing->status == 1)
                            <td class="text-right">Оплачен</td>
                            @endif
                            @if($billing->status == 3)
                            <td class="text-right">Создан, не оплачен</td>
                            @endif
                            <td class="text-right">{{ $billing->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <?php echo $billings->render(); ?>
                </div>
                @else 
                <h6>Операций по счету нет</h6>
                @endif
                @endisset
            </div>
        </div>
    </div>
</div>
    <div>
        <div>
            <h4>Галерея</h4>
        </div>
        <div>
            <div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
                @if (count($gallery_items) > 0)
                @foreach ($gallery_items as $gallery_item)
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="col-md-3 col-sm-4 gallery-item">
                 <a href="{{ $gallery_item->image_path }}" itemprop="contentUrl" data-size="{{ $gallery_item->image_width }}x{{ $gallery_item->image_height }}">
                   <img src="{{ $gallery_item->image_path }}" itemprop="thumbnail" alt="" class="horizontal-image img-rounded img-responsive">
               </a>
               <figcaption itemprop="caption description">{{ $gallery_item->image_caption }}</figcaption>
           </figure>
           @endforeach
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
                        <label class="control-label">
                            ОГРН
                        </label>
                        <input class="form-control" type="text" name="ogrn" placeholder="" value ="{{ $partner->ogrn }}">
                    </div>
                    <h5 class="text-center">Категория</h5>

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
                                    <input type="text" name="name" placeholder="филиал №..., дополнительный офис №..." class="form-control" maxlength="100">
                                    <span class="help-block">Если планируется только один адрес, то оставить поле пустым</span>
                                </div>
                                <div class="form-group">
                                    <label>Адрес</label>
                                    <input type="text" name="text" placeholder="г. Чебоксары, ул. Ленина, д.22" class="form-control" maxlength="255" required>
                                </div>
                                <div class="form-group">
                                    <label>Доп. поле</label>
                                    <input type="text" name="comment" placeholder="помещение, офис и т.п." class="form-control" maxlength="255">
                                </div>
                                <div class="form-group">
                                    <label>Широта (координата)</label>
                                    <input type="text" name="latitude" placeholder="56.138015" class="form-control" maxlength="20">
                                    <span class="help-block">Для корректного отображения на картах заполнение обязательно!</span>
                                </div>
                                <div class="form-group">
                                    <label>Долгота (координата)</label>
                                    <input type="text" name="longitude" placeholder="47.234006" class="form-control" maxlength="20">
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

<div class="modal fade" id="edit-discounts-partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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
                                    Добавить скидку
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

<div class="modal fade" id="edit-bonuses-partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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
                                        @if ($bonus->type == 1)
                                        <p class="form-control-static pull-right">В рублях</p>
                                        @elseif ($bonus->type == 2)
                                        <p class="form-control-static pull-right">В процентах</p>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Срок действия</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static pull-right">{{ $bonus->lifetime }}</p>
                                    </div>
                                </div>
                            </fieldset>
                            <form action="{{ route('dashboard.delete-partner-bonus.post') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="bonus_id"  value="{{ $bonus->id }}">
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
                        <form method="POST" action="{{ route('dashboard.add-partner-bonus.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Добавить бонус
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Наименование</label>
                                    <input type="text" placeholder="За заказ от 1000 рублей" class="form-control" maxlength="100" minlength="1" name="description" required>
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