<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <?php if ($content): ?>
      <?php $site_name_level_2_class = ($suitcase_interim_config_header_type == 1 || $suitcase_interim_config_header_type == 2) ? ' has-site-name-level-2' : ''; ?>
      <?php $site_name_level_3_class = ($suitcase_interim_config_header_type == 1 || $suitcase_interim_config_header_type == 3) ? ' has-site-name-level-3' : ''; ?>
      <div class="search-form-container<?php print $site_name_level_2_class . $site_name_level_3_class; ?>"><?php print $content; ?></div>
    <?php endif; ?>
  </div>
</div>
