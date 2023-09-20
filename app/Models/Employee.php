<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
	protected $fillable = ["employee_type", "employee_id", "full_name", "employee_duty", "start_date_of_work", "end_date_of_work", "files"];

    public function getStartDateOfWorkAttribute($val){
        return Carbon::parse($val)->format('d.m.Y');
    }
}
