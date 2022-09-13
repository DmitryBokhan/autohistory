<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';

    protected $guarded = [];

    public function car()
    {
        return $this->hasOne(Carsbase::class, "id", "car_id");
    }

}
