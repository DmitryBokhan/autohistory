@extends('layouts.dashboard_layout')

@section('title', 'Создание позиции')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Создание позиции</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="#">Назад</a>
            </div>
        </div>
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

    <form action="{{ route('create_position.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="marks">Марка</label>
                    <select class="form-control" id="marks" name="marks" aria-label="Марка автомобиля">
                        <option selected>Выберите марку</option>
                        @foreach ($marks as $mark)
                            <option value="{{ $mark }}">{{ $mark }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="models">Модель</label>
                    <select class="form-control" id="models" name="models" aria-label="Модель автомобиля">
                        <option selected>Выберите модель</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="engine_types">Тип двигателя</label>
                    <select class="form-control" id="engine_types" name="engine_types" aria-label="Тип двигателя">
                        <option selected>Выберите тип ДВС</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="engine_volume">Объем двигателя</label>
                    <select class="form-control" id="engine_volume" name="engine_volume" aria-label="Объем двигателя">
                        <option selected>Выберите объем ДВС</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="transmission">Тип КПП</label>
                    <select class="form-control" id="transmission" name="transmission" aria-label="Тип трансмиссии">
                        <option selected>Выберите тип КПП</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="year">Год выпуска</label>
                    <input type="text" name="year" class="form-control" placeholder="Год выпуска">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Гос. номер:</strong>
                    <input type="text" name="gos_number" class="form-control" placeholder="A000AA00">
                </div>
            </div>
            <div class="input-group col-xs-2 col-sm-2 col-md-2">
                <div class="form-group">
                    <strong>Дата покупки:</strong>
                    <input class="form-control py-2 border-right-0 border" name="purchase_date" type="date">
                    <span class="input-group-append ml-n1">
            </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="countries">Страна покупки автомобиля</label>
                    <select class="form-control" id="countries" name="countries" aria-label="Страна">
                        <option selected value="3159">Россия</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="regions">Регион</label>
                    <select class="form-control" id="regions" name="regions" aria-label="Регион">
                        <option selected value="4052">Краснодарский край</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="cities">Город покупки</label>
                    <select class="form-control" id="cities" name="cities" aria-label="Город">
                        <option selected value="4079">Краснодар</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Стоимость автомобиля:</strong>
                    <input type="text" class="form-control" name="purchase_cost" value="" placeholder="Сумма">
                </div>
            </div>
            <div class="input-group col-xs-2 col-sm-2 col-md-2">
                <div class="form-group">
                    <strong>Дата начала подготовки:</strong>
                    <input class="form-control py-2 border-right-0 border" name="preparation_start" type="date">
                    <span class="input-group-append ml-n1"></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Планируемое время подготовки (дней):</strong>
                    <input type="text" class="form-control" name="preparation_plan" value="3"
                           placeholder="Укажите количество дней на подготовку">
                </div>
            </div>
            {{--      <div class="input-group col-xs-2 col-sm-2 col-md-2">--}}
            {{--          <div class="form-group">--}}
            {{--              <strong>Дата кончания подготовки:</strong>--}}
            {{--              <input class="form-control py-2 border-right-0 border" name="end_preparation" type="date">--}}
            {{--              <span class="input-group-append ml-n1"></span>--}}
            {{--          </div>--}}
            {{--      </div>--}}
            {{--      <div class="input-group col-xs-2 col-sm-2 col-md-2">--}}
            {{--         <div class="form-group">--}}
            {{--            <strong>Планируемая дата продажи:</strong>--}}
            {{--            <input class="form-control py-2 border-right-0 border" type="date">--}}
            {{--            <span class="input-group-append ml-n1">--}}
            {{--            </span>--}}
            {{--         </div>--}}
            {{--      </div>--}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Планируемые расходы на подготовку:</strong>
                    <input type="text" class="form-control" name="additional_cost_plan" value="" placeholder="Сумма">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Комментарий:</strong>
                    <textarea class="form-control" style="height:150px" name="comment" placeholder="Комментарий"></textarea>
                </div>
            </div>
            {{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
            {{--                <div class="form-group">--}}
            {{--                    <strong>Фактические расходы на подготовку:</strong>--}}
            {{--                    <input type="text" class="form-control" name="additional_cost_fact" value="" placeholder="Сумма">--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                <button type="submit" class="btn btn-primary">Добавить позицию</button>
            </div>
        </div>

    </form>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
