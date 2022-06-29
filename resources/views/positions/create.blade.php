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

<form action="#" method="POST">
   @csrf
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <label for="marks">Марка</label>
            <select class="form-control" id="marks" aria-label="Марка автомобиля">
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
            <select class="form-control" id="models" aria-label="Модель автомобиля">
               <option selected>Выберите модель</option>
            </select>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <label for="years">Год выпуска</label>
            <input type="text" name="years" class="form-control" placeholder="Год выпуска">
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <strong>Гос. номер:</strong>
            <input type="text" name="gos_num" class="form-control" placeholder="A000AA00">
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <label for="engine_types">Тип двигателя</label>
            <select class="form-control" id="engine_types" aria-label="Тип двигателя">
               <option selected>Выберите тип ДВС</option>
            </select>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <label for="engine_volume">Объем двигателя</label>
            <select class="form-control" id="engine_volume" aria-label="Объем двигателя">
               <option selected>Выберите объем ДВС</option>
            </select>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <label for="transmission">Тип КПП</label>
            <select class="form-control" id="transmission" aria-label="Тип трансмиссии">
               <option selected>Выберите тип КПП</option>
            </select>
         </div>
      </div>
      <div class="input-group col-xs-2 col-sm-2 col-md-2">
         <div class="form-group">
            <strong>Дата покупки:</strong>
            <input class="form-control py-2 border-right-0 border" type="date">
            <span class="input-group-append ml-n1">
            </span>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
             <strong>Город покупки:</strong>
             <input type="text" class="form-control" name="city_pruchase" value="" placeholder="Город покупки">
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
             <strong>Расходы на покупку:</strong>
             <input type="text" class="form-control" name="price_pruchase" value="" placeholder="Сумма покупки">
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <strong>Планируемое время подготовки (дней):</strong>
            <input type="text" class="form-control" name="plan_preparation" value="3" placeholder="Укажите количество дней на подготовку">
         </div>
      </div>
      <div class="input-group col-xs-2 col-sm-2 col-md-2">
         <div class="form-group">
            <strong>Планируемая дата продажи:</strong>
            <input class="form-control py-2 border-right-0 border" type="date">
            <span class="input-group-append ml-n1">
            </span>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <strong>Комментарий:</strong>
            <textarea class="form-control" style="height:150px" name="comments" placeholder="Комментарий"></textarea>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
             <strong>Планируемые расходы на подготовку:</strong>
             <input type="text" class="form-control" name="additional_cost_plan" value="" placeholder="Сумма">
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
             <strong>Фактические расходы на подготовку:</strong>
             <input type="text" class="form-control" name="additional_cost_fact" value="" placeholder="Сумма">
         </div>
      </div>
     <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
             <button type="submit" class="btn btn-primary">Внести</button>
     </div>
 </div>

</form>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
