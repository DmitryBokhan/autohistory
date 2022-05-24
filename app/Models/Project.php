<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects'; // явное указание имени таблицы модели

    //поля таблицы доступные для редактирования
    protected $fillable = [
        'name', 'slug', 'description', 'balance', 'is_active'
    ];
}
