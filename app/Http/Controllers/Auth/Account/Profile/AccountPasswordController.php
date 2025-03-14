<?php

namespace App\Http\Controllers\Auth\Account\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Encryption;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class AccountPasswordController extends Controller {
  private $helpers = null;

  public function __construct() {
    $this->helpers = new Helpers();
  }

  public function page() {
    return view('auth.pages.account.profile.account-password');
  }

  public function updatePassword(Request $request) {
    $request->validate([
      'current-password' => 'required|min:6|max:30',
      'new-password' =>
        'required|min:6|max:30|required_with:confirm-new-password|same:confirm-new-password',
      'confirm-new-password' => 'required|min:6|max:30',
    ]);

    $currentPassword = $request->input('current-password');
    $newPassword = $request->input('new-password');

    if (strcmp($currentPassword, $newPassword) === 0) {
      return redirect()
        ->back()
        ->with(
          'error',
          __('auth/account/profile/account-password.new-password-same'),
        );
    }

    $userId = session('user.id');
    $payload = [
      'userPassword' => $newPassword,
    ];

    $api = new ApiController();
    $response = $api->patch('users/' . $userId, $payload);

    if (isset($response->user)) {
      return redirect()
        ->back()
        ->with(
          'success',
          __('auth/account/profile/account-password.update-password-success'),
        );
    }

    return redirect()
      ->back()
      ->with(
        'error',
        __('auth/account/profile/account-password.update-password-failed'),
      );
  }
}
