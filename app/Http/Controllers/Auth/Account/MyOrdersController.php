<?php

namespace App\Http\Controllers\Auth\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class MyOrdersController extends Controller {
  private $helpers = null,
    $userId = null,
    $api = null;

  public function __construct() {
    $this->userId = session('user.id');
    $this->helpers = new Helpers();
    $this->api = new ApiController();
  }

  public function page() {
    $orders = [];
    $response = $this->api->get('orders', [
      'orderUserId' => $this->userId,
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $orders = $response->data->orders;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.account.my-orders')
      ->with('orders', $orders)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchMyOrders(Request $request) {
    $request->validate([
      'order-number' => 'nullable|numeric',
      'user-id' => 'nullable|uuid',
      'created-at' => 'nullable',
      'status' => 'nullable',
    ]);

    $orderNumber = $request->input('order-number');
    $orderCreatedAt = $request->input('created-at');
    $orderStatus = $request->input('status');
    $orderStartDate = $orderEndDate = null;

    $filteredOrders = $orders = [];
    $endpoint = 'orders';
    $params = [
      'orderStatus' => 'active',
      'limit' => 100,
    ];

    if ($orderCreatedAt) {
      $orderCreatedAt = explode(' - ', $orderCreatedAt);
      $orderStartDate =
        $this->helpers->formatDateTime($orderCreatedAt[0], 'UTC ISO') .
        'T00:00:00.000Z';
      $orderEndDate =
        $this->helpers->formatDateTime($orderCreatedAt[1], 'UTC ISO') .
        'T11:59:59.999Z';
    }

    if ($orderNumber) {
      $endpoint = 'orders/search';
      $params = [
        'orderNumber' => $orderNumber,
      ];
    } elseif ($orderStatus) {
      $endpoint = 'orders';
      $params = [
        'orderStatus' => $orderStatus,
        'limit' => 100,
      ];
    }

    if ($endpoint === 'orders' && $orderStartDate && $orderEndDate) {
      $params['orderStartDate'] = $orderStartDate;
      $params['orderEndDate'] = $orderEndDate;
    }

    $response = $this->api->get($endpoint, $params);
    if ($response->statusCode === 200) {
      $orders = isset($response->data->orders)
        ? $response->data->orders
        : [$response->data->order];
    }

    foreach ($orders as $order) {
      if ($order->orderUserId !== $this->userId) {
        continue;
      }
      array_push($filteredOrders, $order);
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.account.my-orders')
      ->with('orders', $filteredOrders)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
