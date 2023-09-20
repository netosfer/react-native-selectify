<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
	protected $fillable = ["uniq_key", "lang", "title", "description", "detail", "slug", "template", "data"];

    public function templates()
    {
        return [
            "about_us" => __('pages.about_us'),
            "other" => __('pages.other')
        ];
    }
}
