<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
	protected $fillable = ["uniq_key", "lang", "image", "title", "short_title", "link"];

}
