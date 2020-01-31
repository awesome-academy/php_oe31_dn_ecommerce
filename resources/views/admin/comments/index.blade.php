@extends('admin.layouts.master')

@section('title', trans('custome.comment'))

@section('meta-header')
    <meta name="confirmDeleteComment" content="{{ trans('custome.confirm_del_comment') }}">
    <meta name="confirmActiveComment" content="{{ trans('custome.confirm_active_comment') }}">
    <meta name="confirmLockComment" content="{{ trans('custome.confirm_lock_comment') }}">
@endsection

@section('content')
    <div class="p-3">
        <table class="table table-striped table-comment">
            <thead>
            <tr>
                <th class="text-capitalize">{{ trans('custome.user') }}</th>
                <th class="text-capitalize">{{ trans('custome.products') }}</th>
                <th class="text-capitalize">{{ trans('validation.attributes.status') }}</th>
                <th class="text-capitalize">{{ trans('validation.attributes.content') }}</th>
                <th class="text-capitalize">{{ trans('validation.attributes.created_at') }}</th>
                <th class="text-capitalize">{{ trans('validation.attributes.updated_at') }}</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach ($comments as $cmt)
                <tr>
                    <td>
                        {{ $cmt->user->name }}
                    </td>
                    <td>
                        <a href="{{ route('client.products.detail', ['id' => $cmt->product->id]) }}">
                            <img src="{{ asset(config('custome.link_img_product') . $cmt->product->first_image->name) }}"
                                alt="{{ $cmt->product->name }}">
                        </a>
                    </td>
                    <td>
                        @switch($cmt->status)
                            @case(\App\Models\Comment::ACTIVE)
                                <span class="badge badge-primary p-2">{{ trans('custome.active') }}</span>
                            @break

                            @case(\App\Models\Comment::BLOCK)
                                <span class="badge badge-secondary p-2">{{ trans('custome.locked') }}</span>
                            @break
                        @endswitch
                    </td>
                    <td>
                        {{ $cmt->content }}
                    </td>
                    <td>
                        {{ $cmt->created_at }}
                    </td>
                    <td>
                        {{ $cmt->updated_at }}
                    </td>
                    <td>
                        @switch($cmt->status)
                            @case(\App\Models\Comment::ACTIVE)
                                <a href="{{ route('admin.comment.lock', ['id' => $cmt->id]) }}"
                                    class="btn btn-secondary lock-comment">
                                    <i class="fas fa-lock"></i>
                                </a>
                            @break

                            @case(\App\Models\Comment::BLOCK)
                                <a href="{{ route('admin.comment.active', ['id' => $cmt->id]) }}"
                                    class="btn btn-primary active-comment">
                                    <i class="fas fa-toggle-on"></i>
                                </a>
                            @break
                        @endswitch
                        <a href="{{ route('admin.comment.delete', ['id' => $cmt->id]) }}"
                           class="btn btn-danger delete-comment">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="d-flex justify-content-center pb-3">
        {{ $comments->links() }}
    </div>
@endsection

