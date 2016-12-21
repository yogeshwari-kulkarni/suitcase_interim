/**
 * @todo
 */

(function($) {
  /**
   * @todo
   */
  Drupal.behaviors.suitcaseMegaMenu = {
    attach: function (context) {
      $('body', context).once('suitcaseSmartMenu', function() {
        $('#main-menu').smartmenus();
      });
    }
  };
})(jQuery);