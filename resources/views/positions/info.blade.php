@extends('layouts.dashboard_layout')

@section('title', 'Информация о позиции')

@section('content')
    <div class="pull-right">
        <a class="btn btn-success mt-2 mb-2" href="{{route('positions.index')}}"> Назад</a>
    </div>
    <div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col-12">
                <h4>
                     Информация о позиции
                    @if($position->position_status_id == 1)
                        <a class="btn bg-gradient-warning btn-outline-secondary btn-sm" href="{{ route('position.edit',$position->id) }}"><i class="fas fa-edit"></i></a>
                    @endif

                    <small class="float-right">ID: {{$position->id}}</small>
                </h4>
            </div>
        </div>
        <div class="row car-info">
            <div class="col-sm-4 car-col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5>Автомобиль</h5></li>
                    <li class="list-group-item"><b>Марка:</b> {{ $position->car->mark }}</li>
                    <li class="list-group-item"><b>Модель:</b> {{ $position->car->model }}</li>
                    <li class="list-group-item"><b>Тип двигателя:</b> {{ $position->car->{'engine-type'} }}</li>
                    <li class="list-group-item"><b>Объем двигателя:</b> {{ $position->car->volume }}</li>
                    <li class="list-group-item"><b>Тип КПП:</b> {{ $position->car->transmission }}</li>
                    <li class="list-group-item"><b>Год выпуска:</b> {{ $position->year }}</li>
                    <li class="list-group-item"><b>Гос. номер:</b> {{ $position->gos_number }}</li>
                </ul>
            </div>
            <div class="col-sm-4 car-col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5>Место и дата покупки</h5></li>
                    <li class="list-group-item"><b>Страна:</b> {{ $position->city->country->name }}</li>
                    <li class="list-group-item"><b>Регион:</b> {{ $position->city->region->name }}</li>
                    <li class="list-group-item"> <b>Город:</b> {{ $position->city->name }}</li>
                    <li class="list-group-item"><b>Дата покупки:</b> {{ $position->purchase_date }}</li>
                </ul>
            </div>
            <div class="col-sm-4 car-col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5>Стоимость и подготовка</h5></li>
                    <li class="list-group-item"><b>Стоимость автомобиля:</b> <span data-sum="">{{ $position->purchase_cost }}</span> ₽</li>
                    <li class="list-group-item"><b>Планируемая стоимость продажи:</b> <span data-sum="">{{ $position->sale_cost_plan }}</span> ₽</li>
                    @if($position->position_status_id == 3)
                        <li class="list-group-item"><b>Фактическая стоимость продажи:</b> <span data-sum="">{{ $position->sale_cost_fact }}</span> ₽</li>
                    @endif
                    <li class="list-group-item"><b>Планируемые расходы на доставку:</b> <span data-sum="">{{ $position->delivery_cost_plan }}</span> ₽</li>
                    @if($position->position_status_id == 3)
                        <li class="list-group-item"><b>Фактические расходы на доставку:</b> <span data-sum="">{{ $position->delivery_cost_fact }}</span> ₽</li>
                    @endif
                    <li class="list-group-item"><b>Планируемые расходы на подготовку:</b> <span data-sum="">{{ $position->additional_cost_plan }}</span> ₽</li>
                    @if($position->position_status_id == 3)
                        <li class="list-group-item"><b>Фактические расходы на подготовку:</b> <span data-sum="">{{ $position->additional_cost_fact }}</span> ₽</li>
                    @endif
                    <li class="list-group-item"><b>Дата начала подготовки:</b> {{ $position->preparation_start }}</li>

                    <li class="list-group-item"><b>Планируемое время подготовки (дней):</b> {{ $position->preparation_plan }}</li>
                    @if(in_array($position->position_status_id ,[2,3]))
                        <li class="list-group-item"><b>Фактическое время подготовки (дней):</b> {{ $position->getPreparationFact() }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 callout callout-info mt-4 mb-4">
                <h5><i class="fas fa-info"></i> Комметнарий:</h5>
                @if ($position->comment == null)
                    {{'Комментарии отсутствуют'}}
                @else
                    {{ $position->comment }}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ml-3 mt-2 md-2 mr-2">
                <p class="text-center">
                    <strong>Цели инвестирования</strong>
                </p>
                @if($position->is_realization == false)
                <div class="progress-group">
                    <span class="progress-text">Покупка автомобиля ({{ $position->getPercentInvestPurchase() }}%)</span>
                    <span class="float-right">Факт <b><span data-sum="">{{$position->getSumInvestPurchase()}}</span>р.</b> план <b><span data-sum="">{{$position->purchase_cost}}</span>р.</b> | еще нужно: <b><span data-sum-need="">{{$position->purchase_cost - $position->getSumInvestPurchase()}}</span>р.</b></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger bg-primary" style="width: {{ $position->getPercentInvestPurchase() }}%"></div>
                    </div>
                </div>
                @endif
                <div class="progress-group">
                    <span class="progress-text">Доставка автомобиля ({{ $position->getPercentInvestDelivery() }}%)</span>
                    <span class="float-right">Факт <b><span data-sum="">{{$position->getSumInvestDelivery()}}</span>р.</b> план <b><span data-sum="">{{$position->delivery_cost_plan}}</span>р.</b> | еще нужно: <b><span data-sum-need="">{{$position->delivery_cost_plan - $position->getSumInvestDelivery()}}</span>р.</b></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar  bg-warning" style="width: {{ $position->getPercentInvestDelivery() }}%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    <span class="progress-text">Подготовка автомобиля ({{ $position->getPercentInvestPreparation() }}%)</span>
                    <span class="float-right">Факт <b><span data-sum="">{{$position->getSumInvestPreparation()}}</span>р.</b> план <b><span data-sum="">{{$position->additional_cost_plan}}</span>р.</b> | еще нужно: <b><span data-sum-need="">{{$position->additional_cost_plan - $position->getSumInvestPreparation()}}</span>р.</b></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: {{ $position->getPercentInvestPreparation() }}%"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-4">
                        <div class="card  flex-grow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title">Статус позиции</h3>
                            </div>

                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row justify-content-around mb-2">
                                    @if($position->position_status_id == 1)
                                        <h3 class="text-danger"><span class="right badge badge-danger">ПОДГОТОВКА</span></h3>
                                    @elseif($position->position_status_id == 2)
                                        <h3 class="text-success"><span class="right badge badge-success">ПРОДАЖА</span></h3>
                                    @elseif($position->position_status_id == 3)
                                        <h3 class="text-success"><span class="right badge badge-success">АРХИВ</span></h3>
                                    @endif
                                </div>
                                <form action="{{route('position_info.change_status', $position->id)}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        @if($position->position_status_id == 1)
                                            <button type="submit" class="btn btn-block  bg-gradient-success btn-flat">В продажу</button>
                                        @elseif($position->position_status_id == 2)
                                            <button type="submit" class="btn btn-block  bg-gradient-warning btn-flat">Вернуть в подготовку</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if($position->position_status_id == 2)
                    <div class="col-6 mt-4">
                        <div class="card flex-grow h-100">
                            <div class="card-header">
                                <h3 class="card-title">Фактическая стоимость продажи</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('position_info',$position->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" data-sum="" name="sale_cost_fact" value="{{$sale_cost_fact ? $sale_cost_fact : $position->sale_cost_plan}}"></input>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block  bg-gradient-success btn-flat">Рассчитать</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-5">
                <div class="row mt-2">
                    <div class="col-ms-6 col-6">
                        <div class="description-block">
                            <span class="description-text">ЗАТРАТЫ НА ПОКУПКУ</span>
                            <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->purchase_cost}}</h4>
                        </div>
                    </div>
                    <div class="col-ms-6 col-6">
                        <div class="description-block border-left">
                            <span class="description-text">ФАКТ ПРОДАЖА</span>
                            @if($position->position_status_id == 3)
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->sale_cost_fact}}</h4>
                            @else
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$sale_cost_fact ? $sale_cost_fact : $position->sale_cost_plan}}</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-ms-6 col-6">
                        <div class="description-block">
                            <span class="description-text">ФАКТ ДОСТАВКА</span>
                            @if($position->position_status_id == 3)
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->delivery_cost_fact}}</h4>
                            @else
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->getSumInvestDelivery()}}</h4>
                            @endif
                        </div>
                    </div>
                    <div class="col-ms-6 col-6">
                        <div class="description-block border-left">
                            <span class="description-text">ФАКТ ПОДГОТОВКА</span>
                            @if($position->position_status_id == 3)
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->additional_cost_fact}}</h4>
                            @else
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->getSumInvestPreparation()}}</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-ms-6 col-6">
                        <div class="description-block">
                            <span class="description-text">ДОХОД ИНВЕТОРОВ</span>
                            @if($position->position_status_id == 3)
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->CalcSumProfitInvestors($position->sale_cost_fact)}}</h4>
                            @else
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->CalcSumProfitInvestors($sale_cost_fact)}}</h4>
                            @endif
                        </div>
                    </div>
                    <div class="col-ms-6 col-6">
                        <div class="description-block border-left">
                            <span class="description-text">ДОХОД АВТОРА ПОЗИЦИИ</span>
                            @if($position->position_status_id == 3)
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->CalcSumProfitOwn($position->sale_cost_fact)}}</h4>
                            @else
                                <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->CalcSumProfitOwn($sale_cost_fact)}}</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-3 justify-content-center">
                    @if($sale_cost_fact)
                        <div class="col-sm-6">
                            <div class="form-group">
                                <a type="button" href="{{ route('position_info',$position->id) }}" class="btn btn-block  bg-gradient-warning btn-flat">Отмена</a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ route('position_info.position_close', $position->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="sale_cost_fact" value="{{$sale_cost_fact}}">
                                    <button type="submit" class="btn btn-block  bg-gradient-danger btn-flat">Подтвердить продажу</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <h4>
                    <i class="fas fa-users "></i> Ивестиции в позицию
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Дата</th>
                        <th>Инвестор</th>
                        <th>Цель инвестиции</th>
                        <th>Схема инвестирования</th>
                        <th>Сумма</th>
                        <th>%</th>
                        <th>Фикс</th>
                        @if($position->position_status_id == 3)
                            <th>Фактический доход</th>
                        @else
                            <th>Ожидаемая доходность</th>
                        @endif
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $key => $account)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ date("d.m.Y", strtotime ($account->updated_at)) }}</td>
                            <td>{{$account->user->name}}</td>
                            <td>{{$account->payPurpose->name}}</td>
                            <td>{{$account->investScheme->name}}</td>
                            <td data-sum="">{{abs($account->sum)}}</td>
                            <td>{{$account->showInvestPercent() ? $account->showInvestPercent() : '-' }}</td>
                            <td data-sum="">{{$account->invest_fixed ? $account->invest_fixed : "" }}</td>
                            @if($position->position_status_id == 3)
                                <td data-profit="">{{$account->CalcAccountProfit($position->sale_cost_fact)}}</td>
                            @else
                                <td data-profit="">{{$account->CalcAccountProfit($sale_cost_fact)}}</td>
                            @endif
                            <td>
                                @if($position->position_status_id == 1)
                                    <form action="{{ route('invest_position.account_delete', $account->id) }}" method="POST">
                                        @csrf
                                        <button class="btn bg-gradient-danger btn-outline-secondary btn-sm delete-btn" type="submit"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($accounts) == 0)
                    <p class="text-danger">Еще ни один инвестор не решился на это. Будь первым! </p>
                @endif
                @if($position->position_status_id == 1)
                    <div class="row mb-4">
                        <div class="col-12 text-left">
                            <a class="btn bg-gradient-warning btn-outline-secondary btn-sm" href="{{route('invest_position.create', $position->id)}}">+ Добавить инвестора</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-6">
                <p class="lead ">Расчеты</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody><tr>
                            @if($position->position_status_id == 3)
                                <th style="width:50%">Фактический доход от продажи позиции (общий):</th>
                                <td data-profit="">{{$position->CalcProfit($position->sale_cost_fact)}} </td>
                            @else
                                <th style="width:50%">Ожидаемй доход от продажи позиции (общий):</th>
                                <td data-profit="">{{$position->CalcProfit($sale_cost_fact)}} </td>
                            @endif
                        </tr>
                        <tr>
                            @if($position->position_status_id == 3)
                                <th>% прибыли</th>
                                <td>{{$position->CalcProfitabilityPercent($position->sale_cost_fact)}}%</td>
                            @else
                                <th>% планируемой прибыли</th>
                                <td>{{$position->CalcProfitabilityPercent($sale_cost_fact)}}%</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Доход инвеcторов:</th>
                            @if($position->position_status_id == 3)
                                <td data-profit="">{{$position->CalcSumProfitInvestors($position->sale_cost_fact)}}</td>
                            @else
                                <td data-profit="">{{$position->CalcSumProfitInvestors($sale_cost_fact)}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Доход автора позиции:</th>
                            @if($position->position_status_id == 3)
                                <td data-profit="">{{$position->CalcSumProfitOwn($position->sale_cost_fact)}}</td>
                            @else
                                <td data-profit="">{{$position->CalcSumProfitOwn($sale_cost_fact)}}</td>
                            @endif
                        </tr>
                        </tbody></table>
                </div>
            </div>
        </div>
    </div>


@endsection
