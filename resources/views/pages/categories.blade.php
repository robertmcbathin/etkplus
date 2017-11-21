@extends('layouts.categories')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Партнерская сеть
@endsection
@section('content')
<div class="header-wrapper">

    <div class="page-header page-header-xs " id="categories-page-header" style="background-image: url('../assets/img/sections/etkplus-bg2.jpg');">
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
    <div class="content-center" id="categories-page-text">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-auto mr-auto text-center">
                    <h2>Партнеры, подключенные к системе</h2>
              </div>
          </div>
      </div>
  </div>
</div>

</div>
</div>
    <div class="content-center" id="categories-page-text">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-auto mr-auto text-center">
                    <h2 class="discover-title"><small>Поищите что-нибудь</small></h2>
                  <div class="input-group">
                      <input type="text" placeholder="" class="form-control" id="categories-search-input">
                      <span class="input-group-addon"><i class="fa fa-search"></i></span>
                  </div>  
              </div>
          </div>
      </div>
  </div>
<br>

<div class="container" id="categories-partners-search">
    <div class="info-areas">
        <div class="row">
    </div>
</div>

</div>


<div class="container" id="categories-list">
    <div class="info-areas">
        <div class="row">
            @foreach ($categories as $category)
            <div class="col-md-3">
               <div class="info">
                <div class="icon">
                    <a href="{{ route('site.show-category.get', ['id' => $category->id]) }}">
                        <i class="material-icons">{{ $category->icon }}</i>
                    </a>
                </div>
                <div class="description">
                    <a href="{{ route('site.show-category.get', ['id' => $category->id]) }}">
                        <h4 class="info-title"> {{ $category->name }} </h4>
                    </a>
                    <p>{{ $category->description }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</div>


</div>
<script type="text/javascript">
  var searchInCategoriesUrl = '{{ route('ajax.search-in-categories') }}';
</script>
@endsection