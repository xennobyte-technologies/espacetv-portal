@extends('auth.layouts.app')

@section('page-title'){{ __('auth/account/my-wallets-transactions.title') }} @endsection
@section('page-subtitle'){{ __('auth/account/my-wallets-transactions.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(
    __('auth/account/my-wallets-transactions'),
  ); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/account/my-wallets-transactions.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/account/my-wallets-transactions.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5"></div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <form method="POST" action="{{ route('controllerAccountMyWalletsTransactionsSearchMyWalletsTransactions') }}">
          @csrf
          <div class="row">
            <!-- Wallet Id -->
            <div class="col-lg-6 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/account/my-wallets-transactions.wallet-id') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-wallet"></i></span>
                <input type="text" name="wallet-id" class="form-control" placeholder="{{ __('auth/account/my-wallets-transactions.wallet-id-placeholder') }}" />
              </div>
            </div>

            <!-- Wallet Transaction Id -->
            <div class="col-lg-6 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/account/my-wallets-transactions.transaction-id') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-file-lines"></i></span>
                <input type="text" name="transaction-id" class="form-control" placeholder="{{ __('auth/account/my-wallets-transactions.transaction-id-placeholder') }}" />
              </div>
            </div>

            <!-- Wallet Transaction Created At -->
            <div class="col-lg-6 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/account/my-wallets-transactions.created-at') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-calendar-alt"></i></span>
                <input type="text" name="created-at" autocomplete="off" class="full-daterangepicker form-control" placeholder="{{ __('auth/account/my-wallets-transactions.created-at-placeholder') }}" />
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary-theme me-2"><i class="fa-solid fa-search fs-4"></i> {{ __('auth/common.search') }}</button>
          <button type="reset" class="btn btn-danger me-2"><i class="fa-solid fa-redo-alt fs-4"></i> {{ __('auth/common.reset') }}</button>
        </form>
        <!-- End Search Form -->

        <div class="col-lg-12 my-7">
          <div class="separator bordered-2"></div>
        </div>

        <!-- Datatable -->
        <table id="account_my_wallets_transactions_table" class="table table-striped bordered rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/account/my-wallets-transactions.transaction-id') }}</th>
              <th>{{ __('auth/account/my-wallets-transactions.wallet-id') }}</th>
              <th>{{ __('auth/account/my-wallets-transactions.amount') }}</th>
              <th>{{ __('auth/account/my-wallets-transactions.category-id') }}</th>
              <th>{{ __('auth/account/my-wallets-transactions.category-type') }}</th>
              <th>{{ __('auth/account/my-wallets-transactions.transaction-type') }}</th>
              <th>{{ __('auth/account/my-wallets-transactions.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($walletTransactions as $walletTransaction)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $walletTransaction->walletTransactionId }}</td>
              <td>{{ $walletTransaction->walletId }}</td>
              <td>
                {{ $helpers->getCurrencyFormat($walletTransaction->walletTransactionAmount) }}
              </td>
              <td>{{ $walletTransaction->walletTransactionCategoryId }}</td>
              <td>{{ $helpers->toTitle($walletTransaction->walletTransactionCategoryType) }}</td>
              <td>{{ $helpers->toTitle($walletTransaction->walletTransactionType) }}</td>
              <td>{{ $helpers->formatDateTime($walletTransaction->walletTransactionCreatedAt) }}</td>
              <td>
                <span class="badge {{ $helpers->getCommonStatus($walletTransaction->walletTransactionStatus)['class'] }} p-3">
                  {{ $helpers->getCommonStatus($walletTransaction->walletTransactionStatus)['name'] }}
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