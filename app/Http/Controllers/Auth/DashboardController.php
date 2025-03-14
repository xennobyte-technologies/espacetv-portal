<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Session;

class DashboardController extends Controller {
  public function page() {
    return view('auth.pages.dashboard');
  }

  public function logout() {
    Auth::logout();
    Session::flush();
    Session::save();
    return redirect()->route('pageLogin');
  }

  public function clearCache() {
    Artisan::call('optimize:clear');
    Artisan::call('event:cache');
    Artisan::call('view:cache');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    echo 'Cache successfully cleared and re-cached';
  }
}
