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
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageAccountMyPayments,controllerAccountMyPaymentsSearchMyPayments', 'active') }}" href="{{ route('pageAccountMyPayments') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-file-invoice-dollar"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.account.my-payments') }}</span>
  </a>
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageAccountMyOrders,controllerAccountMyOrdersSearchMyOrders', 'active') }}" href="{{ route('pageAccountMyOrders') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-file-invoice"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.account.my-orders') }}</span>
  </a>
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageAccountMyWallets', 'active') }}" href="{{ route('pageAccountMyWallets') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-wallet"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.account.my-wallets') }}</span>
  </a>
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageAccountMyWalletsTransactions,controllerAccountMyWalletsTransactionsSearchMyWalletsTransactions', 'active') }}" href="{{ route('pageAccountMyWalletsTransactions') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-file-lines"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.account.my-wallets-transactions') }}</span>
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
      <i class="fa-solid fa-file-invoice"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.management.orders') }}</span>
  </a>
  <!-- Wallets -->
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageManagementWallets,controllerManagementWalletsSearchWallets', 'active') }}" href="{{ route('pageManagementWallets') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-wallet"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.management.wallets') }}</span>
  </a>
  <!-- Wallets Transactions -->
  <a class="menu-link mb-2 {{ $helpers->getMenuActiveClass('pageManagementWalletsTransactions,controllerManagementWalletsTransactionsSearchWalletsTransactions', 'active') }}" href="{{ route('pageManagementWalletsTransactions') }}">
    <span class="menu-icon">
      <i class="fa-solid fa-file-lines"></i>
    </span>
    <span class="menu-title">{{ __('auth/sidebar.management.wallets-transactions') }}</span>
  </a>
  <!-- end MANAGEMENT -->
  @endif
</div>
