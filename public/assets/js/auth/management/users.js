(function ($) {
  $('#management_users_table').DataTable();

  closeBtnModal('#new_user_close_btn', '#add_user_modal');
  closeBtnModal('#edit_user_close_btn', '#edit_user_modal');

  $('#add_user_modal').on('show.bs.modal', function (event) {
    if (event.namespace === 'bs.modal') {
      var modal = $(this);
      clearInputFields(modal);
    }
  });

  $('#edit_user_modal').on('show.bs.modal', function (event) {
    if (event.namespace === 'bs.modal') {
      var modal = $(this);
      var editButton = $(event.relatedTarget);
      var id = $(editButton).data('id');
      $.post(
        '/management/users/get',
        {
          _token: _token,
          id: id,
        },
        function (response) {
          if (response.code === 200) {
            var data = response.data;
            populateFields(modal, data);
          }
        }
      );
    }
  });
})(jQuery);

var clearInputFields = function (modal) {
  modal.find('select').val(null).trigger('change');
  modal.find('input:not([type="hidden"])').val('');
};

var populateFields = function (modal, data) {
  modal.find('#edit_user_id').val(data.userId);
  modal.find('#edit_user_name').val(data.userName);
  modal.find('#edit_user_email').val(data.userEmail);
  modal
    .find('#edit_user_access_group')
    .val(data.userAccessGroup)
    .trigger('change');
};
