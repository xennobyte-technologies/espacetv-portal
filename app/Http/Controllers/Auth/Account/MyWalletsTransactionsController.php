<?php

namespace App\Http\Controllers\Auth\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class MyWalletsTransactionsController extends Controller {
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
    $walletTransactions = [];
    $walletsResponse = $this->api->get('wallets', [
      'walletUserId' => $this->userId,
      'limit' => 100,
    ]);
    if ($walletsResponse->statusCode === 200) {
      $wallets = $walletsResponse->data->wallets;
    }
    foreach ($wallets as $wallet) {
      $walletTransactionsResponse = $this->api->get('wallets/transactions', [
        'walletId' => $wallet->walletId,
        'limit' => 100,
      ]);
      if ($walletTransactionsResponse->statusCode === 200) {
        foreach (
          $walletTransactionsResponse->data->walletTransactions
          as $walletTransaction
        ) {
          array_push($walletTransactions, $walletTransaction);
        }
      }
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.account.my-wallets-transactions')
      ->with('walletTransactions', $walletTransactions)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchMyWalletsTransactions(Request $request) {
    $request->validate([
      'wallet-id' => 'nullable|uuid',
      'transaction-id' => 'nullable|uuid',
      'created-at' => 'nullable',
    ]);

    $walletId = $request->input('wallet-id');
    $walletTransactionId = $request->input('transaction-id');
    $walletTransactionCreatedAt = $request->input('created-at');
    $walletTransactionStartDate = $walletTransactionEndDate = null;

    $wallets = [];
    $walletTransactions = [];
    $endpoint = 'wallets/transactions';

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
    }

    if ($walletTransactionStartDate && $walletTransactionEndDate) {
      $params['walletTransactionStartDate'] = $walletTransactionStartDate;
      $params['walletTransactionEndDate'] = $walletTransactionEndDate;
    }

    $walletsResponse = $this->api->get('wallets', [
      'walletUserId' => $this->userId,
      'limit' => 100,
    ]);
    if ($walletsResponse->statusCode === 200) {
      $wallets = $walletsResponse->data->wallets;
    }
    foreach ($wallets as $wallet) {
      if ($walletId && $wallet->walletId !== $walletId) {
        continue;
      }
      $walletTransactionsResponse = $this->api->get(
        $endpoint,
        $walletId || $walletTransactionId
          ? $params
          : [
            'walletId' => $wallet->walletId,
            'limit' => 100,
          ],
      );
      if ($walletTransactionsResponse->statusCode === 200) {
        if (isset($walletTransactionsResponse->data->walletTransactions)) {
          foreach (
            $walletTransactionsResponse->data->walletTransactions
            as $walletTransaction
          ) {
            array_push($walletTransactions, $walletTransaction);
          }
        } elseif (
          isset($walletTransactionsResponse->data->walletTransaction) &&
          $walletTransactionsResponse->data->walletTransaction->walletId ===
            $wallet->walletId
        ) {
          array_push(
            $walletTransactions,
            $walletTransactionsResponse->data->walletTransaction,
          );
        }
      }
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.account.my-wallets-transactions')
      ->with('walletTransactions', $walletTransactions)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
