<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontWebController extends Controller
{
    public function sliders()
    {
        return view('sliders.index');
    }

    public function aboutUs()
    {
        return view('about-us.index');
    }

    public function courses()
    {
        return view('courses.index');
    }

    public function news()
    {
        return view('news.index');
    }

    public function galleries()
    {
        return view('galleries.index');
    }

    public function footerPages()
    {
        return view('footer-pages.index');
    }
}
