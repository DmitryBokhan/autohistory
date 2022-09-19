<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    public function getDefaultPercentInvest()
    {
        return AppSetting::orderBy('updated_at', 'DESC')->first()->default_invest_percent;
    }
}
