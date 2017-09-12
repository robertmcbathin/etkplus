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

<div class="page-header page-header-small filter pattern-image" style="background-image: url('../assets/img/etkplus-bg.jpg');">
            <div class="filter filter-danger"></div>
            <div class="content-center">
                <div class="container">
                    <h2 class="presentation-subtitle text-center">Крутой слоган</h2>
                </div>
            </div>
        </div>
</div>
<div class="wrapper">
        <div class="section">
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
        </div>
</div>
</div>
@endsection