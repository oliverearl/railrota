<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            {{-- Left Side --}}
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="{{ route('operations.calendar') }}" class="nav-link"><i class="fas fa-calendar-alt"></i> Calendar</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('operations.index') }}" class="nav-link"><i class="fas fa-train"></i> Operations</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link"><i class="fas fa-users"></i> Users</a>
                </li>
            </ul>
            @endauth

            {{-- Right Side --}}
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> {{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class='dropdown-item' href="{{ route('users.show', Auth::id()) }}"><i class="fas fa-user-circle"></i> View Profile</a>
                            <a class='dropdown-item' href="{{ route('users.edit', Auth::id()) }}"><i class="fas fa-edit"></i> Edit Profile</a>
                            @if (Auth::user()->isAdmin())
                                <a class='dropdown-item' href="{{ route('admin') }}"><i class="fas fa-tools"></i> Admin Dashboard</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
