<?php

namespace App\Http\Controllers\Auth\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class MyWalletsController extends Controller {
  private $helpers = null,
    $userId = null,
    $api = null;

  public function __construct() {
    $this->userId = session('user.id');
    $this->helpers = new Helpers();
    $this->api = new ApiController();
  }

  public function page() {
    $wallets = [];
    $response = $this->api->get('wallets', [
      'walletUserId' => $this->userId,
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $wallets = $response->data->wallets;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.account.my-wallets')
      ->with('wallets', $wallets)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
