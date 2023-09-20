<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
	protected $fillable = ["user", "service", "appointment_date", "appointment_time", "approve", "completed", "closed"];
	public function users(){ return $this->belongsTo(User::class, 'user'); }
	public function services(){ return $this->belongsTo(Service::class, 'service', 'uniq_key')->where('lang', config('app.locale')); }
}
