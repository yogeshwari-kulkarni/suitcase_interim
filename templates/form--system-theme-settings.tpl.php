<?php
/**
 * @file
 * Alpha's theme implementation to display a single Drupal page.
 */
?>
<div id="suitcase-interim-header-preview">
  <?php $wordmark_path = base_path() . drupal_get_path('theme', 'suitcase_interim') . '/images/sprite.png'; ?>
  <div class="container-12 clearfix">
    <div class="grid-6 suitcase-interim-vertical-tabs clearfix">
      <ul class="suitcase-interim-vertical-tabs-list">
        <li class="suitcase-interim-vertical-tab-button <?php if ($form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'] == 1) print 'active'; ?>" data-img="true" data-dname="true" data-lname="true" data-type="1">
          <div>
            <img src="<?php print $wordmark_path; ?>" height="24px">
            <div class="field-container field-department-name">
              <span class="field-name"><?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2']['#value']; ?></span>
              <div class="container-12 clearfix">
                <div class="grid-6">
                  <input type="text" name="department-name" class="form-text form-text-watch" value="<?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2']['#value']; ?>" placeholder="Enter Department Name">
                </div>
                <div class="grid-6">
                  <input type="text" name="department-url" class="form-text form-url-watch" value="<?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2_url']['#value']; ?>" placeholder="Enter URL">
                </div>
              </div>
            </div>
            <hr class="hr-preview">
            <div class="field-container field-laboratory-name">
              <span class="field-name"><?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_3']['#value']; ?></span>
              <input type="text" name="laboratory-name" class="form-text form-text-watch" value="<?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_3']['#value']; ?>" placeholder="Enter Laboratory Name">
            </div>
          </div>
        </li>
        <li class="suitcase-interim-vertical-tab-button <?php if ($form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'] == 2) print 'active'; ?>" data-img="true" data-dname="true" data-lname="false" data-type="2">
          <div>
            <img src="<?php print $wordmark_path; ?>" height="24px">
            <div class="field-container field-department-name">
              <span class="field-name"><?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2']['#value']; ?></span>
              <div class="container-12 clearfix">
                <div class="grid-6">
                  <input type="text" name="department-name" class="form-text form-text-watch" value="<?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2']['#value']; ?>" placeholder="Enter Department Name">
                </div>
                <div class="grid-6">
                  <input type="text" name="department-url" class="form-text form-url-watch" value="<?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2_url']['#value']; ?>" placeholder="Enter URL">
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="suitcase-interim-vertical-tab-button <?php if ($form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'] == 3) print 'active'; ?>" data-img="true" data-dname="false" data-lname="true" data-type="3">
          <div>
            <img src="<?php print $wordmark_path; ?>" height="24px">
            <div class="field-container field-laboratory-name">
              <span class="field-name"><?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_3']['#value']; ?></span>
              <input type="text" name="laboratory-name" class="form-text form-text-watch" value="<?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_3']['#value']; ?>" placeholder="Enter Laboratory Name">
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="grid-6">
      <div class="header-preview">
        <img src="<?php print ($form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'] > 3 && $form['suitcase_interim_config_site_info']['suitcase_interim_config_site_wordmark']['#file'])?file_create_url($form['suitcase_interim_config_site_info']['suitcase_interim_config_site_wordmark']['#file']->uri):$wordmark_path; ?>" height="24px" class="header-img">
        <header class="header-text">
          <h1 class="site-name-level-1" <?php if (!in_array($form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'], array(1, 2))) print 'style="display:none"'; ?>><?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_2']['#value']; ?></h1>
          <div class="site-name-level-2" <?php if (!in_array($form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'], array(1, 3))) print 'style="display:none"'; ?>>
            <hr class="hr-preview">
            <h2><?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_level_3']['#value']; ?></h2>
          </div>
        </header>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    (function($) {
      var $headerImg = $('.header-preview .header-img'),
        $headerLevel1 = $('.header-preview .site-name-level-1'),
        $headerLevel2 = $('.header-preview .site-name-level-2'),
        headerType = <?php print $form['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']['#value'] || 1; ?>,
        defaultWordMarkPath = '<?php print $wordmark_path; ?>';

      $('.suitcase-interim-vertical-tab-button').click(function() {
        $('.suitcase-interim-vertical-tab-button').removeClass('active');
        $(this).toggleClass('active');
        var d = $(this).data();
        if (d.img) $headerImg.show();
        else $headerImg.hide();
        if (d.dname) $headerLevel1.show();
        else $headerLevel1.hide();
        if (d.lname) $headerLevel2.show();
        else $headerLevel2.hide();
        headerType = d.type;
        $('#edit-header-type').val(headerType);
        if ($(this).hasClass('changeable-image-file')) {
          $('.header-preview>img').attr({
            src: $(this).find('img.change-me').attr('src'),
          });
        } else {
          $('.header-preview>img').attr({
            src: defaultWordMarkPath,
          });
        }
      });

      $('.field-department-name .form-text-watch').bind("propertychange change click keyup input paste", function() {
        $('.field-department-name .field-name').text($(this).val());
        $('.field-department-name .form-text-watch').val($(this).val());
        $('#edit-site-name').val($(this).val());
        $headerLevel1.text($(this).val());
      });

      $('.field-department-name .form-url-watch').bind("propertychange change click keyup input paste", function() {
        $('.field-department-name .form-url-watch').val($(this).val());
        $('#edit-dept-url').val($(this).val());
      });

      $('.field-laboratory-name .form-text-watch').bind("propertychange change click keyup input paste", function() {
        $('.field-laboratory-name .field-name').text($(this).val());
        $('.field-laboratory-name .form-text-watch').val($(this).val());
        $('#edit-site-slogan').val($(this).val());
        $headerLevel2.text($(this).val());
      });

      $('#edit-site-wordmark-upload').change(function(e) {
        var fr = new FileReader();
        fr.onload = function(e) {
          var dataURI = e.target.result;
          $('.change-me').attr({
            src: dataURI,
          });
        };
        fr.readAsDataURL(e.target.files[0]);
      });
    })(jQuery)
  </script>
</div>
