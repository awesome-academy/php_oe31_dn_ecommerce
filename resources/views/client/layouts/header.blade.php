<header class="header bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="{{ route('client.home.index') }}">
                <img src="{{ asset('storage/logo.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.products.index') }}">
                            {{ trans('custome.products') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            {{ trans('custome.sale') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            {{ trans('custome.trend') }}
                        </a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" aria-label="Search">
                    <button class="btn btn-template my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <ul class="navbar-nav">
                    @if (auth()->check())
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cart-arrow-down"></i> {{ trans('custome.cart') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.logout') }}">
                                <i class="fas fa-sign-out-alt"></i> {{ trans('custome.sign_out') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.login.get') }}">
                                <i class="fas fa-sign-in-alt"></i> {{ trans('custome.sign_in') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.register.get') }}">
                                <i class="fas fa-user-plus"></i> {{ trans('custome.sign_up') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
