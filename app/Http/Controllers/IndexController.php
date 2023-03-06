<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $this->seo()
            ->setTitle('صفحه اصلی راکت')
            ->setDescription('به وبسایت راکت خوش آمدید');

        return view('index');
    }
}
