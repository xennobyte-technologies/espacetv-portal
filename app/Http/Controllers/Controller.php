<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController {
  public function setLocale($locale) {
    $allowedLocale = ['en', 'cn'];
    if (!in_array($locale, $allowedLocale)) {
      $locale = 'en';
    }
    Session::put('locale', $locale);
    Session::save();
    App::setLocale($locale);
    return redirect()->back();
  }
}
