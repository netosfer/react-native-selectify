<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function detail($page){
        $page = Str::slug($page);
        $detail = Page::where('slug', $page)->where('lang', config('app.locale'))->first();
        if(!$detail){
            return $this->view('errors.404');
        } else {
            $meta['title'] = $detail->title;
            $meta['description'] = $detail->description;
            return $this->view('page-detail', ['page' => $detail, 'meta' => $meta]);
        }
    }
}
