@extends('auth.layouts.app')

@section('page-title'){{ __('auth/management/payments.title') }} @endsection
@section('page-subtitle'){{ __('auth/management/payments.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(__('auth/management/payments')); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/management/payments.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/management/payments.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5"></div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <form method="POST" action="{{ route('controllerManagementPaymentsSearchPayments') }}">
          @csrf
          <div class="row">
            <!-- Payment Created At -->
            <div class="col-lg-6 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/payments.created-at') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-calendar-alt"></i></span>
                <input type="text" name="created-at" autocomplete="off" class="full-daterangepicker form-control" placeholder="{{ __('auth/management/payments.created-at-placeholder') }}" />
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary-theme me-2"><i class="fa-solid fa-search fs-4"></i> {{ __('auth/common.search') }}</button>
          <button type="reset" class="btn btn-danger me-2"><i class="fa-solid fa-redo-alt fs-4"></i> {{ __('auth/common.reset') }}</button>
        </form>
        <!-- End Search Form -->

        <div class="col-lg-12 my-7">
          <div class="separator border-2"></div>
        </div>

        <!-- Datatable -->
        <table id="management_payments_table" class="table table-striped border rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/management/payments.payment-id') }}</th>
              <th>{{ __('auth/management/payments.user-id') }}</th>
              <th>{{ __('auth/management/payments.wallet-id') }}</th>
              <th>{{ __('auth/management/payments.stripe-intent-id') }}</th>
              <th>{{ __('auth/management/payments.method') }}</th>
              <th>{{ __('auth/management/payments.amount') }}</th>
              <th>{{ __('auth/management/payments.credits') }}</th>
              <th>{{ __('auth/management/payments.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $payment->paymentId }}</td>
              <td>{{ $payment->paymentUserId }}</td>
              <td>{{ $payment->paymentWalletId }}</td>
              <td>{{ $payment->paymentIntentId }}</td>
              <td>{{ $helpers->toTitle($payment->paymentMethodType) }}</td>
              <td>{{ $helpers->toUpper($payment->paymentCurrency) }} {{ $helpers->getCurrencyFormat($payment->paymentAmount) }}</td>
              <td>{{ $helpers->getCurrencyFormat($payment->paymentCredits) }}</td>
              <td>{{ $helpers->formatDateTime($payment->paymentCreatedAt) }}</td>
              <td>
                <span class="badge {{ $helpers->getPaymentStatus($payment->paymentStatus)['class'] }} p-3">
                  {{ $helpers->getPaymentStatus($payment->paymentStatus)['name'] }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection