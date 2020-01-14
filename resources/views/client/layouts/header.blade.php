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
                    <li class="nav-item category">
                        <a class="nav-link" href="{{ route('client.products.index') }}">
                            {{ trans('custome.products') }}
                        </a>
                        <ul class="sub-category">
                            @foreach ($categories as $category)
                                @if (sizeof($category->children) > config('custome.count_category'))
                                    <li>
                                        <a href="{{ route('client.category.detail', ['id' => $category->id]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                    @foreach ($category->children as $submenu)
                                        <ul>
                                            <li>
                                                <a href="{{ route('client.category.detail', ['id' => $submenu->id]) }}">
                                                    {{ $submenu->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                @elseif ($category->parent_id == null)
                                    <li>
                                        <a href="{{ route('client.category.detail', ['id' => $category->id]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <ul>

                        </ul>
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
                <ul class="navbar-nav">
                    @if (auth()->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.cart.index') }}">
                                <i class="fas fa-cart-arrow-down"></i>
                                @if (session()->has('cart'))
                                    {{ trans('custome.cart') }}
                                    <b class="text-danger">
                                        {{ "(" . count(session()->get('cart')->items) . ")" }}
                                    </b>
                                @else
                                    {{ trans('custome.cart') }}
                                @endif
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
