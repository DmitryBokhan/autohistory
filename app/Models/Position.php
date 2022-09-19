<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';

    protected $guarded = [];


    /**
     * Создатель позиции
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    /**
     * Автомобиль
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function car()
    {
        return $this->hasOne(Carsbase::class, "id", "car_id");
    }


    /**
     * Статус позиции
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function positionStatus()
    {
        return $this->hasOne(PositionStatus::class, 'id', 'position_status_id');
    }


    public function accounts()
    {
        return $this->hasMany(Account::class, 'id', 'position_id');
    }
}
