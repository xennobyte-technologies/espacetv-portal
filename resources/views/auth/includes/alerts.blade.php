@if($errors->any())
<!--begin::Alert-->
<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
  <!--begin::Icon-->
  <i class="fa-solid fa-triangle-exclamation fs-2hx text-light me-4 mb-5 mb-sm-0"></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column text-light pe-0 pe-sm-10">
    <!--begin::Title-->
    <h4 class="mb-2 text-light">{{ __('alerts.alert-error-title') }}</h4>
    <!--end::Title-->

    <!--begin::Content-->
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
    <!--end::Content-->
  </div>
  <!--end::Wrapper-->

  <!--begin::Close-->
  <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
    <i class="fa-solid fa-xmark fs-2x text-light"></i>
  </button>
  <!--end::Close-->
</div>
<!--end::Alert-->
@endif

@if(session()->has('error'))
<!--begin::Alert-->
<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
  <!--begin::Icon-->
  <i class="fa-solid fa-triangle-exclamation fs-2hx text-light me-4 mb-5 mb-sm-0"></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column text-light pe-0 pe-sm-10">
    <!--begin::Title-->
    <h4 class="mb-2 text-light">{{ __('alerts.alert-error-title') }}</h4>
    <!--end::Title-->

    <!--begin::Content-->
    <span>{{ session()->get('error') }}</span>
    <!--end::Content-->
  </div>
  <!--end::Wrapper-->

  <!--begin::Close-->
  <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
    <i class="fa-solid fa-xmark fs-2x text-light"></i>
  </button>
  <!--end::Close-->
</div>
<!--end::Alert-->
@endif

@if(session()->has('warning'))
<!--begin::Alert-->
<div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
  <!--begin::Icon-->
  <i class="fa-regular fa-triangle-exclamation fs-2hx text-light me-4 mb-5 mb-sm-0"></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column text-light pe-0 pe-sm-10">
    <!--begin::Title-->
    <h4 class="mb-2 text-light">{{ __('alerts.alert-warning-title') }}</h4>
    <!--end::Title-->

    <!--begin::Content-->
    <span>{{ session()->get('warning') }}</span>
    <!--end::Content-->
  </div>
  <!--end::Wrapper-->

  <!--begin::Close-->
  <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
    <i class="fa-solid fa-xmark fs-2x text-light"></i>
  </button>
  <!--end::Close-->
</div>
<!--end::Alert-->
@endif

@if(session()->has('success'))
<!--begin::Alert-->
<div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row p-5 mb-10">
  <!--begin::Icon-->
  <i class="fa-solid fa-circle-check fs-2hx text-light me-4 mb-5 mb-sm-0"></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column text-light pe-0 pe-sm-10">
    <!--begin::Title-->
    <h4 class="mb-2 text-light">{{ __('alerts.alert-success-title') }}</h4>
    <!--end::Title-->

    <!--begin::Content-->
    <span>{{ session()->get('success') }}</span>
    <!--end::Content-->
  </div>
  <!--end::Wrapper-->

  <!--begin::Close-->
  <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
    <i class="fa-solid fa-xmark fs-2x text-light"></i>
  </button>
  <!--end::Close-->
</div>
<!--end::Alert-->
@endif

@if(session()->has('info'))
<!--begin::Alert-->
<div class="alert alert-dismissible bg-info d-flex flex-column flex-sm-row p-5 mb-10">
  <!--begin::Icon-->
  <i class="fa-solid fa-circle-info fs-2hx text-light me-4 mb-5 mb-sm-0"></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column text-light pe-0 pe-sm-10">
    <!--begin::Title-->
    <h4 class="mb-2 text-light">{{ __('alerts.alert-info-title') }}</h4>
    <!--end::Title-->

    <!--begin::Content-->
    <span>{{ session()->get('info') }}</span>
    <!--end::Content-->
  </div>
  <!--end::Wrapper-->

  <!--begin::Close-->
  <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
    <i class="fa-solid fa-xmark fs-2x text-light"></i>
  </button>
  <!--end::Close-->
</div>
<!--end::Alert-->
@endif
