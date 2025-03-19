<?php

namespace App\Http\Controllers\Auth\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class WalletsController extends Controller {
  private $helpers = null,
    $api = null;

  public function __construct() {
    $this->helpers = new Helpers();
    $this->api = new ApiController();
  }

  public function page() {
    $allowedAccessGroups = ['administrator'];
    if (!$this->helpers->isAccessGroupAllowed($allowedAccessGroups)) {
      return redirect()
        ->route('pageDashboard')
        ->with('error', __('auth/common.permission-denied'));
    }

    $wallets = [];
    $response = $this->api->get('wallets', [
      'walletStatus' => 'active',
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $wallets = $response->data->wallets;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.wallets')
      ->with('wallets', $wallets)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchWallets(Request $request) {
    $request->validate([
      'user-id' => 'nullable|uuid',
      'created-at' => 'nullable',
      'status' => 'nullable',
    ]);

    $walletUserId = $request->input('user-id');
    $walletCreatedAt = $request->input('created-at');
    $walletStatus = $request->input('status');
    $walletStartDate = $walletEndDate = null;

    $wallets = [];
    $endpoint = 'wallets';
    $params = [
      'walletStatus' => 'active',
      'limit' => 100,
    ];

    if ($walletCreatedAt) {
      $walletCreatedAt = explode(' - ', $walletCreatedAt);
      $walletStartDate =
        $this->helpers->formatDateTime($walletCreatedAt[0], 'UTC ISO') .
        'T00:00:00.000Z';
      $walletEndDate =
        $this->helpers->formatDateTime($walletCreatedAt[1], 'UTC ISO') .
        'T11:59:59.999Z';
    }

    if ($walletUserId) {
      $params = [
        'walletUserId' => $walletUserId,
        'limit' => 100,
      ];
    } elseif ($walletStatus) {
      $params = [
        'walletStatus' => $walletStatus,
        'limit' => 100,
      ];
    }

    if ($walletStartDate && $walletEndDate) {
      $params['walletStartDate'] = $walletStartDate;
      $params['walletEndDate'] = $walletEndDate;
    }

    $response = $this->api->get($endpoint, $params);
    if ($response->statusCode === 200) {
      $wallets = $response->data->wallets;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.wallets')
      ->with('wallets', $wallets)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
