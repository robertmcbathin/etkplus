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
            <li><i class="fa fa-link"></i> <a href="{{ $partner->site }}">{{ $partner->site }}</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="profile-tabs">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <ul id="tabs" class="nav nav-tabs" role="tablist">
            <li class="nav-item ">
              <a class="nav-link active" href="#about-partner" data-toggle="tab" role="tab">О партнере</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#reviews" data-toggle="tab" role="tab">Отзывы</a>
            </li>
          </ul>
        </div>
      </div>

      <div id="my-tab-content" class="tab-content">
        <div class="tab-pane active" id="about-partner" role="tabpanel">
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
    Отзывы
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
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Who to follow</h5>
      <div class="accounts-suggestion">
        <ul class="list-unstyled">
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/chet_faker_1.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                Chet Faker <a href="#paper-kit" class="text-muted">@chetfaker</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@banks</a> and <a href="#paper-kit" class="link-info">@rihanna</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/placeholder.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                John Green <a href="#paper-kit" class="text-muted">@johngreen</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@rihanna</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/drake.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                Drake <a href="#paper-kit" class="text-muted">@drake</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@chetfaker</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
        </ul>
      </div>

    </div>
  </div> <!-- end card -->
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Trends · <small><a href="javascript: void(0);" class="link-info">Change</a></small></h5>
      <div class="hashtag-suggestions">
        <ul class="list-unstyled">
          <li><a href="#paper-kit" class="link-danger">#JeSuisToujoursCharlie</a></li>
          <li><a href="#paper-kit">Oculus Rift</a></li>
          <li><a href="#paper-kit" class="link-danger">#CarenAndLarryAreNotReal</a></li>
          <li><a href="#paper-kit" class="link-danger">#Twitter10k</a></li>
          <li><a href="#paper-kit">EXCLUSIVE MOVE WITHINGTON</a></li>
          <li><a href="#paper-kit">London</a>
          </li><li><a href="#paper-kit">DJ Khaled Snapchat</a>
        </li></ul>
      </div>

    </div>
  </div> <!-- end card -->
</div>
</div>
</div>

<div class="tab-pane text-center" id="reviews" role="tabpanel">


  <div class="container">

    <div class="row">

      <div class="col">
        <div class="card" data-background="color" data-color="orange">
          <div class="card-block">
            <div class="author">
              <a href="">
               <img src="assets/img/faces/joe-gardner-2.jpg" alt="..." class="avatar img-raised">
               <span>Erik Johnson</span>
             </a>
           </div>
           <span class="category-social pull-right">
            <i class="fa fa-quote-right"></i>
          </span>
          <div class="clearfix"></div>
          <p class="card-description">
            "During the first selection of grant winners on the essential aspects, and the products are not burdened with non-essentials. Back to purity, back to simplicity. At best, it is self-explanatory."
          </p>
        </div>
      </div>
    </div>

      <div class="col-md-3 offset-md-1">
        <div class="card" data-background="color" data-color="orange">
          <div class="card-block">
            <div class="author">
              <a href="#pablo">
               <img src="assets/img/faces/joe-gardner-2.jpg" alt="..." class="avatar img-raised">
               <span>Erik Johnson</span>
             </a>
           </div>
           <span class="category-social pull-right">
            <i class="fa fa-quote-right"></i>
          </span>
          <div class="clearfix"></div>
          <p class="card-description">
            "During the first selection of grant winners on the essential aspects, and the products are not burdened with non-essentials. Back to purity, back to simplicity. At best, it is self-explanatory."
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card" data-background="color" data-color="green">
        <div class="card-block">
          <div class="author">
            <a href="#pablo">
             <img src="assets/img/faces/erik-lucatero-2.jpg" alt="..." class="avatar img-raised">
             <span>Erik Johnson</span>
           </a>
         </div>
         <span class="category-social pull-right">
          <i class="fa fa-quote-right"></i>
        </span>
        <div class="clearfix"></div>
        <p class="card-description">
          "The plan is to add additional flexibility in the future to allow applicants to make a case for how much money they actually need. Less, but better – because it concentrates on the essential aspects, and the products are not burdened with non-essentials..."
        </p>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card" data-background="color" data-color="yellow">
      <div class="card-block">
        <div class="author">
          <a href="#pablo">
           <img src="assets/img/faces/kaci-baum-2.jpg" alt="..." class="avatar img-raised">
           <span>Erik Johnson</span>
         </a>
       </div>
       <span class="category-social pull-right">
        <i class="fa fa-quote-right"></i>
      </span>
      <div class="clearfix"></div>
      <p class="card-description">
        "Simulation of many-body quantum systems with neural networks, and the products are not burdened with non-essentials. Back to purity, back to simplicity. At best, it is self-explanatory."
      </p>
    </div>
  </div>
</div>

  <div class="col-md-4 offset-md-1">
    <div class="card" data-background="color" data-color="blue">
      <div class="card-block">
        <div class="author">
          <a href="#pablo">
           <img src="assets/img/faces/clem-onojeghuo-2.jpg" alt="..." class="avatar img-raised">
           <span>Erik Johnson</span>
         </a>
       </div>
       <span class="category-social pull-right">
        <i class="fa fa-quote-right"></i>
      </span>
      <div class="clearfix"></div>
      <p class="card-description">
        "Machine learning for motion recognition and trajectory generation of human movement for rehabilitation with non-essentials. Back to purity, back to simplicity. At best, it is self-explanatory."
      </p>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="card" data-background="color" data-color="purple">
    <div class="card-block">
      <div class="author">
        <a href="#pablo">
         <img src="assets/img/faces/ayo-ogunseinde-2.jpg" alt="..." class="avatar img-raised">
         <span>Erik Johnson</span>
       </a>
     </div>
     <span class="category-social pull-right">
      <i class="fa fa-quote-right"></i>
    </span>
    <div class="clearfix"></div>
    <p class="card-description">
      "Less, but better – because it concentrates on the essential aspects, and the products are not burdened with non-essentials. Back to purity, back to simplicity. At best, it is self-explanatory. The entire AI Grant project reminds me of a cross between a Thiel Fellowship and a Kaggle competition."
    </p>
  </div>
</div>
</div>
</div>
</div>




@foreach ($reviews as $review)
<div class="media">
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
  <div class="media-body">
    <h5 class="media-heading">{{ $review->title }} <small>{{ $review->created_at }} </small></h5>
    <p>{{ $review->description }}</p>
  </div>
</div> <!-- end media -->
@endforeach
</div>


</div>
</div>
</div>
</div>
@endsection