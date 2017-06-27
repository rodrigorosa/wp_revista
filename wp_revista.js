'use strict';

jQuery(document).ready(function($) {
  $('.action-with-post-id').on('click', function() {
    $('.post-id').val($(this).data('id'));
  });
});
