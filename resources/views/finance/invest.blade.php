@extends('layouts.dashboard_layout')

@section('title', 'Инвестиция в позицию')

@section('content')


    <div class="pull-right">
        <a class="btn btn-success mt-2" href="{{url()->previous()}}"> Назад</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invest_position.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Инвестиция в позицию: <b>{{$position->car->mark . " ". $position->car->model . " | гос.номер: " . $position->gos_number}}</b></h3>
                    </div>
                    <input type="hidden" name="position_id" value="{{$position->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
{{--                                        <div class="form-group">--}}
{{--                                            <label for="positions">Позиция</label>--}}
{{--                                            <select class="form-control" id="positions" name="positions" aria-label="Позиции">--}}
{{--                                                @foreach ($positions as $position)--}}
{{--                                                    <option value="{{ $position->id }}">{{ $position->gos_number . ' '. $position->car->model }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="pay_purposes">Цель инвестиции</label>
                                            <select class="form-control" id="pay_purposes" name="pay_purposes" aria-label="Цель инвестиции">
                                                @foreach ($pay_purposes as $pay_purpose)
                                                    <option value="{{ $pay_purpose->id }}">{{ $pay_purpose->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="investors">Инвестор</label>
                                            <select class="form-control"  id="investors" name="investors" aria-label="Инвестор">
                                                @foreach($investors as $investor)
                                                    <option value="{{ $investor->id }}">{{ $investor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sum">Сумма инвестиций</label>
                                            <input type="text" name="sum" class="form-control" placeholder="Сумма">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="schemas">Схема инвестирования</label>
                                            <select class="form-control"  id="schemas" name="schemas" aria-label="Схема инвестирования">
                                                @foreach($invest_schemas as $schema)
                                                    <option value="{{ $schema->id }}">{{ $schema->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="invest_fixed">Фиксированная сумма дохода</label>
                                            <input type="number"  name="invest_fixed" class="form-control" placeholder="Сумма">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Комментарий</label>
                                            <textarea  name="comment" class="form-control" placeholder="Комментарий"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                                        <button class="btn btn-primary">Инвестировать</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
