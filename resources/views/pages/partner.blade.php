@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $partner->name }}
@endsection
@section('content')
<div class="wrapper">

  <div class="page-header page-header-xs filter pattern-image" style="background-image: url('{{ $partner->thumbnail }}');">
    <div class="content-center">
    </div>
  </div>        
</div>
<div class="profile-content section-white-gray">
  <div class="container">
    <div class="row owner">
      <div class="col-md-2 offset-md-5 col-sm-4 offset-md-4 col-xs-6 offset-md-3 text-center">
        <div class="avatar">
          <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="img-circle img-responsive">
        </div>
        <div class="static rating"> 
          @if ($star_rating == 5)
          <input type="radio" id="star5" name="rating" value="5" checked disabled><label for="star5" title="Отлично">5 stars</label>
          @else
          <input type="radio" id="star5" name="rating" value="5" disabled><label for="star5" title="Отлично">5 stars</label>
          @endif
          @if ($star_rating == 4)
          <input type="radio" id="star4" name="rating" value="4" checked disabled><label for="star4" title="Хорошо">4 stars</label>
          @else
          <input type="radio" id="star4" name="rating" value="4" disabled><label for="star4" title="Хорошо">4 stars</label>
          @endif
          @if ($star_rating == 3)
          <input type="radio" id="star3" name="rating" value="3" checked disabled><label for="star3" title="Удовлетворительно">3 stars</label>
          @else
          <input type="radio" id="star3" name="rating" value="3" disabled><label for="star3" title="Удовлетворительно">3 stars</label>
          @endif
          @if ($star_rating == 2)
          <input type="radio" id="star2" name="rating" value="2" checked disabled><label for="star2" title="Плохо">2 stars</label>
          @else
          <input type="radio" id="star2" name="rating" value="2" disabled><label for="star2" title="Плохо">2 stars</label>
          @endif
          @if ($star_rating == 1)
          <input type="radio" id="star1" name="rating" value="1" checked disabled><label for="star1" title="Отвратительно">1 star</label> 
          @else
          <input type="radio" id="star1" name="rating" value="1" disabled><label for="star1" title="Отвратительно">1 star</label> 
          @endif
        </div>
        <a href="" class="btn btn-info btn-link" data-toggle="tooltip" data-placement="right" title="" data-original-title="Среднее значение от количества посетителей, оставивших отзыв">
          Рейтинг: {{ $rating }} ({{ $review_count }})
        </a>
        <div class="name">
          <h4>{{ $partner->name }}</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-3 text-center">
        <div class="description-details">
          <ul class="list-unstyled">
            <li><i class="fa fa-map-marker"></i>{{ $partner->address }}</li>
            <li><i class="fa fa-link"></i> <a href="{{ $partner->site }}" target="_blank" rel="nofollow">{{ $partner->site }}</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="profile-tabs">

      <div id="my-tab-content" class="tab-content">
        <div class="row">
          <div class="col-md-8">





            <div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
             @if ($partner_images)
             @foreach ($partner_images as $partner_image)
             <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="col-md-3 col-sm-4 gallery-item">
               <a href="{{ $partner_image->image_path }}" itemprop="contentUrl" data-size="{{ $partner_image->image_width }}x{{ $partner_image->image_height }}">
                 <img src="{{ $partner_image->image_path }}" itemprop="thumbnail" alt="" class="horizontal-image img-rounded img-responsive">
               </a>
               <figcaption itemprop="caption description">{{ $partner_image->image_caption }}</figcaption>
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
  <h5 class="card-title">
    Описание
  </h5>
  <p>{{ $partner->description }}</p>
  <h5 class="card-title">
    Последние отзывы · <small><a href="{{ route('site.show-partner-reviews-page.get',['id' => $partner->id]) }}" class="link-info">Смотреть все</a></small>
  </h5>
  <div class="container">

    <div class="row">
      @foreach ($reviews as $review)
      <div class="col-4 col-md-auto col-lg-auto col-xs-auto">
        <div class="card" data-background="color" data-color="{{ $review->background_color }}">
          <div class="card-block">
            <div class="author">
              <a href="/profile/{{ $review->user_id }}">
               <img src="https://etk21.ru{{ $review->profile_image }}" alt="" class="avatar img-raised">
               <span>{{ $review->title }}</span>
             </a>
           </div>
           <div class="pull-left">
            <div class="static rating"> 
              @if ($review->rating == 5)
              <input type="radio" id="star5"  value="5" checked disabled><label for="star5" title="Отлично">5 stars</label>
              @else
              <input type="radio" id="star5"  value="5" disabled><label for="star5" title="Отлично">5 stars</label>
              @endif
              @if ($review->rating == 4)
              <input type="radio" id="star4"  value="4" checked disabled><label for="star4" title="Хорошо">4 stars</label>
              @else
              <input type="radio" id="star4"  value="4" disabled><label for="star4" title="Хорошо">4 stars</label>
              @endif
              @if ($review->rating == 3)
              <input type="radio" id="star3"  value="3" checked disabled><label for="star3" title="Удовлетворительно">3 stars</label>
              @else
              <input type="radio" id="star3"  value="3" disabled><label for="star3" title="Удовлетворительно">3 stars</label>
              @endif
              @if ($review->rating == 2)
              <input type="radio" id="star2"  value="2" checked disabled><label for="star2" title="Плохо">2 stars</label>
              @else
              <input type="radio" id="star2"  value="2" disabled><label for="star2" title="Плохо">2 stars</label>
              @endif
              @if ($review->rating == 1)
              <input type="radio" id="star1"  value="1" checked disabled><label for="star1" title="Отвратительно">1 star</label> 
              @else
              <input type="radio" id="star1"  value="1" disabled><label for="star1" title="Отвратительно">1 star</label> 
              @endif
            </div>
          </div>
          <div class="clearfix"></div>
          <p class="card-description">
            {{ $review->description }}
          </p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
</div>

<div class="col-md-4 col-sm-6">
  <div class="row">
    <div class="col-md-6">
              <div class="card" data-background="color" data-color="green">
                <div class="card-block text-center black-text-card">
                  <div class="card-icon">
                    <i class="fa fa-percent"></i>
                  </div>
                  <h4 class="card-title">{{ $partner->default_discount }} %</h4>
                  <p class="card-description">Скидка</p>
                </div>
              </div>
    </div>
        <div class="col-md-6">
              <div class="card" data-background="color" data-color="green">
                <div class="card-block text-center black-text-card">
                  <div class="card-icon">
                    <i class="nc-icon nc-money-coins"></i>
                  </div>
                  <h4 class="card-title">{{ $partner->default_cashback }} %</h4>
                  <p class="card-description">Кэшбэк</p>
                </div>
              </div>
    </div>
  </div>
<div id="geocoding-block" onload="initialize()">
  @isset($addresses)
  @foreach ($addresses as $address)
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">{{ $address->name }}</h5>
      <div id="partner-address-map-{{ $address->id }}" class="mini-map">

      </div>
      <p><i class="fa fa-map-marker"></i>{{ $address->text }} @isset($address->comment) ({{ $address->comment }}) @endisset</p>
      <p><i class="fa fa-calendar"></i>{{ $address->schedule }}</p>
      <p><i class="fa fa-mobile"></i>{{ $address->phones }}</p>
    </div>
  </div> <!-- end card -->
  @endforeach
  @endisset
</div>
</div>
</div>
<script type="text/javascript">
  function initMap() {
    var styleArray = [
    {
      featureType: 'all',
      stylers: [
      { saturation: -80 }
      ]
    },{
      featureType: 'road.arterial',
      elementType: 'geometry',
      stylers: [
      { hue: '#00ffee' },
      { saturation: 50 }
      ]
    },{
      featureType: 'poi.business',
      elementType: 'labels',
      stylers: [
      { visibility: 'off' }
      ]
    }
    ];
    @foreach ( $addresses as $address )
    var map{{ $address->id }} = new google.maps.Map(document.getElementById("partner-address-map-{{ $address->id }}"), {
      zoom: 14,
      mapTypeControl: false,
      styles: styleArray,
      center: {lat: {{ $address->latitude }}, lng: {{ $address->longitude }} }
    });
    var marker{{ $address->id }} = new google.maps.Marker({
      position: {lat: {{ $address->latitude }}, lng: {{ $address->longitude }} },
      map: map{{ $address->id }}
    });
    @endforeach
  }

</script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsfO8qFpSStho6O8-HQwpZEkaOv1ynK5A&callback=initMap"></script>
</div>
</div>
</div>
</div>
@endsection