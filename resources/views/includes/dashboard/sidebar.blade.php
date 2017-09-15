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

                        <a data-toggle="collapse" href="" class="collapsed">
                            <span>
                                {{ Auth::user()->name }}
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse" id="collapseExample">
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
                <ul class="nav">
                @can('show-dashboard-admin')
                    <li class="active">
                        <a data-toggle="collapse" href="overview.html#dashboardOverview">
                            <i class="fa fa-bars"></i>
                            <p>Панель управления
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse in" id="dashboardOverview">
                            <ul class="nav">
                                <li class="active">
                                    <a href="overview.html">
                                        <span class="sidebar-mini">С</span>
                                        <span class="sidebar-normal">Статистика</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="/dashboard#partners">
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
                        <a data-toggle="collapse" href="overview.html#componentsExamples">
                            <i class="fa fa-credit-card"></i>
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
                    <li>
                        <a data-toggle="collapse" href="overview.html#formsExamples">
                            <i class="ti-clipboard"></i>
                            <p>
                                Forms
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="formsExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../forms/regular.html">
                                        <span class="sidebar-mini">Rf</span>
                                        <span class="sidebar-normal">Regular Forms</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../forms/extended.html">
                                        <span class="sidebar-mini">Ef</span>
                                        <span class="sidebar-normal">Extended Forms</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../forms/validation.html">
                                        <span class="sidebar-mini">Vf</span>
                                        <span class="sidebar-normal">Validation Forms</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../forms/wizard.html">
                                        <span class="sidebar-mini">W</span>
                                        <span class="sidebar-normal">Wizard</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="overview.html#tablesExamples">
                            <i class="ti-view-list-alt"></i>
                            <p>
                                Table list
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="tablesExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../tables/regular.html">
                                        <span class="sidebar-mini">RT</span>
                                        <span class="sidebar-normal">Regular Tables</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../tables/extended.html">
                                        <span class="sidebar-mini">ET</span>
                                        <span class="sidebar-normal">Extended Tables</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../tables/bootstrap-table.html">
                                        <span class="sidebar-mini">BT</span>
                                        <span class="sidebar-normal">Bootstrap Table</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../tables/datatables.net.html">
                                        <span class="sidebar-mini">DT</span>
                                        <span class="sidebar-normal">DataTables.net</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="overview.html#mapsExamples">
                            <i class="ti-map"></i>
                            <p>
                                Maps
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="mapsExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../maps/google.html">
                                        <span class="sidebar-mini">GM</span>
                                        <span class="sidebar-normal">Google Maps</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../maps/vector.html">
                                        <span class="sidebar-mini">VM</span>
                                        <span class="sidebar-normal">Vector maps</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../maps/fullscreen.html">
                                        <span class="sidebar-mini">FSM</span>
                                        <span class="sidebar-normal">Full Screen Map</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="../charts.html">
                            <i class="ti-bar-chart-alt"></i>
                            <p>Charts</p>
                        </a>
                    </li>
                    <li>
                        <a href="../calendar.html">
                            <i class="ti-calendar"></i>
                            <p>Calendar</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="overview.html#pagesExamples">
                            <i class="ti-gift"></i>
                            <p>
                                Pages
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="pagesExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../pages/timeline.html">
                                        <span class="sidebar-mini">TP</span>
                                        <span class="sidebar-normal">Timeline Page</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../pages/user.html">
                                        <span class="sidebar-mini">UP</span>
                                        <span class="sidebar-normal">User Page</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../pages/login.html">
                                        <span class="sidebar-mini">LP</span>
                                        <span class="sidebar-normal">Login Page</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../pages/register.html">
                                        <span class="sidebar-mini">RP</span>
                                        <span class="sidebar-normal">Register Page</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../pages/lock.html">
                                        <span class="sidebar-mini">LSP</span>
                                        <span class="sidebar-normal">Lock Screen Page</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>