@extends('admin.layouts.master')

@section('title', trans('custome.category'))

@section('meta-header')
    <meta name="confirmDeleteCate" content="{{ trans('custome.confirm_del_category') }}">
@endsection

@section('content')
    <div class="p-3">
        <table class="table table-striped table-order">
            <thead>
                <tr>
                    <th class="text-capitalize">{{ trans('validation.attributes.name') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.description') }}</th>
                    <th class="text-capitalize">{{ trans('custome.parent') }}</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($categories as $category)
                <tr>
                    <td>
                        {{ $category->name }}
                    </td>
                    <td>{{ $category->description }}</td>
                    <td>
                        @if ($category->parent != null)
                            {{ $category->parent->name }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.show', ['id' => $category->id]) }}"
                            class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.category.delete', ['id' => $category->id]) }}"
                            class="btn btn-danger delete-category">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="d-flex justify-content-center pb-3">
        {{ $categories->links() }}
    </div>
@endsection

