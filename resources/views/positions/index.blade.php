@extends('layouts.dashboard_layout')

@section('title', 'Прозиции')

@section('content')

    <div class="row">
        <div class="col-12 col-sm-12 mt-2">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="tabs-statuses" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $is_active_prepare ? "active" : "" }}" id="tabs-prepare-tab" data-toggle="pill" href="#tabs-prepare" role="tab" aria-controls="tabs-prepare" aria-selected="false">Подготовка</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $is_active_sale || $is_first_active ? "active" : "" }}" id="tabs-sale-tab" data-toggle="pill" href="#tabs-sale" role="tab" aria-controls="tabs-sale" aria-selected="false">Продажа</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $is_active_archive ? "active" : "" }}" id="tabs-archive-tab" data-toggle="pill" href="#tabs-archive" role="tab" aria-controls="tabs-archive" aria-selected="false">Архив</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="tabs-statusesContent">
                        <div class="tab-pane fade {{ $is_active_prepare ? "active show" : "" }}" id="tabs-prepare" role="tabpanel" aria-labelledby="tabs-prepare-tab">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Дата покупки</th>
                                    <th>Марка</th>
                                    <th>Модель</th>
                                    <th>Тип ДВС</th>
                                    <th>Объем ДВС</th>
                                    <th>Тип КПП</th>
                                    <th>Год выпуска</th>
                                    <th>Гос. номер</th>
                                    <th>Стоимость авто</th>
                                    <th width="280px">Action</th>
                                </tr>
                                @foreach ($positions_prepare as $position)
                                    <tr>
                                        <td>{{ ++$p }}</td>
                                        <td>{{ $position->purchase_date }}</td>
                                        <td>{{ $position->car->mark }}</td>
                                        <td>{{ $position->car->model }}</td>
                                        <td>{{ $position->car->{'engine-type'} }}</td>
                                        <td>{{ $position->car->volume }}</td>
                                        <td>{{ $position->car->transmission }}</td>
                                        <td>{{ $position->year }}</td>
                                        <td>{{ $position->gos_number }}</td>
                                        <td>{{ $position->purchase_cost }}</td>
                                        <td>
                                            n/a
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $positions_prepare->links() !!}
                        </div>
                        <div class="tab-pane fade {{ $is_active_sale || $is_first_active ? "active show" : "" }}" id="tabs-sale" role="tabpanel" aria-labelledby="tabs-sale-tab">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Дата покупки</th>
                                    <th>Марка</th>
                                    <th>Модель</th>
                                    <th>Тип ДВС</th>
                                    <th>Объем ДВС</th>
                                    <th>Тип КПП</th>
                                    <th>Год выпуска</th>
                                    <th>Гос. номер</th>
                                    <th>Стоимость авто</th>
                                    <th width="280px">Action</th>
                                </tr>
                                @foreach ($positions_sale as $position)
                                    <tr>
                                        <td>{{ ++$s}}</td>
                                        <td>{{ $position->purchase_date }}</td>
                                        <td>{{ $position->car->mark }}</td>
                                        <td>{{ $position->car->model }}</td>
                                        <td>{{ $position->car->{'engine-type'} }}</td>
                                        <td>{{ $position->car->volume }}</td>
                                        <td>{{ $position->car->transmission }}</td>
                                        <td>{{ $position->year }}</td>
                                        <td>{{ $position->gos_number }}</td>
                                        <td>{{ $position->purchase_cost }}</td>
                                        <td>
                                            n/a
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $positions_sale->links() !!}
                        </div>
                        <div class="tab-pane fade {{ $is_active_archive ? "active show" : "" }}" id="tabs-archive" role="tabpanel" aria-labelledby="tabs-archive-tab">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Дата покупки</th>
                                    <th>Марка</th>
                                    <th>Модель</th>
                                    <th>Тип ДВС</th>
                                    <th>Объем ДВС</th>
                                    <th>Тип КПП</th>
                                    <th>Год выпуска</th>
                                    <th>Гос. номер</th>
                                    <th>Стоимость авто</th>
                                    <th width="280px">Action</th>
                                </tr>
                                @foreach ($positions_archive as $position)
                                    <tr>
                                        <td>{{ ++$a }}</td>
                                        <td>{{ $position->purchase_date }}</td>
                                        <td>{{ $position->car->mark }}</td>
                                        <td>{{ $position->car->model }}</td>
                                        <td>{{ $position->car->{'engine-type'} }}</td>
                                        <td>{{ $position->car->volume }}</td>
                                        <td>{{ $position->car->transmission }}</td>
                                        <td>{{ $position->year }}</td>
                                        <td>{{ $position->gos_number }}</td>
                                        <td>{{ $position->purchase_cost }}</td>
                                        <td>
                                            n/a
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $positions_archive->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
