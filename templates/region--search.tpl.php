<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <?php if ($content): ?>
    <div class="clearfix">
      <?php $site_name_level_2_class = ($suitcase_interim_config_header_type < 3) ? ' has-site-name-level-2' : ''; ?>
      <?php $site_name_level_3_class = ($suitcase_interim_config_header_type == 1 || $suitcase_interim_config_header_type == 3 || $suitcase_interim_config_header_type == 4) ? ' has-site-name-level-3' : ''; ?>
        <div class="pull-right margin-left-10 pos-relative search-form-container<?php print $site_name_level_2_class . $site_name_level_3_class; ?>"><?php print $content; ?></div>
    </div>
    <?php endif; ?>
  </div>
</div>
