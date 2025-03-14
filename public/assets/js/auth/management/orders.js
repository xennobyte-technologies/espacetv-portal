(function ($) {
  $('#management_orders_table').DataTable();

  closeBtnModal('#new_order_close_btn', '#add_order_modal');
  closeBtnModal('#edit_order_close_btn', '#edit_order_modal');

  $('#add_order_modal').on('show.bs.modal', function (event) {
    if (event.namespace === 'bs.modal') {
      var modal = $(this);
      clearInputFields(modal);
    }
  });

  $('#edit_order_modal').on('show.bs.modal', function (event) {
    if (event.namespace === 'bs.modal') {
      var modal = $(this);
      var editButton = $(event.relatedTarget);
      var id = $(editButton).data('id');
      $.post(
        '/management/orders/get',
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
  modal.find('#edit_order_id').val(data.orderId);
  modal.find('#edit_order_name').val(data.orderName);
  modal.find('#edit_order_email').val(data.orderEmail);
  modal
    .find('#edit_order_access_group')
    .val(data.orderAccessGroup)
    .trigger('change');
};
