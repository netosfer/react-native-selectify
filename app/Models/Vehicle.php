<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
	protected $fillable = ["plate_no", "brand_name", "model_name", "maintenance_date", "insurance_date", "vehicle_type"];

    protected $dateFormat = 'U';

    public function getMaintenanceDateAttribute($val){
        return Carbon::parse($val)->format('d.m.Y');
    }

    public function getInsuranceDateAttribute($val){
        return Carbon::parse($val)->format('d.m.Y');
    }
}
