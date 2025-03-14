@inject('helpers', 'App\Library\Helpers')

<div class="menu-item">
  <!-- DASHBOARD -->
  <a class="menu-link {{ $helpers->getMenuActiveClass('pageDashboard', 'active') }}" href="{{ route('pageDashboard') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-layer-group"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.dashboard') }}</span>
  </a>
  <!-- end DASHBOARD -->

  <!-- ACCOUNT -->
  <div class="menu-item pt-5">
    <div class="menu-content"><span class="fw-bold text-white text-uppercase fs-7">{{ __('auth/sidebar.account.title') }}</span></div>
  </div>
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageAccountProfileAccountPassword', 'active') }}" href="{{ route('pageAccountProfileAccountPassword') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-shield"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.account.account-password') }}</span>
  </a>
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageAccountMyPayments', 'active') }}" href="{{ route('pageAccountMyPayments') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-file-invoice-dollar"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.account.my-payments') }}</span>
  </a>
  <!-- end ACCOUNT -->

  @if ($helpers->isAccessGroupAllowed(['administrator']))
  <!-- MANAGEMENT -->
  <div class="menu-item pt-5">
    <div class="menu-content"><span class="fw-bold text-white text-uppercase fs-7">{{ __('auth/sidebar.management.title') }}</span></div>
  </div>
  <!-- Users -->
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageManagementUsers,controllerManagementUsersSearchUsers', 'active') }}" href="{{ route('pageManagementUsers') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-users"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.management.users') }}</span>
  </a>
  <!-- Payments -->
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageManagementPayments,controllerManagementPaymentsSearchPayments', 'active') }}" href="{{ route('pageManagementPayments') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-dollar-sign"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.management.payments') }}</span>
  </a>
  <!-- Orders -->
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageManagementOrders,controllerManagementOrdersSearchOrders', 'active') }}" href="{{ route('pageManagementOrders') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-file-lines"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.management.orders') }}</span>
  </a>
  <!-- end MANAGEMENT -->
  @endif
</div>
