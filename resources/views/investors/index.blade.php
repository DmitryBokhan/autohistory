@extends('layouts.dashboard_layout')

@section('title', 'Инвесторы')

@section('content')



    <h2>ИНВЕСТОРЫ</h2>
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 mt-2 bg-white">
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Имя инвестора</th>
                        <th>% от инвестиций</th>
                        <th>Баланс общий</th>
                        <th>Свободных</th>
                        <th>Ивестированных</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($investors as $investor)
                        <tr>
                            <td>{{ $investor->id }}</td>
                            <td>{{ $investor->name }}</td>
                            <td>{{ $investor->invest_percent }}</td>
                            <td data-sum="">{{ App\Models\Account::getAllMoney($investor->id) }}</td>
                            <td data-sum="">{{ App\Models\Account::getBalance($investor->id) }}</td>
                            <td data-sum="">{{ App\Models\Account::getBalanceInvestOpen($investor->id) }} </td>
                            <td>
                                @if(App\Models\User::find($investor->id)->is_active)
                                    <span class="right badge badge-success">Активен</span>
                                @else
                                    <span class="right badge badge-danger">Неактивен</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('investor.settings', $investor->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-warning" type="submit">Настройки</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>




@endsection
