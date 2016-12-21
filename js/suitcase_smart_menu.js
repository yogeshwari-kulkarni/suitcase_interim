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
        $('#main-menu').smartmenus();
        var $mainMenuState = $('#sm-menu-state');
        if ($mainMenuState.length) {
          // animate mobile menu
          $mainMenuState.change(function(e) {
            var $menu = $('#main-menu');
            if (this.checked) {
              $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
            } else {
              $menu.show().slideUp(250, function() { $menu.css('display', ''); });
            }
          });
          // hide mobile menu beforeunload
          $(window).bind('beforeunload unload', function() {
            if ($mainMenuState[0].checked) {
              $mainMenuState[0].click();
            }
          });
        }
      });
    }
  };
})(jQuery);