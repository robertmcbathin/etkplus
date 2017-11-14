@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
ЕТКплюс
@endsection
@section('content')
<div class="header-wrapper">

    <div class="page-header page-header-small" id="index-page-header">
<div class="masthead segment">
  <div class="ui page grid">
    <div class="column">
      <div class="introduction">
        <h1 class="ui inverted header">
          
        </h1>        
        <div class="ui hidden divider"></div>        
      </div>      
    </div>
  </div>
  <div class="content-center" id="index-page-text">
      <div class="container">
          <div class="row">
              <h2>Участвуйте в системе и сделайте проезд еще более выгодным!</h2>
          </div>
      </div>
  </div>
</div>
    <!--    <div class="filter filter-danger"></div>
        <div class="content-center">
            <div class="container">
                <div class="row">
                    <div class="float-card-container">
                        <div class="float-icons-container">
                            <div class="float-card">
                                <i class="fa fa-percent fa-3x"></i>
                            </div>

                            <div class="float-card-gift">
                                <i class="fa fa-gift fa-3x"></i>
                            </div>

                            <div class="float-card-ruble">
                                <i class="fa fa-ruble fa-3x"></i>
                            </div>
                        </div>
                        <img src="/images/lying-card-white.png" class="lying-card" alt="">
                    </div>
                <!--    <div class="col-md-6 text-left">
                        <h2 class="presentation-title">ЕТКплюс</h1>
                        <h5 class="presentation-subtitle">Участвуйте в системе, получайте скидки и бонусы от партнеров программы лояльности и кэшбэк на транспортную карту!</h5>
                        <br>
                    </div> 
                </div>
            </div>
        </div>

    -->
    </div>
</div>
<div class="wrapper">
    <div id="fadeInAnim">
        <div class="section section-content section-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto text-center">
                        <h2 class="title">Совсем скоро</h2>
                        <h6 class="category">Для держателей ВСЕХ карт ЕТК</h6>
                        <h5 class="description text-center">Уже в ближайшее время карту ЕТК можно будет пополнить онлайн. Почему бы не сделать пополнение еще более удобным? Например, если карта будет пополняться автоматически...</h5>
                        <br>
                            <a href="/about" class="btn btn-danger btn-fill">О проекте</a>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
        </div>
    </div>
   <!-- <div class="section">
        <div class="container">
            <h3>Новые партнеры в нашей сети</h3>
            <br>
            <div class="row items-row">
                @foreach ($partners as $partner)
                <div class="col-md-4  col-sm-4">
                    <div class="card card-plain">

                        <div class="card-image">
                            <a href="{{ route('site.show-partner.get',['id' => $partner->id]) }}">
                                <img src="{{ $partner->thumbnail }}" alt="{{ $partner->name }}" class="img-rounded img-responsive">
                            </a>
                            <div class="card-block">
                                <a href="{{ route('site.show-partner.get',['id' => $partner->id]) }}">
                                    <div class="author">
                                        <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="img-circle img-no-padding img-responsive img-raised">
                                    </div>
                                    <span class="name">{{ $partner->name }}</span>
                                </a>
                                <div class="meta"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div> -->
</div>
</div>
@endsection