@extends('layouts.dashboard_layout')

@section('title', 'Инвестиция в позицию')

@section('content')


    <div class="pull-right">
        <a class="btn btn-success mt-2" href="{{route('position_info', $position->id)}}"> Назад</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <strong>Ошибка!</strong><br><br>
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
                                <div class="col-ms-12 col-12">
                                    <div class="description-block">
                                        <span class="description-text">ПРИБЫЛЬ ИНВЕСТОРА</span>
                                        <h4 id="profit_investor" class="text-success text-lg-center mt-2" data-profit="">0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
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
                                                    @if($investor->id == Auth::User()->id)
                                                        <option selected value="{{ $investor->id }}" id="id-{{$investor->id}}" data-percent="{{$investor->invest_percent}}">{{ $investor->name ." | " . $investor->invest_percent."% | " . App\Models\Account::getBalance($investor->id)}}р.</option>
                                                    @else
                                                        <option value="{{ $investor->id }}" id="id-{{$investor->id}}" data-percent="{{$investor->invest_percent}}">{{ $investor->name ." | " . $investor->invest_percent."% | " . App\Models\Account::getBalance($investor->id)}}р.</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sum">Сумма инвестиции</label>
                                            <input type="text" name="sum" id="sum" class="form-control" data-sum="" value="{{old('sum')}}" placeholder="Сумма" >
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" id="shceme_block">
                                        <div class="form-group">
                                            <label for="schemes">Схема инвестирования</label>
                                            <select class="form-control"  id="schemes" name="schemes" aria-label="Схема инвестирования">
                                                @foreach($invest_schemes as $scheme)
                                                    @if(old('schemes') == $scheme->id)
                                                        <option selected value="{{ $scheme->id }}">{{ $scheme->name }}</option>
                                                    @else
                                                        <option value="{{ $scheme->id }}">{{ $scheme->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" id="sum_fixed_block">
                                        <div class="form-group">
                                            <label for="invest_fixed">Фиксированная сумма дохода</label>
                                            @if(old('invest_fixed'))
                                            <input type="text"  name="invest_fixed" id="sum_fixed" class="form-control" data-sum="" value="{{old('invest_fixed')}}" placeholder="Сумма">
                                            @else
                                                <input type="text" disabled="disabled" name="invest_fixed" id="sum_fixed" class="form-control" data-sum="" placeholder="Сумма">
                                            @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //если выбран админ, то скрываем блок "Схема инвестирования" и "Фиксированная сумма дохода"
            if(document.getElementById('investors').value == {{$position->user_id}}){
                $('#shceme_block').attr("hidden", true);
                $('#sum_fixed_block').attr("hidden", true);
            }


            //округляет число
            function roundPlus(x, n) { //x - число, n - количество знаков
                if(isNaN(x) || isNaN(n)) return 0;
                var m = Math.pow(10,n);
                return Math.round(x*m)/m;
            }
            const PROFIT_POSITION = Number({{$position->CalcProfit()}});
            const PROFIT_OWN = Number({{$position->CalcSumProfitOwn()}});
            const SUM_INVEST = Number({{App\Models\Account::getSumAccountsInPositionById($position->id)}}); //сумма всех ивсестированных средств

            var input_sum = document.getElementById('sum');
            var input_sum_fixed = document.getElementById('sum_fixed');

            var profit_own = document.getElementById('profit_own');



            var investor_id = document.getElementById('investors'); // value это id ивестора

            //расчет инвестиций
            function CalcProfit(){
                var investor_percent = document.getElementById('id-'+ investor_id.value).dataset.percent / 100;
                var scheme = document.getElementById('schemes').value; //схема
                var pay_purposes = document.getElementById('pay_purposes').value; //цель
                switch (scheme) {
                    case("1"): //расчет при схеме "% от вклада"
                        var sum = Number(input_sum.value.split(' ').join('')); // удаляем пробелы из строки и приводим к числовому типу
                        document.getElementById('profit_investor').value = roundPlus(sum * investor_percent, 0);
                        break;
                    case("2"): // расчет при схеме "% от прибыли"
                        var sum = Number(input_sum.value.split(' ').join(''));
                            var percent = sum / (SUM_INVEST + sum);
                            var investor_profit = roundPlus((PROFIT_POSITION) * percent, 0);
                            document.getElementById('profit_investor').value = investor_profit;
                        break;
                    case("3"): // расчет при схеме "фиксированная сумма"
                        var sum = Number(input_sum.value.split(' ').join(''));
                        var sum_fix = Number(input_sum_fixed.value.split(' ').join(''));
                        document.getElementById('profit_investor').value = sum_fix ? sum_fix : 0 ;
                        break;
                    case("4"): // расчет "без схемы"
                        var sum = Number(input_sum.value.split(' ').join(''));
                        break;
            }
        }

            input_sum.oninput = function() {
                CalcProfit();
            };

            input_sum_fixed.oninput = function() {
                CalcProfit();
            };

            document.getElementById('investors').onchange = function() {
                if(document.getElementById('investors').value == {{$position->user_id}}){
                    $('#shceme_block').attr("hidden", true);
                    $('#sum_fixed_block').attr("hidden", true);
                }else{
                    $('#shceme_block').attr("hidden", false);
                    $('#sum_fixed_block').attr("hidden", false);
                }
                CalcProfit();
            }

            document.getElementById('pay_purposes').onchange = function() {
                CalcProfit();
            }

            //отслеживаем смену схемы инвестирования
            var schemes = document.getElementById('schemes');
            document.getElementById('schemes').onchange = function() {
                switch (schemes.value){
                    case("1"): //расчет при схеме "% от вклада"
                        $('#sum_fixed').attr("disabled", true);
                        CalcProfit();
                        break;
                    case("2"): // расчет при схеме "% от прибыли"
                        $('#sum_fixed').attr("disabled", true);
                        CalcProfit();
                        break;
                    case("3"): // расчет при схеме "фиксированная сумма"
                        $('#sum_fixed').attr("disabled", false);
                        CalcProfit();
                        break;
                    case("4"): // расчет "без схемы"
                        $('#sum_fixed').attr("disabled", true);
                        document.getElementById('profit_investor').value = 0;
                        break;
                }
            }
        }, false);
    </script>

@endsection
