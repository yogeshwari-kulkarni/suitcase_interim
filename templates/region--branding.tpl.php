<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <?php if ($site_name || $site_slogan): ?>
      <div class="branding-data clearfix">

        <?php if ($suitcase_interim_config_logo): ?>
          <div class="logo-img">
            <?php print $suitcase_interim_config_logo; ?>
          </div>
        <?php endif; ?>

        <?php if($show_isu_nameplate): ?>
          <div id="isu_wordmark">
            <?php if (theme_get_setting('default_logo', 'suitcase_interim')): ?>
              <a class="nameplate" href="<?php ($level_1_url) ? print $level_1_url : 'http://www.iastate.edu' ?>" title="Iowa State University Homepage"><img src="<?php print $wordmark_image; ?>" alt="Iowa State University"></a>
            <?php else: ?>
              <a class="nameplate" href="<?php ($level_1_url) ? print $level_1_url : 'http://www.iastate.edu' ?>" title="<?php print $site_name; ?>"><img src="<?php print $wordmark_image; ?>" alt="Iowa State University - <?php print $site_name; ?>"></a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if ($suitcase_interim_config_header_type == 1 || $suitcase_interim_config_header_type == 2): ?><?php /* We show the dept name for cases 1 & 2 */ ?>
          <?php if ($suitcase_interim_config_header_type == 2 && $is_front): ?>
            <h1 class="site-name-level-2"><?php print $linked_site_name_level_2; ?></h1>
          <?php else: ?>
            <span class="site-name-level-2"><?php print $linked_site_name_level_2; ?></span>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($suitcase_interim_config_header_type == 1 || $suitcase_interim_config_header_type == 3): ?><?php /* We show the lab name for cases 1 & 3 */?>
          <hr>
          <hgroup class="site-name-slogan">
            <?php if ($is_front): ?>
              <h1 class="site-name-level-3"><?php print $linked_site_name_level_3; ?></h1>
            <?php else: ?>
              <span class="site-name-level-3"><?php print $linked_site_name_level_3; ?></span>
            <?php endif; ?>
          </hgroup>
        <?php endif; ?>

      </div>
    <?php endif; ?>
    <?php print $content; ?>
  </div>
</div>
