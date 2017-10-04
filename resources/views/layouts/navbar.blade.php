<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Projects <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('projects.index') }}">All Projects</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('projects.create') }}">Create Project</a></li>
                    </ul>
                </li>
                @admin
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Goals <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('goals.index') }}">All Goals</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('goals.create') }}">Create Goal</a></li>
                    </ul>
                </li>
                @endadmin
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Issues <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('issues.index') }}">All Issues</a></li>
                        <li><a href="{{ route('issues.index',['assign_to'=>auth()->id()]) }}">Assigned to me</a></li>
                        <li><a href="{{ route('issues.index',['reported_by'=>auth()->id()]) }}">Reported by me</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('issues.create') }}">Create Issue</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Work Logs <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('work-logs.index') }}">All Work Logs</a></li>
                        <li><a href="{{ route('work-logs.timesheet') }}">Timesheet</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('work-logs.create') }}">Create Work Log</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Users <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('users.index') }}">All</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('users.create') }}">Create User</a></li>
                    </ul>
                </li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@if(auth()->check())
    <quick-issues></quick-issues>
@endif