/**
 * @todo
 */

(function($) {
  /**
   * @todo
   */
  Drupal.behaviors.suitcaseSmartMenu = {
    attach: function (context) {
      $('body', context).once('suitcaseSmartMenu', function() {
        $('.sm').smartmenus();
        $('.sm-menu-state').change(function(e) {
          var $menu = $('#' + this.id.slice(0, -6));
          if (this.checked) {
            $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
          } else {
            $menu.show().slideUp(250, function() { $menu.css('display', ''); });
          }
        });
        $('.sm-menu-state').each(function(index, element) {
          // hide mobile menu beforeunload
          $(window).bind('beforeunload unload', function() {
            if ($(this)[0].checked) {
              $(this)[0].click();
            }
          });
        });
      });
    }
  };
})(jQuery);