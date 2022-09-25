@extends('layouts.dashboard_layout')

@section('title', 'Редактирование позиции')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Редактирование позиции</h2>
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
    <form action="{{ route('position.update', $position) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Автомобиль</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="marks">Марка</label>
                                            <select class="form-control" id="marks" name="marks" aria-label="Марка автомобиля">
                                                @foreach ($marks as $mark)
                                                    @if($mark === $position->car->mark)
                                                        <option selected value="{{$position->car->mark}}">{{$position->car->mark}}</option>
                                                    @else
                                                        <option value="{{ $mark }}">{{ $mark }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="models">Модель</label>
                                            <select class="form-control" id="models" name="models" aria-label="Модель автомобиля">
                                                @foreach($models as $model)
                                                    @if( $model === $position->car->model)
                                                        <option selected value="{{$position->car->model}}">{{$position->car->model}}</option>
                                                    @else
                                                        <option value="{{ $model }}">{{ $model }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="engine_types">Тип двигателя</label>
                                            <select class="form-control" id="engine_types" name="engine_types" aria-label="Тип двигателя">
                                                @foreach($engine_types as $engine_type)
                                                    @if($engine_type === $position->car->{'engine-type'})
                                                        <option selected value="{{ $position->car->{'engine-type'} }}">{{ $position->car->{'engine-type'} }}</option>
                                                    @else
                                                        <option value="{{ $engine_type }}">{{ $engine_type }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="engine_volume">Объем двигателя</label>
                                            <select class="form-control" id="engine_volume" name="engine_volume" aria-label="Объем двигателя">
                                                @foreach($engine_volumes as $engine_volume)
                                                    @if($engine_volume === $position->car->volume)
                                                        <option selected value="{{$position->car->volume}}">{{$position->car->volume}}</option>
                                                    @else
                                                        <option value="{{ $engine_volume }}">{{ $engine_volume }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="transmission">Тип КПП</label>
                                            <select class="form-control" id="transmission" name="transmission" aria-label="Тип трансмиссии">
                                                @foreach($transmissions as $transmission)
                                                    @if($transmission === $position->car->transmission)
                                                        <option selected value="{{$position->car->transmission}}">{{$position->car->transmission}}</option>
                                                    @else
                                                        <option value="{{$transmission}}">{{$transmission}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="year">Год выпуска</label>
                                            <input type="text" data-year="" name="year" value="{{$position->year}}" class="form-control" placeholder="Год выпуска">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="gos_number">Гос. номер:</label>
                                            <input type="text" name="gos_number" value="{{$position->gos_number}}" class="form-control" placeholder="A000AA00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Место и дата покупки</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="countries">Страна покупки автомобиля</label>
                                    <select class="form-control" id="countries" name="countries" aria-label="Страна">
                                        @foreach ($countries as $country)
                                            @if($country->id === $position->city->country_id)
                                                <option selected value="{{ $country->id }}">{{$country->name}}</option>
                                            @else
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="regions">Регион</label>
                                    <select class="form-control" id="regions" name="regions" aria-label="Регион">
                                        @foreach ($regions as $region)
                                            @if($region->id === $position->city->region_id)
                                                <option selected value="{{$region->id}}">{{$region->name}}</option>
                                            @else
                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="cities">Город покупки</label>
                                    <select class="form-control" id="cities" name="cities" aria-label="Город">
                                        @foreach ($cities as $city)
                                            @if($city->id === $position->city->city_id)
                                                <option selected value="{{$city->id}}">{{$city->name}}</option>
                                            @else
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-xs-2 col-sm-2 col-md-2">
                                <div class="form-group">
                                    <strong>Дата покупки:</strong>
                                    <input class="form-control py-2 border-right-0 border" name="purchase_date" value="{{$position->purchase_date}}" type="date">
                                    <span class="input-group-append ml-n1"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Стоимость | доставка | подготовка</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Стоимость автомобиля:</strong>
                                    <input type="text" data-sum="" class="form-control" name="purchase_cost" value="{{$position->purchase_cost}}" placeholder="Сумма">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Планируемая стоимость продажи:</strong>
                                    <input type="text" data-sum="" class="form-control" name="sale_cost_plan" value="{{$position->sale_cost_plan}}" placeholder="Сумма">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Дата начала подготовки:</strong>
                                    <input class="form-control py-2 border-right-0 border" name="preparation_start" value="{{$position->preparation_start}}" type="date">
                                    <span class="input-group-append ml-n1"></span>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Планируемое время подготовки (дней):</strong>
                                    <input type="text" data-num="" class="form-control" name="preparation_plan" value="{{$position->preparation_plan}}"
                                           placeholder="Укажите количество дней на подготовку">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Планируемые расходы на доставку:</strong>
                                    <input type="text" class="form-control" data-sum="" name="delivery_cost_plan" value="{{$position->delivery_cost_plan}}" placeholder="Сумма">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Планируемые расходы на подготовку:</strong>
                                    <input type="text" class="form-control" data-sum="" name="additional_cost_plan" value="{{$position->additional_cost_plan}}" placeholder="Сумма">
                                </div>
                            </div>
                        </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Комментарий:</strong>
                                    <textarea class="form-control" style="height:150px" name="comment" placeholder="Комментарий">{{$position->comment}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
