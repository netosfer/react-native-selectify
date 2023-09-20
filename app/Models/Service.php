<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ["uniq_key", "lang", "image", "type", "title", "description", "detail", "tags", "slug", "data"];
    protected $casts = [
        "data" => "json"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'type', 'uniq_key')->where('lang', config('app.locale'));
    }

    public function getDataAttribute($val){
        return json_decode($val);
    }
}
