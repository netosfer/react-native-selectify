<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
	protected $fillable = ["employess", "location", "materials", "vehicle", "start_date", "end_date", "task_type", "notes"];
	public function employee(){ return $this->belongsToMany(Employee::class, 'employess'); }
	public function location(){ return $this->belongsTo(Location::class, 'location'); }
	public function material(){ return $this->belongsToMany(Material::class, 'materials'); }
	public function vehicle(){ return $this->belongsTo(Vehicle::class, 'vehicle'); }
}
