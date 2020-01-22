@extends('admin.layouts.master')
@section('title', trans('custome.user'))

@section('meta-header')
    <meta name="confirmLockUser" content="{{ trans('custome.confirm_lock_user') }}">
    <meta name="confirmActiveUser" content="{{ trans('custome.confirm_active_user') }}">
@endsection

@section('content')
    <div class="p-3">
        <table class="table table-striped table-cart">
            <thead>
                <tr>
                    <th class="text-capitalize">{{ trans('validation.attributes.name') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.phone') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.email') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.gender') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.birthdate') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.address') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.city') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($users as $user)
                <tr>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->phone }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td class="text-capitalize">
                        @if ($user->gender == \App\Models\User::MALE)
                            {{ trans('validation.attributes.male') }}
                        @else
                            {{ trans('validation.attributes.fe_male') }}
                        @endif
                    </td>
                    <td>
                        {{ $user->birthdate }}
                    </td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->city->name }}</td>
                    <td>
                        @if ($user->status == \App\Models\User::ACTIVE)
                            {{ trans('custome.active') }}
                        @else
                            {{ trans('custome.locked') }}
                        @endif
                    </td>
                    <td>
                        @if ($user->status == \App\Models\User::ACTIVE)
                            <a class="btn btn-danger lock-user"
                                href="{{ route('admin.user.lock', ['id' => $user->id]) }}">
                                <i class="fas fa-lock"></i>
                            </a>
                        @else
                            <a class="btn btn-primary active-user"
                                href="{{ route('admin.user.active', ['id' => $user->id]) }}">
                                <i class="fas fa-lock-open"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {!! $users->links() !!}
    </div>
@endsection
