@extends('home.layouts.app')

@section('page-title'){{ __('login.form-title') }} @endsection

@section('page-content')
<!--begin::Form-->
<div class="d-flex flex-center flex-column flex-lg-row-fluid">
  <!--begin::Wrapper-->
  <div class="p-7 w-md-425px w-sm-375px w-325px">
    <!--begin::Form-->
    <form class="form" action="{{ route('controllerLogin') }}" method="POST">
      @csrf
      <!--begin::Heading-->
      <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-semibold mb-3">{{ __('login.form-title') }}</h1>
        <!--end::Title-->
        <!--begin::Subtitle-->
        <div class="text-black fw-normal fs-6 fst-italic">{{ __('login.form-subtitle') }}</div>
        <!--end::Subtitle=-->
      </div>
      <!--begin::Heading-->
      <!--begin::Input group-->
      <div class="form-floating mb-7">
        <input type="email" name="email" class="form-control bg-gray-100" placeholder="example@gemilang.group" />
        <label>{{ __('login.email-address') }}</label>
      </div>
      <!--end::Input group-->
      <!--begin::Input group-->
      <div class="form-floating mb-7">
        <input type="password" name="password" class="form-control bg-gray-100" placeholder="password" />
        <label>{{ __('login.password') }}</label>
      </div>
      <!--end::Input group-->
      <!--begin::Wrapper-->
      <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
        <div></div>
      </div>
      <!--end::Wrapper-->
      <!--begin::Submit button-->
      <div class="d-grid mb-10">
        <button type="submit" class="btn btn-primary-theme rounded-pill">{{ __('login.login') }}</button>
      </div>
      <!--end::Submit button-->
    </form>
    <!--end::Form-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Form-->
</div>
<!--end::Body-->
@endsection
