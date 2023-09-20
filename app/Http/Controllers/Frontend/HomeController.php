<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {

        $blogs = Blog::where('lang', config('app.locale'))->get();
        $sliders = Slider::where('lang', config('app.locale'))->paginate(10);
        return $this->view('home', ['blogs' => $blogs, "sliders" => $sliders]);
    }

    public function contact()
    {
        $meta['title'] = __('frontend.contact_me');
        $meta['description'] = __('frontend.contact_me_description');
        return $this->view('contact', ['meta' => $meta]);
    }

    public function setLocale($locale)
    {
        Session::put('prefix', $locale);
        return redirect()->route('frontend.home');
    }


}
