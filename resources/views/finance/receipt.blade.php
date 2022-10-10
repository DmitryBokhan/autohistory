@extends('layouts.dashboard_layout')

@section('title', 'Приход')

@section('content')

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

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form action="{{ route('receipt.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Приход средств</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="user">Список инвесторов</label>
                                    <select class="form-control" id="user" name="user" aria-label="Список инвесторов">
                                        @foreach ($investors as $investor)
                                            @if($investor->id == Auth::User()->id)
                                                <option selected value="{{ $investor->id }}"><p style="color: red">{{ $investor->name }}</p> | {{ App\Models\Account::getBalance($investor->id) }}р.</option>
                                            @else
                                                <option value="{{ $investor->id }}"><p style="color: red">{{ $investor->name }}</p> | {{ App\Models\Account::getBalance($investor->id) }}р.</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="sum">Сумма прихода</label>
                                    <input type="text" name="sum" data-sum="" class="form-control" placeholder="Сумма">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                            <button type="submit" class="btn btn-primary">Внести</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Последнии операции</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th>Дата</th>
                                    <th>Инициатор</th>
                                    <th>Получатель</th>
                                    <th>Сумма прихода</th>
                                </tr>
                                @foreach($operations as $operation)
                                <tr>
                                    <td>{{ $operation->created_at }}</td>
                                    <td>{{ App\Models\User::find($operation->operation_author_id)->name }}</td>
                                    <td>{{ $operation->user->name}}</td>
                                    <td data-sum="" inputmode="numeric">{{ $operation->sum }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $operations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
