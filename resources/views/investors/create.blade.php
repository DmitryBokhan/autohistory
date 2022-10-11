@extends('layouts.dashboard_layout')

@section('title', 'Добавить инвестора')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mb-2">
            <h2>Создание нового инвестора</h2>
        </div>
        <div class="pull-right mb-4">
            <a class="btn btn-primary" href="{{ route('investors.index') }}">К списку инвесторов</a>
        </div>
    </div>
</div>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Ошибка!</strong><br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{!! Form::open(array('route' => 'user.investor_store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Имя:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Имя','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Пароль:</strong>
            {!! Form::password('password', array('placeholder' => 'Пароль','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Подтвердить Пароль:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Подтвердить Пароль','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-warning">Создать</button>
    </div>
</div>
{!! Form::close() !!}

@endsection
