<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
	protected $fillable = ["image", "name", "material_type", "material_code", "rfid_code", "received_date"];

    public function getReceivedDateAttribute($val){
        return Carbon::parse($val)->format('d.m.Y');
    }
}
