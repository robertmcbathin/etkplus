@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $user->name }}
@endsection
@section('content')
<div class="wrapper">

  <div class="page-header page-header-xs filter pattern-image" style="background-image: url('/assets/img/etkplus-bg.jpg');">
    <div class="content-center">
    </div>
  </div>        
</div>
<div class="profile-content section-white-gray">
  <div class="container">
    <div class="row owner">
      <div class="col-md-2 offset-md-5 col-sm-4 offset-md-4 col-xs-6 offset-md-3 text-center">
        <div class="avatar">
          <img src="https://etk21.ru{{ $user->profile_image }}" alt="{{ $user->name }}" class="img-circle img-responsive">
        </div>

        <div class="name">
          <h4>{{ $user->name }}</h4>
        </div>
      </div>
    </div>
    @include('includes.notifications')
    <div class="row">
      <div class="col-md-6 offset-md-3 text-center">
        <div class="description-details">
          <ul class="list-unstyled">
          </ul>
        </div>
      </div>
    </div>
<div class="row">
  <div class="col-md-8">
    <div class="tweets">
      <h5 class="card-title">Последние отзывы</h5>

      @foreach ($reviews as $review)
      <div class="media">
        <a class="pull-left" href="{{route('site.show-partner.get', $review->partner_id) }}">
         <div class="avatar">
          <img class="media-object" src="{{ $review->logo }}" alt="{{ $review->name }}">
        </div>
      </a>
      <div class="media-body">
        <h5 class="media-heading">{{ $review->title }} <small>{{ $review->created_at }} </small></h5>
        <p>{{ $review->description }}</p>

        <div class="media-footer">
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
        </div>

      </div>
    </div> <!-- end media -->
    @endforeach

    <br>
  </div>

</div>
<div class="col-md-4 col-sm-6">
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Who to follow · <small><a href="javascript: void(0);" class="link-info">View all</a></small></h5>
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
</div>
</div>

</div>
</div>
</div>
@endsection
