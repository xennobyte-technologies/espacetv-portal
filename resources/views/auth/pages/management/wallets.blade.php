@extends('auth.layouts.app')

@section('page-title'){{ __('auth/management/wallets.title') }} @endsection
@section('page-subtitle'){{ __('auth/management/wallets.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(__('auth/management/wallets')); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/management/wallets.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/management/wallets.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5"></div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <form method="POST" action="{{ route('controllerManagementWalletsSearchWallets') }}">
          @csrf
          <div class="row">
            <!-- Wallet User Id -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/wallets.user-id') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="user-id" class="form-control" placeholder="{{ __('auth/management/wallets.user-id-placeholder') }}" />
              </div>
            </div>

            <!-- Wallet Created At -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/wallets.created-at') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-calendar-alt"></i></span>
                <input type="text" name="created-at" autocomplete="off" class="full-daterangepicker form-control" placeholder="{{ __('auth/management/wallets.created-at-placeholder') }}" />
              </div>
            </div>

            <!-- Status -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/common.status') }}</label>
              <div class="input-group flex-nowrap">
                <span class="input-group-text">
                  <i class="fa-solid fa-check-circle"></i>
                </span>
                <div class="overflow-hidden flex-grow-1">
                  <select name="status" class="form-select rounded-start-0" data-control="select2" data-placeholder="{{ __('auth/common.status-placeholder') }}">
                    <option value=""></option>
                    @foreach($statuses as $status)
                    <option value="{{ $status['value'] }}">{{ $status['name'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary-theme me-2"><i class="fa-solid fa-search fs-4"></i> {{ __('auth/common.search') }}</button>
          <button type="reset" class="btn btn-danger me-2"><i class="fa-solid fa-redo-alt fs-4"></i> {{ __('auth/common.reset') }}</button>
        </form>
        <!-- End Search Form -->

        <div class="col-lg-12 my-7">
          <div class="separator bwallet-2"></div>
        </div>

        <!-- Datatable -->
        <table id="management_wallets_table" class="table table-striped bwallet rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/management/wallets.wallet-id') }}</th>
              <th>{{ __('auth/management/wallets.user-id') }}</th>
              <th>{{ __('auth/management/wallets.balance') }}</th>
              <th>{{ __('auth/management/wallets.type') }}</th>
              <th>{{ __('auth/management/wallets.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wallets as $wallet)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $wallet->walletId }}</td>
              <td>{{ $wallet->walletUserId }}</td>
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