<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
  <title>@yield('page-title') | {{ config('app.name', 'ESpaceTV Business Operating System') }}</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="{{ asset('assets/media/images/favicon.ico') }}" />
  <meta name="csrf-token" content="{{csrf_token()}}">
  @include('auth.includes.styles')
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
  <!--begin::App-->
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid " id="kt_app_page">
      <!--begin::Header-->
      <div id="kt_app_header" class="app-header ">
        <!--begin::Header container-->
        <div class="app-container bg-dark container-fluid d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
          <!--begin::Sidebar mobile toggle-->
          <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
              <i class="fa-solid fa-bars fs-2 fs-md-1"></i>
            </div>
          </div>
          <!--end::Sidebar mobile toggle-->

          <!--begin::Mobile logo-->
          <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('pageDashboard') }}" class="d-lg-none">
              <img alt="Logo" src="{{ asset('assets/media/images/espacetv-logo.webp') }}" class="h-35px" />
            </a>
          </div>
          <!--end::Mobile logo-->

          <!--begin::Header wrapper-->
          <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
              <!--begin::Menu-->
              <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
              </div>
              <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
              <!--begin::Languages-->
              <div class="language-switcher">
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

              <!--begin::User menu-->
              <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                  <img src="{{ asset('assets/media/images/avatar.png') }}" alt="user" />
                </div>

                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                  <!--begin::Menu item-->
                  <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                      <!--begin::Avatar-->
                      <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="{{ asset('assets/media/images/avatar.png') }}" />
                      </div>
                      <!--end::Avatar-->

                      <!--begin::Username-->
                      <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                          {{ session('user.name') }}
                        </div>

                        <span class="fw-semibold text-gray-600 text-hover-primary fs-7">
                          {{ session('user.email') }}
                        </span>
                      </div>
                      <!--end::Username-->
                    </div>
                  </div>
                  <!--end::Menu item-->

                  <!--begin::Menu separator-->
                  <div class="separator my-2"></div>
                  <!--end::Menu separator-->

                  <!--begin::Menu item-->
                  <div class="menu-item px-5">
                    <a href="{{route('controllerLogout')}}" class="menu-link px-5">
                      {{ __('auth/common.logout') }}
                    </a>
                  </div>
                  <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
              </div>
              <!--end::User menu-->
            </div>
            <!--end::Navbar-->
          </div>
          <!--end::Header wrapper-->
        </div>
        <!--end::Header container-->
      </div>
      <!--end::Header-->
      <!--begin::Wrapper-->
      <div class="app-wrapper flex-column flex-row-fluid " id="kt_app_wrapper">
        <!--begin::Sidebar-->
        <div id="kt_app_sidebar" class="app-sidebar bg-dark flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
          <!--begin::Logo-->
          <div class="app-sidebar-logo bg-dark px-6" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            <a href="{{ route('pageDashboard') }}">
              <img alt="Logo" src="{{ asset('assets/media/images/espacetv-logo.webp') }}" class="h-45px app-sidebar-logo-default" />
              <span style="font-size: 20px;margin-left: 10px;color: #fff;">ESpaceTV</span>
            </a>
            <!--end::Logo image-->
          </div>
          <!--end::Logo-->
          <!--begin::sidebar menu-->
          <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y py-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="false">
              <div class="employee-profile">
                <img src="{{ asset('assets/media/images/avatar.png') }}" alt="avatar" />
                <div class="employee-info">
                  <div class="employee-name">{{session('user.name')}}</div>
                  <div class="employee-access-group mb-2">{{session('user.accessGroup')}}</div>
                  <div class="badge badge-danger py-2">{{session('user.referrerId')}}</div>
                </div>
              </div>
              <!--begin::Menu-->
              <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                @include('auth.layouts.sidebar')
              </div>
              <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
          </div>
          <!--end::sidebar menu-->
        </div>
        <!--end::Sidebar-->

        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <!--begin::Content wrapper-->
          <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar bg-white py-3 py-lg-4">
              <!--begin::Toolbar container-->
              <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack ">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-row-fluid flex-wrap me-3 ">
                  <!--begin::Title-->
                  <h5 class="page-heading d-flex text-dark fw-semibold fs-3 flex-column justify-content-center my-0">
                    @yield('page-title')
                  </h5>
                  <!--end::Title-->
                  <!--begin::Page Description-->
                  <div class="d-none d-lg-flex d-xl-flex flex-column justify-content-center subheader-separator subheader-separator-ver mx-5 bg-gray-200"></div>
                  <span class="d-none d-lg-flex d-xl-flex flex-column justify-content-center text-muted fw-medium mr-4">@yield('page-subtitle')</span>
                  <!--end::Page Description-->
                </div>
                <!--end::Page title-->
              </div>
              <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
              <div id="kt_app_content_container" class="app-container container-fluid mt-10">
                @include('auth.includes.alerts')
                @yield('page-content')
              </div>
            </div>
            <!--end::Content-->
          </div>
          <!--end::Content wrapper-->
          @include('auth.layouts.footer')
        </div>
        <!--end:::Main-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Page-->
  </div>
  <!--end::App-->

  <!--begin::Scrolltop-->
  <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i></div>
  <!--end::Scrolltop-->

  @include('auth.includes.scripts')
  @yield('javascript')
</body>
<!--end::Body-->
</html>
