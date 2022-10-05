@extends('layouts.dashboard_layout')

@section('title', 'Настройки профиля')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Настройки профиля</h2>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ошибка!</strong><br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Инвестор: {{ $user->name }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('investor.update', $user->id) }}" method="POST">
                            @csrf
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-2 col-sm-2 col-md-2">
                                        <div class="form-group">
                                            <label for="invest_percent">% для ивестирования</label>
                                            <input type="text" data-num="" value='{{ $user->invest_percent }}' name="invest_percent" class="form-control" placeholder="%">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="row mt-2 mb-4 ml-2">
                                            <div class="custom-control custom-checkbox">
                                                <input  {{ $user->is_active ? 'checked' : '' }} name="is_active" class="custom-control-input custom-control-input-success" type="checkbox" id="customCheckbox4" >
                                                <label for="customCheckbox4" class="custom-control-label">Инвестор активен</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                                    <button type="submit" class="btn btn-primary">Сохранить настройки</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


@endsection
