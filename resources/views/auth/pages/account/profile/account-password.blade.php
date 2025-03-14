@extends('auth.layouts.app')

@section('page-title'){{ __('auth/account/profile/account-password.title') }} @endsection
@section('page-subtitle'){{ __('auth/account/profile/account-password.description') }} @endsection

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <form method="POST" action="{{ route('controllerAccountPasswordUpdatePassword') }}">
        @csrf
        <div class="card-header">
          <h3 class="card-title">{{ __('auth/account/profile/account-password.title') }}</h3>
        </div>
        <div class="card-body row">
          <div class="col-lg-4 col-md-12 mb-7">
            <label class="required form-label">{{ __('auth/account/profile/account-password.current-password') }}</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="current-password" class="form-control" placeholder="{{ __('auth/account/profile/account-password.current-password-placeholder') }}" />
            </div>
          </div>

          <div class="col-lg-4 col-md-12 mb-7">
            <label class="required form-label">{{ __('auth/account/profile/account-password.new-password') }}</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="new-password" class="form-control" placeholder="{{ __('auth/account/profile/account-password.new-password-placeholder') }}" />
            </div>
          </div>

          <div class="col-lg-4 col-md-12 mb-7">
            <label class="required form-label">{{ __('auth/account/profile/account-password.confirm-new-password') }}</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="confirm-new-password" class="form-control" placeholder="{{ __('auth/account/profile/account-password.confirm-new-password-placeholder') }}" />
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary-theme me-2"><i class="fa-solid fa-paper-plane fs-4"></i> {{ __('auth/common.update') }}</button>
          <button type="reset" class="btn btn-danger"><i class="fa-solid fa-redo-alt fs-4"></i> {{ __('auth/common.reset') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
