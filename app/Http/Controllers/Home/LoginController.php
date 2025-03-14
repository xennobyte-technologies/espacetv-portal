<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class LoginController extends Controller {
  public function page() {
    return view('home.pages.login');
  }

  public function login(Request $request) {
    $request->validate([
      'email' => 'required|email:rfc,dns',
      'password' => 'required',
    ]);

    $email = $request->input('email');
    $password = $request->input('password');

    $payload = [
      'userEmail' => $email,
      'userPassword' => $password,
    ];

    $api = new ApiController();
    $response = $api->post('auth/login', $payload);
    if ($response->statusCode === 200) {
      $user = $response->data->user;
      $session = $request->session();
      $session->put('user.id', $user->userId);
      $session->put('user.referrerId', $user->userReferrerId);
      $session->put('user.name', $user->userName);
      $session->put('user.email', $user->userEmail);
      $session->put('user.accessGroup', $user->userAccessGroup);
      $session->save();

      $expireIn1Hour = time() + 3600;
      $expireIn7Days = time() + 7 * 24 * 60 * 60;

      setcookie(
        'accessToken',
        $response->data->accessToken,
        $expireIn1Hour,
        '/',
      );
      setcookie(
        'refreshToken',
        $response->data->refreshToken,
        $expireIn7Days,
        '/',
      );

      return redirect()->route('pageDashboard');
    }

    return redirect()
      ->back()
      ->with('error', __('login.invalid-password'));
  }
}
