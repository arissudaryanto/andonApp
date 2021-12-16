<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    
    public function switchLang($lang)
    {
        if (array_key_exists($lang, config()->get('languages'))) {
            App::setLocale($lang);
            session()->put('locale', $lang);
        }
        return redirect()->back();
    }
}
