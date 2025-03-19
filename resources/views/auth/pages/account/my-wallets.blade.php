@extends('auth.layouts.app')

@section('page-title'){{ __('auth/account/my-wallets.title') }} @endsection
@section('page-subtitle'){{ __('auth/account/my-wallets.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(__('auth/account/my-wallets')); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/account/my-wallets.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/account/my-wallets.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5"></div>
      </div>
      <div class="card-body">
        <!-- Datatable -->
        <table id="account_my_wallets_table" class="table table-striped bwallet rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/account/my-wallets.wallet-id') }}</th>
              <th>{{ __('auth/account/my-wallets.balance') }}</th>
              <th>{{ __('auth/account/my-wallets.type') }}</th>
              <th>{{ __('auth/account/my-wallets.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wallets as $wallet)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $wallet->walletId }}</td>
              <td>
                {{ $helpers->getCurrencyFormat($wallet->walletBalance) }}
              </td>
              <td>{{ $helpers->toTitle($wallet->walletType) }}</td>
              <td>{{ $helpers->formatDateTime($wallet->walletCreatedAt) }}</td>
              <td>
                <span class="badge {{ $helpers->getCommonStatus($wallet->walletStatus)['class'] }} p-3">
                  {{ $helpers->getCommonStatus($wallet->walletStatus)['name'] }}
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