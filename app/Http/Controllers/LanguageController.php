<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(string $language)
    {
        if (in_array($language, ['en', 'vi']))
        {
            session()->put('language', $language);
        }
//        dd(session()->all());
        return redirect()->back();
    }
}
