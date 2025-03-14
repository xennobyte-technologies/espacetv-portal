@extends('auth.layouts.app')

@section('page-title'){{ __('auth/account/my-payments.title') }} @endsection
@section('page-subtitle'){{ __('auth/account/my-payments.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(__('auth/account/my-payments')); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/account/my-payments.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/account/my-payments.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5"></div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <form method="POST" action="{{ route('controllerAccountMyPaymentsSearchMyPayments') }}">
          @csrf
          <div class="row">
            <!-- Payment Created At -->
            <div class="col-lg-6 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/account/my-payments.created-at') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-calendar-alt"></i></span>
                <input type="text" name="created-at" autocomplete="off" class="full-daterangepicker form-control" placeholder="{{ __('auth/account/my-payments.created-at-placeholder') }}" />
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
        <table id="account_my_payments_table" class="table table-striped border rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/account/my-payments.method') }}</th>
              <th>{{ __('auth/account/my-payments.amount') }}</th>
              <th>{{ __('auth/account/my-payments.credits') }}</th>
              <th>{{ __('auth/account/my-payments.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <td>{{ $count++ }}</td>
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