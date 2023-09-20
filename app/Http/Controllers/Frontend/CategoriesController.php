<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function detail($category){
        $category = Str::slug($category);
        $detail = Category::where('slug', $category)->where('lang', config('app.locale'))->first();
        if(!$detail){
            return $this->view('errors.404');
        } else {
            $meta['title'] = $detail->title;
            $meta['description'] = $detail->description;
            return $this->view('services', ['category' => $detail, 'meta' => $meta]);
        }
    }

    public function service($category, $service){
        $category = Str::slug($category);
        $service = Str::slug($service);
        $category = Category::where('slug', $category)->where('lang', config('app.locale'))->first();
        $blogs = Blog::where('lang', config('app.locale'))->paginate(3);
        if(!$category){
            return $this->view('errors.404');
        } else {
            $service = Service::where('lang', config('app.locale'))->where('type', $category->uniq_key)->where('slug', $service)->first();
            if(!$service) {
                return $this->view('errors.404');
            }
            $meta['title'] = $service->title;
            $meta['description'] = $service->description;
            return $this->view('service-detail', ['category' => $category, 'service' => $service, 'blogs' => $blogs, 'meta' => $meta]);
        }
    }
}
