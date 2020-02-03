@extends('client.layouts.master')

@section('title', $product->name)

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12 col-lg-7 order-sm-2 order-lg-1">
                <div class="product-img">
                    <div id="carouselProductImg" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="w-100 h-auto img-thumbnail"
                                    src="{{ asset(config('custome.link_img_product') . $product->first_image->name) }}"
                                    alt="{{ $product->first_image->name }}">
                            </div>
                            @foreach ($product->images as $img)
                                <div class="carousel-item">
                                    <img class="w-100 h-auto img-thumbnail"
                                        src="{{ asset(config('custome.link_img_product') . $img->name) }}"
                                        alt="{{ $img->name }}">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselProductImg" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">{{ trans('custome.previous') }}</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselProductImg" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">{{ trans('custome.next') }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 order-sm-1 order-lg-2 py-3">
                <div class="product-content">
                    <div class="name pb-3">
                        <p class="mb-0">{{ $product->name }}</p>
                    </div>
                    <div class="price-box py-3">
                        <p class="mb-0">
                            @if ($product->sale_price != null)
                                <span class="price-strike pr-2"><strike>{{ convertVnd($product->price) }}</strike></span>
                                <span class="price-sale pr-2">{{ convertVnd($product->sale_price) }}</span>
                            @else
                                <span class="price pr-2">{{ convertVnd($product->price) }}</span>
                            @endif
                            @if ($product->sale_percent != null)
                                <span class="sale-percent">{{ "-" . $product->sale_percent . "%" }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="status py-3">
                        <p class="mb-0 text-capitalize">
                            <b>
                                @if ($product->quantity > config('custome.count_item'))
                                    {{ trans('validation.attributes.available') }}:
                                    <span class="text-primary">{{ $product->quantity }}</span>
                                @else
                                    <span class="text-danger">{{ trans('validation.attributes.not_available') }}</span>
                                @endif
                            </b>
                        </p>
                    </div>
                    @if ($product->description != null)
                        <div class="description py-3">
                            <p class="mb-0 text-capitalize">
                                <b>{{ trans('validation.attributes.description') }}:</b>
                            </p>
                            <p class="mb-0">{{ $product->description }}</p>
                        </div>
                    @endif
                    @if ($product->quantity > config('custome.count_item'))
                        <div class="action py-3 text-center">
                            <a class="btn btn-template my-2 my-sm-0 w-50"
                                href="{{ route('client.cart.add', ['id' => $product->id]) }}">
                                {{ trans('custome.add_to_cart') }}
                            </a>
                        </div>
                    @endif
                    <div class="rating pt-3">
                        <div class="title">
                            <h5 class="mb-0">{{ trans('custome.rating') }}</h5>
                            @if (session('ratingSuccess'))
                                <div class="alert alert-success mb-0 my-2" role="alert">
                                    {{ session('ratingSuccess') }}
                                </div>
                            @endif
                            @if (session('notRating'))
                                <div class="alert alert-danger mb-0 my-2" role="alert">
                                    {{ session('notRating') }}
                                </div>
                            @endif
                        </div>
                        <div class="box-rate">
                            <form action="{{ route('client.products.rating', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                @if ($errors->has('star_number'))
                                    <p class="mb-0 text-danger">{{ $errors->first('star_number') }}</p>
                                @endif
                                <div class="star_number">
                                    <input type="radio" id="star5" name="star_number" class="fas fa-star"
                                        value="{{ config('custome.star_number_5') }}">
                                    <label for="star5" title="text"></label>
                                    <input type="radio" id="star4" name="star_number" class="fas fa-star"
                                        value="{{ config('custome.star_number_4') }}">
                                    <label for="star4" title="text"></label>
                                    <input type="radio" id="star3" name="star_number" class="fas fa-star"
                                        value="{{ config('custome.star_number_3') }}">
                                    <label for="star3" title="text"></label>
                                    <input type="radio" id="star2" name="star_number" class="fas fa-star"
                                        value="{{ config('custome.star_number_2') }}">
                                    <label for="star2" title="text"></label>
                                    <input type="radio" id="star1" name="star_number" class="fas fa-star"
                                        value="{{ config('custome.star_number_1') }}">
                                    <label for="star1" title="text"></label>
                                </div>
                                <div>
                                    <button class="btn btn-template ml-2" type="submit">{{ trans('custome.rating') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8 pt-3">
                @if ($product->ratings->count() > config('custome.count_item'))
                    <h4>{{ trans('custome.list_rating') }}</h4>
                    @foreach ($product->ratings as $rt)
                        <div class="list-cmt-item py-2">
                            <div class="user-name">
                                <p class="mb-0">
                                    {{ $rt->user->name }} - <span>{{ $rt->created_at }}</span>
                                </p>
                            </div>
                            <div class="content">
                                <p class="mb-0">
                                    @for ($i = 0; $i < $rt->star_number; $i++)
                                        <i class="star-yellow fas fa-star"></i>
                                    @endfor
                                    @for ($i = 0; $i < config('custome.star_number_5') - $rt->star_number; $i++)
                                        <i class="star-white fas fa-star"></i>
                                    @endfor
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>{{ trans('custome.no_rating') }}</h4>
                @endif
            </div>
            <div class="col-12 pt-3">
                @if ($product->comments->count() > config('custome.count_item'))
                    <h4>{{ trans('custome.list_comments') }}</h4>
                    @foreach ($product->comments as $cmt)
                        <div class="list-cmt-item py-2">
                            <div class="user-name">
                                <p class="mb-0">
                                    {{ $cmt->user->name }} - <span>{{ $cmt->created_at }}</span>
                                </p>
                            </div>
                            <div class="content">
                                <p class="mb-0">{{ $cmt->content }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>{{ trans('custome.no_comments') }}</h4>
                @endif
            </div>
            <div class="col-12 pt-3">
                <div class="form-box">
                    <form action="{{ route('client.products.comment', ['id' => $product->id]) }}" method="POST">
                        @csrf
                        <h4 class="mb-0 pb-2 text-capitalize">{{ trans('custome.comment') }}</h4>
                        @if (session('status'))
                            <div class="alert alert-danger mb-0 mt-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-body">
                            <div class="form-group">
                                <label for="content">
                                    {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.content')]) }}
                                </label>
                                @if ($errors->has('content'))
                                    <p class="mb-0 text-danger">{{ $errors->first('content') }}</p>
                                @endif
                                <textarea type="text" name="content" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-footer text-center">
                            <button type="submit" class="btn btn-template text-capitalize">{{ trans('custome.comment') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
