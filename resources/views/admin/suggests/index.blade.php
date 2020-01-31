@extends('admin.layouts.master')

@section('title', trans('custome.suggest'))

@section('meta-header')
    <meta name="confirmDeleteSuggest" content="{{ trans('custome.confirm_del_suggest') }}">
@endsection

@section('content')
    <div class="p-3">
        <table class="table table-striped table-suggest">
            <thead>
                <tr>
                    <th class="text-capitalize">{{ trans('validation.attributes.image') }}</th>
                    <th class="text-capitalize">{{ trans('custome.user') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.content') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.created_at') }}</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            @forelse ($suggests as $suggest)
                <tr>
                    <td>
                        <img src="{{ asset(config('custome.link_img_suggest') . $suggest->image) }}"
                            alt="{{ $suggest->name }}">
                    </td>
                    <td>
                        {{ $suggest->user->name }}
                    </td>
                    <td>
                        {{ $suggest->content }}
                    </td>
                    <td>{{ $suggest->created_at }}</td>
                    <td>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="{{ '#modalSuggest-' . $suggest->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ route('admin.suggest.delete', ['id' => $suggest->id]) }}"
                            class="btn btn-danger delete-suggest">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                    <td>
                        <div class="modal fade" id="{{ 'modalSuggest-' . $suggest->id }}"
                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-capitalize" id="exampleModalLabel">{{ trans('validation.attributes.image') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="w-100 img-thumbnail" src="{{ asset(config('custome.link_img_suggest') . $suggest->image) }}"
                                            alt="{{ $suggest->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">{{ trans('custome.no_suggests') }}</td>
                </tr>
            @endforelse
        </table>
    </div>
    <div class="pb-3">
        {!! $suggests->links() !!}
    </div>
@endsection
