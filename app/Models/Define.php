<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Define extends Model
{
    use HasFactory;
	protected $fillable = ["type", "name", "values", "kind"];

}
