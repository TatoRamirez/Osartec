jQuery(document).ready(function ($) {
    $('.custom_media_item_upload').on("click", function() {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
   
      wp.media.editor.send.attachment = function(props, attachment) {
        $(button).next().val(attachment.id);
        $(button).next().next().attr('src', attachment.url);
        $(button).next().next().show();
        $(button).next().next().next().show();
   
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open(button);
   
      return false;       
    });
   
    $('.custom_media_item_delete').on("click", function() {
      var button = $(this);
   
      $(button).hide();
      $(button).prev().attr('src', '');
      $(button).prev().hide();
      $(button).prev().prev().val('');
   
      return false;       
    });
  });