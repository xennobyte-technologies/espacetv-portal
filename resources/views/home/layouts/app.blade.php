<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
  <title>@yield('page-title') | {{ config('app.name', 'ESpaceTV Business Operating System') }}</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="{{ asset('assets/media/images/favicon.ico') }}" />
  <meta name="csrf-token" content="{{csrf_token()}}">
  @include('home.includes.styles')
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank">
  <!--begin::Root-->
  <div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-center flex-column flex-column-fluid">
      @include('home.includes.alerts')
      <div class="form-layout w-md-450px w-sm-400px w-350px">
        <!--begin::Header-->
        <!--begin::Languages-->
        <div class="language-switcher flex-end">
          <!--begin::Toggle-->
          <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
            @if(app()->getLocale() == 'cn')
            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('assets/media/images/flags/china.svg') }}" alt="简体中文" />
            @else
            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('assets/media/images/flags/united-states.svg') }}" alt="English" />
            @endif
            <span data-kt-element="current-lang-name" class="me-1"></span>
            <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
          </button>
          <!--end::Toggle-->
          <!--begin::Menu-->
          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
              <a href="{{ route('controllerSetLocale', 'en') }}" class="menu-link d-flex px-5" data-kt-lang="English">
                <span class="symbol symbol-20px me-4">
                  <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/images/flags/united-states.svg') }}" alt="English" />
                </span>
                <span data-kt-element="lang-name">English</span>
              </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
              <a href="{{ route('controllerSetLocale', 'cn') }}" class="menu-link d-flex px-5" data-kt-lang="简体中文">
                <span class="symbol symbol-20px me-4">
                  <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/images/flags/china.svg') }}" alt="简体中文" />
                </span>
                <span data-kt-element="lang-name">简体中文</span>
              </a>
            </div>
            <!--end::Menu item-->
          </div>
          <!--end::Menu-->
        </div>
        <!--end::Languages-->
        <div class="d-flex flex-center flex-column flex-lg-row flex-column-fluid p-5">
          <img src="{{ asset('assets/media/images/espacetv-logo.webp') }}" class="logo" alt="ESpaceTV Logo" />
        </div>
        <!--end::Header-->
        @yield('page-content')
      </div>
    </div>
    <!--end::Root-->
    @include('home.includes.scripts')
  </div>
</body>
<!--end::Body-->
</html>
