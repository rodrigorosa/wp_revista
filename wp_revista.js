'use strict';

jQuery(document).ready(function($) {
  $('.send-email').on('click', function() {
    $('#post_id').val($(this).data('id'));
  });
});
