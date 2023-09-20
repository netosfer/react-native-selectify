<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
	protected $fillable = ["uniq_key", "lang", "image", "title", "description", "content", "tags", "slug", "data"];

}
