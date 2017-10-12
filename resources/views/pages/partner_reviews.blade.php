@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Отзывы | {{ $partner->name }}
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
    <div class="profile-tabs">

      <div id="my-tab-content" class="tab-content">
        <div class="row">
          <div class="col-md-12">
  <div class="container">

    <div class="row">
      @foreach ($reviews as $review)
      <div class="media">
        <a class="pull-left" href="/profile/{{ $review->user_id }}">
          <div class="avatar">
            <img class="media-object" alt="64x64" src="https://etk21.ru{{ $review->profile_image }}">
          </div>
        </a>
        <div class="media-body">
          <h5 class="media-heading">
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
          </h5>
          <div class="pull-right">
            <h6 class="text-muted">{{ $review->created_at }}</h6>

          </div>
          <p>{{ $review->title }}</p>
          <p>{{ $review->description }}</p>
        </div>
      </div>
    @endforeach
  </div>
                <br>
              <div class="row">
                            <div class="text-center">
                <?php echo $reviews->render(); ?>
            </div>
              </div>
</div>
</div>

</div>

</div>
</div>
</div>
</div>
@endsection