@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ Auth::user()->name }}
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
          <img src="https://etk21.ru{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}" class="img-circle img-responsive">
        </div>

        <div class="name">
          <h4>{{ Auth::user()->name }}</h4>
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

    <!-- PROFILE TABS -->
    <div class="profile-tabs">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <ul id="tabs" class="nav nav-tabs" role="tablist">
            <li class="nav-item ">
              <a class="nav-link active" href="#visits" data-toggle="tab" role="tab">Лента</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#bonuses" data-toggle="tab" role="tab">Бонусы</a>
            </li>
          </ul>
        </div>
      </div>

      <div id="my-tab-content" class="tab-content">
        <div class="tab-pane active" id="visits" role="tabpanel">
          <div class="row">
            <div class="col-md-8">
              <div class="tweets">

                @foreach ($visits as $visit)
                <div class="media">
                  <a class="pull-left" href="{{route('site.show-partner.get', $visit->partner_id) }}">
                   <div class="avatar">
                    <img class="media-object" src="{{ $visit->logo }}" alt="{{ $visit->name }}" alt="">
                  </div>
                </a>
                <div class="media-body">
                  <strong>{{ $visit->name }}</strong>
                  <h5 class="media-heading"><small>{{ $visit->created_at }}</small></h5>
                  <p><span data-toggle="tooltip" data-placement="bottom" data-original-title="Счет со скидкой"><i class="fa fa-file"></i> <b>{{ $visit->bill_with_discount }} р.</b></span>
                   <span data-toggle="tooltip" data-placement="bottom" data-original-title="Скидка"><i class="fa fa-percent"></i> <b>{{ $visit->discount }} р.</b></span>
                   <span data-toggle="tooltip" data-placement="bottom" data-original-title="Бонус"><i class="fa fa-gift"></i> <b>{{ $visit->bonus }} р.</b></span>
                   <span data-toggle="tooltip" data-placement="bottom" data-original-title="Кэшбэк на транспортную карту"><i class="fa fa-money"></i> <b>{{ $visit->cashback }} р.</b></p></span>

                   <div class="media-footer">
                    @if ($visit->is_reviewed == 0)
                    <button class="btn btn-link" data-toggle="modal" data-target="#leave-review-{{ $visit->id }}">
                     Оставить отзыв <i class="fa fa-reply"></i>
                   </button>
                   @elseif ($visit->is_reviewed == 1)
                   <button class="btn btn-link">
                     Отзыв оставлен
                   </button>
                   @endif
                 </div>

               </div>
             </div> <!-- end media -->
             @endforeach
           </div>
           <br>
           <div class="row">
            <div class="text-center">
              <?php echo $visits->render(); ?>
            </div>
          </div>
  

        </div>
        <div class="col-md-4 col-sm-6">
          <div class="card card-with-shadow">
            <div class="card-block">
              <h5 class="card-title">Кэшбэк </h5>
              <hr>
              <small class="muted">Ожидает зачисления</small>
              <div class="accounts-suggestion">
                @foreach ($cashbacks as $cashback)
                <p><i class="fa fa-credit-card"></i>{{ $cashback->num }} <b class="pull-right">{{ $cashback->cashback_to_pay }}<i class="fa fa-ruble"></i> </b></p>
                @endforeach
              </div>
              <hr>
              <small class="muted">Зачислено ранее</small>
              <div class="accounts-suggestion">
                @foreach ($cashbacks as $cashback)
                <p><i class="fa fa-credit-card"></i>{{ $cashback->num }} <b class="pull-right">{{ $cashback->cashback_payed }}<i class="fa fa-ruble"></i> </b></p>
                @endforeach
              </div>
              <blockquote class="blockquote"><p class="mb-0">Суммы зачисляются ежедневно автоматически</p></blockquote>

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

      <div class="tab-pane text-center" id="bonuses" role="tabpanel">
       <div class="col-md-8 offset-md-2">
                    @isset($bonuses)
                    <div class="table-responsive">
                    <table class="table">
                        <tbody>
                          @foreach ($bonuses as $bonus)
                            <tr>
                                <td><img src="{{ $bonus->logo }}" alt="" width="60px" height="60px"></td>
                                <td>{{ $bonus->name }}</td>
                                <td><i class="fa fa-credit-card"></i>{{ $bonus->card_number }}</td>
                                <td class="text-right">{{ $bonus->value }}<i class="fa fa-ruble"></i></td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                    </div>
                    @endisset

                </div> 

      </div>

    </div>

  </div>


</div>
</div>
</div>
@endsection
@foreach ($visits as $visit)
<div class="modal fade" id="leave-review-{{ $visit->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Оставить отзыв</h5>
        <a class="text-center" href="{{route('site.show-partner.get', $visit->partner_id) }}" target="_blank">
         <div class="avatar">
          <img class="media-object" src="{{ $visit->logo }}" alt="{{ $visit->name }}" width="60px" height="60px" alt="">
        </div>
        <strong>{{ $visit->name }}</strong>
      </a>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body"> 
      <p class="description">
        Оставив отзыв о посещении данной организации, Вы поможете другим пользователям сформировать впечатление о ней, а также возможность получать дополнительные бонусы от этой организации в дальнейшем
      </p>


      <form action="{{ route('profile.leave-review.post') }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="partner_id" value="{{ $visit->partner_id }}">
        <input type="hidden" name="visit_id" value="{{ $visit->id }}">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Общее впечатление" name="review_title" minlength="1" maxlength="50">
        </div>
        <textarea class="form-control" placeholder="Напишите что-нибудь хорошее или не очень" rows="6" name="review_description" minlength="1" maxlength="4096"></textarea>
        <div class="text-center">
          <div class="rating"> 
            <input type="radio" id="star5-{{ $visit->id }}" name="rating" required value="5" ><label for="star5-{{ $visit->id }}" title="Отлично">5 stars</label>
            <input type="radio" id="star4-{{ $visit->id }}" name="rating" required value="4" ><label for="star4-{{ $visit->id }}" title="Хорошо">4 stars</label>
            <input type="radio" id="star3-{{ $visit->id }}" name="rating" required value="3" ><label for="star3-{{ $visit->id }}" title="Удовлетворительно">3 stars</label>
            <input type="radio" id="star2-{{ $visit->id }}" name="rating" required value="2" ><label for="star2-{{ $visit->id }}" title="Плохо">2 stars</label>
            <input type="radio" id="star1-{{ $visit->id }}" name="rating" required value="1" ><label for="star1-{{ $visit->id }}" title="Отвратительно">1 star</label> 
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="left-side">
          <button type="button" class="btn btn-default btn-link" data-dismiss="modal">В следующий раз</button>
        </div>
        <div class="divider"></div>
        <div class="right-side">
          <input type="submit" class="btn btn-success btn-link" value="Оставить отзыв" >
        </div>
      </div>
    </form>


  </div>
</div>
</div>
@endforeach