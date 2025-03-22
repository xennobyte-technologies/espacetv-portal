<?php

namespace App\Http\Controllers\Auth\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class WalletsTransactionsController extends Controller {
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

    $walletTransactions = [];
    $response = $this->api->get('wallets/transactions', [
      'walletTransactionStatus' => 'active',
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $walletTransactions = $response->data->walletTransactions;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.wallets-transactions')
      ->with('walletTransactions', $walletTransactions)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchWalletsTransactions(Request $request) {
    $request->validate([
      'wallet-id' => 'nullable|uuid',
      'transaction-id' => 'nullable|uuid',
      'created-at' => 'nullable',
      'status' => 'nullable',
    ]);

    $walletId = $request->input('wallet-id');
    $walletTransactionId = $request->input('transaction-id');
    $walletTransactionCreatedAt = $request->input('created-at');
    $walletTransactionStatus = $request->input('status');
    $walletTransactionStartDate = $walletTransactionEndDate = null;

    $walletTransactions = [];
    $endpoint = 'wallets/transactions';
    $params = [
      'walletTransactionStatus' => 'active',
      'limit' => 100,
    ];

    if ($walletTransactionCreatedAt) {
      $walletTransactionCreatedAt = explode(' - ', $walletTransactionCreatedAt);
      $walletTransactionStartDate =
        $this->helpers->formatDateTime(
          $walletTransactionCreatedAt[0],
          'UTC ISO',
        ) . 'T00:00:00.000Z';
      $walletTransactionEndDate =
        $this->helpers->formatDateTime(
          $walletTransactionCreatedAt[1],
          'UTC ISO',
        ) . 'T11:59:59.999Z';
    }

    if ($walletId) {
      $params = [
        'walletId' => $walletId,
        'limit' => 100,
      ];
    } elseif ($walletTransactionId) {
      $endpoint = 'wallets/transactions/search';
      $params = [
        'walletTransactionId' => $walletTransactionId,
      ];
    } elseif ($walletTransactionStatus) {
      $params = [
        'walletTransactionStatus' => $walletTransactionStatus,
      ];
    }

    if ($walletTransactionStartDate && $walletTransactionEndDate) {
      $params['walletTransactionStartDate'] = $walletTransactionStartDate;
      $params['walletTransactionEndDate'] = $walletTransactionEndDate;
    }

    $response = $this->api->get($endpoint, $params);
    if ($response->statusCode === 200) {
      $walletTransactions = isset($response->data->walletTransactions)
        ? $response->data->walletTransactions
        : [$response->data->walletTransaction];
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.wallets-transactions')
      ->with('walletTransactions', $walletTransactions)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
