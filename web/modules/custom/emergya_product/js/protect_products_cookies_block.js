(function ($, Drupal, drupalSettings, cookies) {

  'use strict';

  Drupal.behaviors.productProtectCookies = {
    attach: function (context, settings) {
      var productProtectModal = Drupal.dialog('<div>The product content is protected. Please accept cookies to view product details.</div>', {
        title: 'Product protection',
        dialogClass: 'product-modal-protect',
        width: 500,
        height: 200,
        autoResize: false,
        close: function (event) {
          $(event.target).remove();
        },
        buttons: [
          {
            text: 'Accept Cookies',
            class: 'fas fa-check accepts-class',
            icons: {
              primary: 'fas fa-check'
            },
            click: function () {
              $(this).dialog('close');
              cookies.set('product_protect_accept', '1');
              $(".node__details--protected").show();
            }
          },
          {
            text: "I don't want to see product details",
            icons: {
              primary: 'ui-icon-close'
            },
            click: function () {
              $(this).dialog('close');
            }
          }
        ]
      });
      $(document, context).once('productProtectCookies').each( function () {
        var protect = cookies.get('product_protect_accept');

        // cookies.remove('product_protect_accept');
        if (protect !== '1') {
          $(".node__details--protected").hide();
          productProtectModal.showModal();
        }
      });
    }
  }

} (jQuery, Drupal, drupalSettings, window.Cookies));
