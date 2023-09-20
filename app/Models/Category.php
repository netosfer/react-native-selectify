<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
	protected $fillable = ["uniq_key", "lang", "image", "title", "description", "show_on_the_menu", "slug"];

    public function services()
    {
        return $this->hasMany(Service::class, 'type', 'uniq_key')->where('lang', config('app.locale'));
    }
}
