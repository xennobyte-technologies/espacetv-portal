(function ($) {
  $('.datepicker').flatpickr({
    enableTime: false,
    dateFormat: 'd-m-Y',
    disableMobile: true,
  });

  $('.datepicker-today').flatpickr({
    defaultDate: 'today',
    enableTime: false,
    dateFormat: 'd-m-Y',
    disableMobile: true,
  });

  $('.full-daterangepicker').daterangepicker({
    autoUpdateInput: false,
    ranges: {
      Today: [moment(), moment()],
      Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [
        moment().subtract(1, 'month').startOf('month'),
        moment().subtract(1, 'month').endOf('month'),
      ],
    },
    locale: {
      format: 'DD-MM-YYYY',
    },
  });

  $('.full-daterangepicker').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(
      picker.startDate.format('DD-MM-YYYY') +
        ' - ' +
        picker.endDate.format('DD-MM-YYYY')
    );
  });

  $('.full-daterangepicker').on(
    'cancel.daterangepicker',
    function (ev, picker) {
      $(this).val('');
    }
  );

  $('.datetimepicker').flatpickr({
    defaultDate: 'today',
    enableTime: true,
    dateFormat: 'd-m-Y h:i K',
    minuteIncrement: 1,
    disableMobile: true,
  });

  $('.datetimepicker-today').flatpickr({
    defaultDate: 'today',
    enableTime: true,
    dateFormat: 'd-m-Y h:i K',
    minDate: 'today',
    minuteIncrement: 1,
    disableMobile: true,
  });

  $('.datetimepicker-today-only').flatpickr({
    defaultDate: 'today',
    enableTime: true,
    dateFormat: 'd-m-Y h:i K',
    minDate: 'today',
    maxDate: 'today',
    minuteIncrement: 1,
    disableMobile: true,
  });

  $('.timepicker').flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: 'h:i K',
    minuteIncrement: 1,
    disableMobile: true,
  });
})(jQuery);

var formatDate = function (date, format = '-', enableTime = true) {
  date = new Date(date);
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12;
  if (enableTime) {
    return (
      ('0' + day).slice(-2) +
      format +
      ('0' + month).slice(-2) +
      format +
      year +
      ' ' +
      ('0' + hours).slice(-2) +
      ':' +
      ('0' + minutes).slice(-2) +
      ' ' +
      ampm
    );
  } else {
    return (
      ('0' + day).slice(-2) + format + ('0' + month).slice(-2) + format + year
    );
  }
};

var closeBtnModal = function (btnId, modalId) {
  $(btnId).on('click', function () {
    $(modalId).modal('hide');
  });
};

var confirmationDialog = function (data) {
  if (Object.keys(data).length > 0) {
    Swal.fire({
      title: data.title,
      text: data.message,
      timer: 10000,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      allowOutsideClick: false,
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(
          data.url,
          {
            _token: _token,
            id: data.id,
          },
          function (response) {
            Swal.fire({
              title: response.title,
              text: response.message,
              icon: response.icon,
              allowOutsideClick: false,
            }).then((result) => {
              if (response.code === 200) {
                location.reload();
              }
            });
          }
        );
      }
    });
  }
};

var setupFileUploading = function (
  target,
  directory,
  formId,
  limit,
  fileTypes = ['.jpg', '.jpeg', '.png']
) {
  var uppy = Uppy.Core({
    autoProceed: false,
    restrictions: {
      maxFileSize: 50000000, // 50mb
      maxNumberOfFiles: limit,
      minNumberOfFiles: 1,
      allowedFileTypes: fileTypes,
    },
  });

  var options = {
    proudlyDisplayPoweredByUppy: false,
    target: target,
    inline: true,
    replaceTargetContent: true,
    showProgressDetails: true,
    note: `Upload up to ${limit} files. Max of 5MB each`,
    height: 300,
    browserBackButtonClose: true,
    hideUploadButton: false,
  };

  var uploadFilesOptions = {
    limit: limit,
    endpoint: '/files/upload',
    formData: true,
    fieldName: 'files[]',
    method: 'post',
    bundle: true,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
  };

  uppy.setMeta({ directory: directory });
  uppy.use(Uppy.Dashboard, options);
  uppy.use(Uppy.XHRUpload, uploadFilesOptions);

  uppy.on('upload-success', function (file, response) {
    var httpStatus = response.status;
    if (httpStatus === 200) {
      var files = response.body.files;
      files.forEach(function (file) {
        $(formId).append(
          `<input type='hidden' name='files[]' value='${JSON.stringify(
            file
          )}' />`
        );
      });
    }
  });
};
