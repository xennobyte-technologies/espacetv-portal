@extends('auth.layouts.app')

@section('page-title'){{ __('auth/management/users.title') }} @endsection
@section('page-subtitle'){{ __('auth/management/users.description') }} @endsection
@section('javascript')
<script>
  var language = '<?php echo json_encode(__('auth/management/users')); ?>';
  var languageCommon = '<?php echo json_encode(__('auth/common')); ?>';

</script>
<script src="{{ asset('assets/js/auth/management/users.js') }}"></script>
@endsection

@inject('helpers', 'App\Library\Helpers')

@section('page-content')
<div class="row gx-5 gx-xl-10">
  <div class="mb-5">
    <div class="card card-bordered">
      <div class="card-header">
        <h3 class="card-title">{{ __('auth/management/users.title') }}</h3>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
          <button type="button" class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#add_user_modal">
            <i class="fa-solid fa-plus"></i>
            {{ __('auth/management/users.add-user') }}
          </button>
        </div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <form method="POST" action="{{ route('controllerManagementUsersSearchUsers') }}">
          @csrf
          <div class="row">
            <!-- User Name -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/users.referrer-id') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="referrer-id" class="form-control" placeholder="{{ __('auth/management/users.referrer-id-placeholder') }}" />
              </div>
            </div>

            <!-- User Email -->
            <div class="col-lg-4 col-md-12 mb-7">
              <label class="form-label mb-2">{{ __('auth/management/users.email') }}</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="text" name="email" class="form-control" placeholder="{{ __('auth/management/users.email-placeholder') }}" />
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
          <div class="separator border-2"></div>
        </div>

        <!-- Datatable -->
        <table id="management_users_table" class="table table-striped border rounded gy-5 gs-7">
          <thead class="table-dark">
            <tr class="fw-semibold fs-6 text-white">
              <th>#</th>
              <th data-priority="1">{{ __('auth/management/users.user-id') }}</th>
              <th>{{ __('auth/management/users.referrer-id') }}</th>
              <th>{{ __('auth/management/users.name') }}</th>
              <th>{{ __('auth/management/users.email') }}</th>
              <th>{{ __('auth/management/users.access-group') }}</th>
              <th>{{ __('auth/management/users.referral-id') }}</th>
              <th>{{ __('auth/management/users.created-at') }}</th>
              <th>{{ __('auth/common.status') }}</th>
              <th class="min-w-150px">{{ __('auth/common.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            @if ($user->userId !== session('user.id'))
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $user->userId }}</td>
              <td>
                <span class="badge badge-info text-white p-3">
                  {{ $user->userReferrerId }}
                </span>
              </td>
              <td>{{ $user->userName }}</td>
              <td>{{ $user->userEmail }}</td>
              <td>{{ $helpers->toTitle($user->userAccessGroup) }}</td>
              <td>
                {{ $user->userReferralId === 'null' ? 'N/A' : $user->userReferralId }}
              </td>
              <td>{{ $helpers->formatDateTime($user->userCreatedAt) }}</td>
              <td>
                <span class="badge {{ $helpers->getCommonStatus($user->userStatus)['class'] }} p-3">
                  {{ $helpers->getCommonStatus($user->userStatus)['name'] }}
                </span>
              </td>
              <td>
                <button type="button" data-id="{{ $user->userId }}" data-bs-toggle="modal" data-bs-target="#edit_user_modal" class="btn btn-sm btn-icon btn-info"><i class="fa-solid fa-pen-to-square fs-4"></i></button>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Create User Modal -->
      <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="add_user_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">{{ __('auth/management/users.add-user') }}</h3>
              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fs-2x fa-xmark"></i>
              </div>
            </div>

            <form method="POST" action="{{ route('controllerManagementUsersAddUser') }}">
              @csrf
              <div class="modal-body row m-1">
                <!-- User Name -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.name') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" id="add_user_name" name="name" class="form-control" placeholder="{{ __('auth/management/users.name-placeholder') }}" />
                  </div>
                </div>

                <!-- User Email -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.email') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" id="add_user_email" name="email" class="form-control" placeholder="{{ __('auth/management/users.email-placeholder') }}" />
                  </div>
                </div>

                <!-- User Password -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.password') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-shield"></i></span>
                    <input type="password" id="add_user_password" name="password" class="form-control" autocomplete="off" placeholder="{{ __('auth/management/users.password-placeholder') }}" />
                  </div>
                </div>

                <!-- User Confirm Password -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.confirm-password') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-shield"></i></span>
                    <input type="password" id="add_user_confirm_password" name="confirm-password" class="form-control" autocomplete="off" placeholder="{{ __('auth/management/users.confirm-password-placeholder') }}" />
                  </div>
                </div>

                <!-- User Access Group -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.access-group') }}</label>
                  <div class="input-group flex-nowrap">
                    <span class="input-group-text">
                      <i class="fa-solid fa-star"></i>
                    </span>
                    <div class="overflow-hidden flex-grow-1">
                      <select id="add_user_access_group" name="access-group" class="form-select rounded-start-0" data-dropdown-parent="#add_user_modal" data-control="select2" data-placeholder="{{ __('auth/management/users.access-group-placeholder') }}">
                        <option value="user">User</option>
                        <option value="administrator">Administrator</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- User Referral Id -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2">{{ __('auth/management/users.referral-id') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                    <input type="text" id="add_user_referral_id" name="referral-id" class="form-control" autocomplete="off" placeholder="{{ __('auth/management/users.referral-id-placeholder') }}" />
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" id="add_user_close_btn" class="btn btn-primary"><i class="fa-solid fa-xmark fs-4"></i> {{ __('auth/common.close') }}</button>
                <button type="reset" class="btn btn-danger me-2"><i class="fa-solid fa-redo-alt fs-4"></i> {{ __('auth/common.reset') }}</button>
                <button type="submit" class="btn btn-primary-theme me-2"><i class="fa-solid fa-paper-plane fs-4"></i> {{ __('auth/common.submit') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- END Create User Modal -->

      <!-- Edit User Modal -->
      <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="edit_user_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">{{ __('auth/management/users.edit-user') }}</h3>
              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fs-2x fa-xmark"></i>
              </div>
            </div>

            <form method="POST" action="{{ route('controllerManagementUsersUpdateUser') }}">
              @csrf
              <input type="hidden" value="" id="edit_user_id" name="user-id" />
              <div class="modal-body row m-1">
                <!-- User Name -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.name') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" id="edit_user_name" name="name" class="form-control" placeholder="{{ __('auth/management/users.name-placeholder') }}" />
                  </div>
                </div>

                <!-- User Email -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.email') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" id="edit_user_email" name="email" class="form-control" placeholder="{{ __('auth/management/users.email-placeholder') }}" />
                  </div>
                </div>

                <!-- User Password -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2">{{ __('auth/management/users.password') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-shield"></i></span>
                    <input type="password" id="edit_user_password" name="password" class="form-control" autocomplete="off" placeholder="{{ __('auth/management/users.password-placeholder') }}" />
                  </div>
                </div>

                <!-- User Confirm Password -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2">{{ __('auth/management/users.confirm-password') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-shield"></i></span>
                    <input type="password" id="edit_user_confirm_password" name="confirm-password" class="form-control" autocomplete="off" placeholder="{{ __('auth/management/users.confirm-password-placeholder') }}" />
                  </div>
                </div>

                <!-- User Access Group -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2 required">{{ __('auth/management/users.access-group') }}</label>
                  <div class="input-group flex-nowrap">
                    <span class="input-group-text">
                      <i class="fa-solid fa-star"></i>
                    </span>
                    <div class="overflow-hidden flex-grow-1">
                      <select id="edit_user_access_group" name="access-group" class="form-select rounded-start-0" data-dropdown-parent="#edit_user_modal" data-control="select2" data-placeholder="{{ __('auth/management/users.access-group-placeholder') }}">
                        <option value="user">User</option>
                        <option value="administrator">Administrator</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- User Referral Id -->
                <div class="col-lg-6 col-md-12 mb-7">
                  <label class="form-label mb-2">{{ __('auth/management/users.referral-id') }}</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                    <input type="text" id="edit_user_referral_id" name="referral-id" class="form-control" autocomplete="off" placeholder="{{ __('auth/management/users.referral-id-placeholder') }}" />
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" id="edit_user_close_btn" class="btn btn-primary"><i class="fa-solid fa-xmark fs-4"></i> {{ __('auth/common.close') }}</button>
                <button type="reset" class="btn btn-danger me-2"><i class="fa-solid fa-redo-alt fs-4"></i> {{ __('auth/common.reset') }}</button>
                <button type="submit" class="btn btn-primary-theme me-2"><i class="fa-solid fa-paper-plane fs-4"></i> {{ __('auth/common.submit') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- END Edit User Modal -->
    </div>
  </div>
</div>
@endsection