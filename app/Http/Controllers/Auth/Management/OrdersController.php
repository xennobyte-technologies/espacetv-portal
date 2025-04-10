<?php

namespace App\Http\Controllers\Auth\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class OrdersController extends Controller {
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

    $orders = [];
    $response = $this->api->get('orders', [
      'orderStatus' => 'active',
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $orders = $response->data->orders;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.orders')
      ->with('orders', $orders)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchOrders(Request $request) {
    $request->validate([
      'order-number' => 'nullable|numeric',
      'user-id' => 'nullable|uuid',
      'created-at' => 'nullable',
      'status' => 'nullable',
    ]);

    $orderNumber = $request->input('order-number');
    $orderUserId = $request->input('user-id');
    $orderCreatedAt = $request->input('created-at');
    $orderStatus = $request->input('status');
    $orderStartDate = $orderEndDate = null;

    $orders = [];
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
    } elseif ($orderUserId) {
      $endpoint = 'orders';
      $params = [
        'orderUserId' => $orderUserId,
        'limit' => 100,
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

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.orders')
      ->with('orders', $orders)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
