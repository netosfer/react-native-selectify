<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::where('lang', config('app.locale'))->paginate(10);
        if($request->has('perm')){
            $blogs = Blog::where('lang', config('app.locale'))->where('title', 'like', '%'.$request->has('perm').'%')->paginate(10);
        }
        $latest_posts = Blog::where('lang', config('app.locale'))->limit(5)->get();
        $meta['title'] = __('frontend.blog');
        $meta['description'] = __('frontend.blog_description');
        return $this->view('blogs', ['blogs' => $blogs, 'latest_posts' => $latest_posts, 'meta' => $meta]);
    }

    public function detail($detail)
    {

        $detail = Str::slug($detail);
        $blog = Blog::where('lang', config('app.locale'))->where('slug', $detail)->first();
        if(!$blog){
            return $this->view('errors.404');
        }
        $latest_posts = Blog::where('lang', config('app.locale'))->limit(5)->get();
        $meta['title'] = $blog->title;
        $meta['description'] = $blog->description;
        return $this->view('blog-detail', ['blog' => $blog, 'latest_posts' => $latest_posts, 'meta' => $meta]);
    }
}
