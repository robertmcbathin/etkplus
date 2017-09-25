        <div class="sidebar" data-background-color="brown" data-active-color="danger">
            <div class="logo">
                <a href="/" class="simple-text logo-mini">
                    ЕТК+
                </a>

                <a href="/" class="simple-text logo-normal">
                    ЕТКплюс
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="info">
                        <div class="photo">
                            <img src="https://etk21.ru/{{ Auth::user()->profile_image }}" />
                        </div>

                        <a data-toggle="collapse" href="#logout" class="collapsed">
                            <span>
                                {{ Auth::user()->name }}
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse" id="logout">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <span class="sidebar-normal">Выход</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav" id="sidebar-nav">
                @can('show-dashboard-admin')
                    <li class="active">
                        <a data-toggle="collapse" href="#dashboardOverview">
                            <i class="fa fa-bars"></i>
                            <p>Панель управления
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse in" id="dashboardOverview">
                            <ul class="nav">
                                <li class="active">
                                    <a href="overview.html">
                                        <span class="sidebar-mini">Ст</span>
                                        <span class="sidebar-normal">Статистика</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#partners">
                            <i class="fa fa-building"></i>
                            <p>Предприятия
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="partners">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('dashboard.create-partner.get') }}">
                                        <span class="sidebar-mini">Н</span>
                                        <span class="sidebar-normal">Новое</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.show-partner-list.get') }}">
                                        <span class="sidebar-mini">Сп</span>
                                        <span class="sidebar-normal">Список</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#users">
                            <i class="fa fa-credit-card"></i>
                            <p>Карты
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="users">
                            <ul class="nav">

                                <li>
                                    <a href="{{ route('dashboard.show-user-list.get') }}">
                                        <span class="sidebar-mini">Сп</span>
                                        <span class="sidebar-normal">Список</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="l#componentsExamples">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="componentsExamples">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('dashboard.show-visits-list.get') }}">
                                        <span class="sidebar-mini">Сп</span>
                                        <span class="sidebar-normal">Список</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../components/grid.html">
                                        <span class="sidebar-mini">GS</span>
                                        <span class="sidebar-normal">Grid System</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('show-dashboard-partner')
                    <li @if (Request::path() == 'dashboard') class="active" @endif>
                        <a data-toggle="collapse" href="#dashboardOverview">
                            <i class="fa fa-bars"></i>
                            <p>Панель управления
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse @if (Request::path() == 'dashboard') in @endif" id="dashboardOverview">
                            <ul class="nav">
                                <li @if (Request::path() == 'dashboard') class="active" @endif>
                                    <a href="overview.html">
                                        <span class="sidebar-mini">О</span>
                                        <span class="sidebar-normal">Обзор</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li @if (Request::path() == 'dashboard') class="active" @endif>
                        <a data-toggle="collapse" href="#partners">
                            <i class="fa fa-building"></i>
                            <p>Операции 
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="partners">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('dashboard.partner.create-operation.get') }}">
                                        <span class="sidebar-mini">С</span>
                                        <span class="sidebar-normal">Создать</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.partner.show-operations.get') }}">
                                        <span class="sidebar-mini">И</span>
                                        <span class="sidebar-normal">История</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('show-dashboard-partner-admin')
                    <li @if (Request::path() == 'dashboard/show-operators') class="active" @endif >
                        <a data-toggle="collapse" href="#operators">
                            <i class="fa fa-user"></i>
                            <p>Операторы
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse @if (Request::path() == 'dashboard/show-operators') in @endif" id="operators">
                            <ul class="nav">
                                <li @if (Request::path() == 'dashboard/show-operators') class="active" @endif>
                                    <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                                        <span class="sidebar-mini">Сп</span>
                                        <span class="sidebar-normal">Список операторов</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                <li>
                        <a href="../calendar.html">
                            <i class="ti-calendar"></i>
                            <p>Calendar</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>