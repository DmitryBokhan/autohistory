@extends('layouts.dashboard_layout')

@section('title', 'Пользователи')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Управление пользователями</h2>
        </div>
        @can('user-create')
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('users.create') }}"> Добавить нового пользователя</a>
        </div>
        @endcan
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<table class="table table-bordered">
<tr>
    <th>No</th>
    <th>Имя</th>
    <th>Email</th>
    <th>Роль</th>
    <th width="380px">Действие</th>
</tr>
@foreach ($data as $key => $user)
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
    @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
            <label class="badge bg-success">{{ $v }}</label>
        @endforeach
    @endif
    </td>
    <td>
        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Просмотр</a>
        @can('user-edit')
        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Редактировать</a>
        @endcan
        @can('user-delete')
        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Удалить', ['class' => 'btn btn-danger delete-btn']) !!}
        {!! Form::close() !!}
        @endcan
    </td>
</tr>
@endforeach
</table>
{!! $data->render() !!}


@endsection
