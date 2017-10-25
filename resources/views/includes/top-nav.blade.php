    <nav class="navbar navbar-toggleable-md fixed-top navbar-transparent" color-on-scroll="300">
        <div class="container">
            <div class="navbar-translate">
                <button class="navbar-toggler navbar-toggler-right navbar-burger" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                </button>
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">ЕТКплюс</a>
                </div>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/about" data-scroll="true" href="javascript:void(0)">О проекте</a>
                    </li>
                    <li class="nav-item dropdown dropdown-danger">
                        <a class="nav-link dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0)">Партнерская сеть</a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-danger">
                            @foreach ($categories as $category)
                            <li class="dropdown-item"><a href="{{ route('site.show-category.get', ['id' => $category->id]) }}"><i class="material-icons">{{ $category->icon }}</i>&nbsp; {{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-round btn-danger" href="{{ route('login') }}"><i class="fa fa-user-circle"></i>Личный кабинет</a>
                    </li>
                    @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" data-scroll="true" href="javascript:void(0)">Выйти</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>