@extends('layouts.dashboard_layout')

@section('title', 'Главная')

@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1 class="m-0">Главная</h1>
       </div><!-- /.col -->
       <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
         </ol>
       </div><!-- /.col -->
     </div><!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <section class="content">
   <div class="container-fluid">
     <!-- Small boxes (Stat box) -->
     <div class="row">
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-success">
           <div class="inner">
             <h3>{{App\Models\Position::where('position_status_id', 2)->get()->count()}}</h3>

             <p>Позиции в продаже</p>
           </div>
           <div class="icon">
             <i class="fas fa-car"></i>
           </div>
           <a href="#" class="small-box-footer">Список позиций<i class="fas fa-arrow-circle-right "></i></a>
         </div>
       </div>
         <div class="col-lg-3 col-6">
             <div class="small-box bg-info">
                 <div class="inner">
                     <h3>{{App\Models\Position::where('position_status_id', 1)->get()->count()}}</h3>

                     <p>Позиции в подготовке</p>
                 </div>
                 <div class="icon">
                     <i class="fas fa-wrench"></i>
                 </div>
                 <a href="#" class="small-box-footer">Список позиций<i class="fas fa-arrow-circle-right "></i></a>
             </div>
         </div>
       <!-- ./col -->
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-secondary">
           <div class="inner">
             <h3>{{App\Models\Position::getCountPositionOwn(Auth()->user()->id)}}</h3>
             <p>Мои позиции</p>
           </div>
           <div class="icon">
             <i class="ion ion-stats-bars"></i>
           </div>
           <a href="#" class="small-box-footer">Список моих позиций <i class="fas fa-arrow-circle-right"></i></a>
         </div>
       </div>
       <!-- ./col -->
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-warning">
           <div class="inner">
             <h3>{{ $user_count }}</h3>
             <p>Пользователи</p>
           </div>
           <div class="icon">
             <i class="ion ion-person-add"></i>
           </div>
           <a href="{{ route('users.index') }}" class="small-box-footer">Список пользователей <i class="fas fa-arrow-circle-right"></i></a>
         </div>
       </div>
       <!-- ./col -->
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-danger">
           <div class="inner">
               <h3><span data-profit="">{{$balance}}</span>
              <sup style="font-size: 20px"> ₽</sup>
             </h3>

             <p>Мой баланс свободных средств</p>
           </div>
           <div class="icon">
             <i class="ion ion-pie-graph"></i>
           </div>
           <a href="#" class="small-box-footer">Список поступлений<i class="fas fa-arrow-circle-right"></i></a>
         </div>
       </div>
       <!-- ./col -->
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-danger">
                 <div class="inner">
                     <h3><span data-profit="">{{$balance_invest}}</span>
                         <sup style="font-size: 20px"> ₽</sup>
                     </h3>

                     <p>Мой баланс инвестированных средств</p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-pie-graph"></i>
                 </div>
                 <a href="#" class="small-box-footer">Список инвестиций<i class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-danger">
                 <div class="inner">
                     <h3><span data-profit="">{{App\Models\Account::getBalanceFreeMoneyInvestors()}}</span>
                         <sup style="font-size: 20px"> ₽</sup>
                     </h3>

                     <p>Свободные инвесторские</p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-pie-graph"></i>
                 </div>
                 <a href="#" class="small-box-footer">Список инвесторов<i class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </section>
 <!-- /.content -->
 @endsection
