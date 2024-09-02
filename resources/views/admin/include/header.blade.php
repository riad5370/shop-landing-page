<div id="navbar" class="navbar navbar-default          ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="index.html" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    Processing........
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        @if(Auth()->user()->image == null)
                            <img class="nav-user-photo" src="{{ Avatar::create(Auth()->user()->name)->toBase64() }}" />
                        @else
                           <img class="nav-user-photo" src="{{asset('images/user/'.Auth()->user()->image)}}" alt="Jason's Photo" />
                        @endif
                        <span class="user-info">
                            <small>Welcome,</small>
                        {{Auth()->user()->name}}
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="javascript:;" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit()">
                                <i class="ace-icon fa fa-power-off"></i>
                                <span>Log Out</span>
                                <form action="{{route('logout')}}" id="logout-form" method="post">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>