<?php

namespace App\Http\Controllers\Auth\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class PaymentsController extends Controller {
  private $helpers = null,
    $api = null;

  public function __construct() {
    $this->helpers = new Helpers();
    $this->api = new ApiController();
  }

  public function page() {
    $payments = [];
    $response = $this->api->get('payments', [
      'paymentStatus' => 'succeeded',
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $payments = $response->data->payments;
    }

    $statuses = $this->helpers->getPaymentStatus();

    return view('auth.pages.management.payments')
      ->with('payments', $payments)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchPayments(Request $request) {
    $request->validate([
      'created-at' => 'nullable',
    ]);

    $paymentCreatedAt = $request->input('created-at');
    $paymentStartDate = $paymentEndDate = null;

    if ($paymentCreatedAt) {
      $paymentCreatedAt = explode(' - ', $paymentCreatedAt);
      $paymentStartDate =
        $this->helpers->formatDateTime($paymentCreatedAt[0], 'UTC ISO') .
        'T00:00:00.000Z';
      $paymentEndDate =
        $this->helpers->formatDateTime($paymentCreatedAt[1], 'UTC ISO') .
        'T11:59:59.999Z';
    }

    $payments = [];
    $payload = [
      'paymentStatus' => 'succeeded',
      'limit' => 100,
    ];

    if ($paymentStartDate && $paymentEndDate) {
      $payload['paymentStartDate'] = $paymentStartDate;
      $payload['paymentEndDate'] = $paymentEndDate;
    }

    $response = $this->api->get('payments', $payload);

    if ($response->statusCode === 200) {
      $payments = $response->data->payments;
    }

    $statuses = $this->helpers->getPaymentStatus();

    return view('auth.pages.management.payments')
      ->with('payments', $payments)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }
}
