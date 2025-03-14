@extends('auth.layouts.app')

@section('page-title'){{ __('auth/management/orders.title') }} @endsection
@section('page-subtitle'){{ __('auth/management/orders.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(__('auth/management/orders')); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/management/orders.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/management/orders.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
          <button type="button" class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#add_order_modal">
            <i class="fa-solid fa-plus"></i>
            {{ __('auth/management/orders.add-order') }}
          </button>
        </div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <form method="POST" action="{{ route('controllerManagementOrdersSearchOrders') }}">
          @csrf
          <div class="row">
            <!-- Order Number -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/orders.order-number') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-file-lines"></i></span>
                <input type="text" name="order-number" class="form-control" placeholder="{{ __('auth/management/orders.order-number-placeholder') }}" />
              </div>
            </div>

            <!-- Order User Id -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/orders.user-id') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="user-id" class="form-control" placeholder="{{ __('auth/management/orders.user-id-placeholder') }}" />
              </div>
            </div>

            <!-- Order Category Id -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/orders.category-id') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-star"></i></span>
                <input type="text" name="category-id" class="form-control" placeholder="{{ __('auth/management/orders.category-id-placeholder') }}" />
              </div>
            </div>

            <!-- Order Created At -->
            <div class="col-lg-6 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/orders.created-at') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-calendar-alt"></i></span>
                <input type="text" name="created-at" autocomplete="off" class="full-daterangepicker form-control" placeholder="{{ __('auth/management/orders.created-at-placeholder') }}" />
              </div>
            </div>

            <!-- Status -->
            <div class="col-lg-6 col-md-12 mb-7">
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
          <div class="separator border-2"></div>
        </div>

        <!-- Datatable -->
        <table id="management_orders_table" class="table table-striped border rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/management/orders.order-id') }}</th>
              <th>{{ __('auth/management/orders.order-number') }}</th>
              <th>{{ __('auth/management/orders.user-id') }}</th>
              <th>{{ __('auth/management/orders.category-type') }}</th>
              <th>{{ __('auth/management/orders.category-id') }}</th>
              <th>{{ __('auth/management/orders.amount') }}</th>
              <th>{{ __('auth/management/orders.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
              <th class="min-w-150px">{{ __('auth/common.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            @if ($order->orderId !== session('order.id'))
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $order->orderId }}</td>
              <td>
                <span class="badge badge-info text-white p-3">
                  {{ $order->orderNumber }}
                </span>
              </td>
              <td>{{ $order->orderUserId }}</td>
              <td>{{ $helpers->toTitle($order->orderCategoryType) }}</td>
              <td>{{ $order->orderCategoryId }}</td>
              <td>
                {{ $helpers->getCurrencyFormat($order->orderAmount) }}
              </td>
              <td>{{ $helpers->formatDateTime($order->orderCreatedAt) }}</td>
              <td>
                <span class="badge {{ $helpers->getCommonStatus($order->orderStatus)['class'] }} p-3">
                  {{ $helpers->getCommonStatus($order->orderStatus)['name'] }}
                </span>
              </td>
              <td>
                <button type="button" data-id="{{ $order->orderId }}" data-bs-toggle="modal" data-bs-target="#edit_order_modal" class="btn btn-sm btn-icon btn-info"><i class="fa-solid fa-pen-to-square fs-4"></i></button>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection