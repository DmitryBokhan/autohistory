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
                    <a class="btn bg-gradient-warning btn-outline-secondary btn-sm" href="{{ route('position.edit',$position->id) }}"><i class="fas fa-edit"></i></a>

                    <small class="float-right">ID: 15</small>
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
                    <li class="list-group-item"><b>Планируемые расходы на доставку:</b> <span data-sum="">{{ $position->delivery_cost_plan }}</span> ₽</li>
                    <li class="list-group-item"><b>Планируемые расходы на подготовку:</b> <span data-sum="">{{ $position->additional_cost_plan }}</span> ₽</li>
                    <li class="list-group-item"><b>Дата начала подготовки:</b> {{ $position->preparation_start }}</li>
                    <li class="list-group-item"><b>Планируемое время подготовки (дней):</b> {{ $position->preparation_plan }}</li>
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
            </div>
            <div class="col-md-5">
                <div class="row mt-4">
                    <div class="col-ms-6 col-6">
                        <div class="description-block">
                            <span class="description-text">ДОХОД ИНВЕТОРОВ</span>
                            <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->CalcSumProfitInvestors()}}</h4>
                        </div>
                    </div>
                    <div class="col-ms-6 col-6">
                        <div class="description-block border-left">
                            <span class="description-text">МОЙ ДОХОД С ПОЗИЦИИ</span>
                            <h4 class="text-success text-lg-center mt-2" data-profit="">{{$position->CalcSumProfitOwn()}}</h4>
                        </div>
                    </div>

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
                        <th>Ожидаемая доходность</th>
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
                            <td data-sum="">{{$account->CalcAccountProfit()}}</td>
                            <td>
                                <a class="btn bg-gradient-warning btn-outline-secondary btn-sm" href="#"><i class="fas fa-edit"></i></a>
                                <a class="btn bg-gradient-danger btn-outline-secondary btn-sm" href="#"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($accounts) == 0)
                    <p class="text-danger">Еще ни один инвестор не решился на это. Будь первым! </p>
                @endif
                <div class="row mb-4">
                    <div class="col-12 text-left">
                        <a class="btn bg-gradient-warning btn-outline-secondary btn-sm" href="{{route('invest_position.create', $position->id)}}">+ Добавить инвестора</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p class="lead ">Расчеты</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody><tr>
                            <th style="width:50%">Ожидаемй доход от продажи позиции (общий):</th>
                            <td data-profit="">{{$position->CalcProfit()}} </td>
                        </tr>
                        <tr>
                            <th>% планируемого дохода</th>
                            <td>{{$position->CalcProfitabilityPercent()}}%</td>
                        </tr>
                        <tr>
                            <th>Доход инвеcторов:</th>
                            <td data-profit="">{{$position->CalcSumProfitInvestors()}}</td>
                        </tr>
                        <tr>
                            <th>Мой доход:</th>
                            <td data-profit="">{{$position->CalcSumProfitOwn()}}</td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="col-6">

            </div>
        </div>
    </div>


@endsection
