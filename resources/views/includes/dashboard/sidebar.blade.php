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
                    <li @if (Request::path() == 'dashboard') class="active" @endif>
                        <a href="{{ route('dashboard.show-dashboard.get') }}">
                            <i class="fa fa-area-chart"></i>
                            <p>Панель управления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/show-operations') class="active" @endif>
                        <a href="{{ route('dashboard.show-operations.get') }}">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/partners/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-partner-list.get') }}">
                            <i class="fa fa-building"></i>
                            <p>Предприятия</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/cards/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-partner-list.get') }}">
                            <i class="fa fa-building"></i>
                            <p>Предприятия</p>
                        </a>
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
                    <li @if (Request::path() == 'control-panel') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-dashboard.get') }}">
                            <i class="fa fa-area-chart"></i>
                            <p>Панель управления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'control-panel/show-operations') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operations.get') }}">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/show-operators') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                            <i class="fa fa-money"></i>
                            <p>Оплата услуг</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/show-reviews') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-reviews.get') }}">
                            <i class="fa fa-comments"></i>
                            <p>Отзывы</p>
                        </a>
                    </li>

                @endcan
                @can('show-dashboard-partner-admin')
                    <li @if (Request::path() == 'control-panel/show-operators') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                            <i class="fa fa-user"></i>
                            <p>Операторы</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/show-operators') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                            <i class="fa fa-wrench"></i>
                            <p>Настройки</p>
                        </a>
                    </li>
                @endcan
                </ul>
            </div>
        </div>