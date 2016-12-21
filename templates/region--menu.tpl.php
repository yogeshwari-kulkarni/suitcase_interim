<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <?php print $content; ?>

    <?php if ($main_menu): ?>
    <nav class="navigation" role="navigation">
      <h2 class="element-invisible">Main menu</h2>
      <?php print render($main_menu_smartmenu); ?>
    </nav>
    <?php endif; ?>
  </div>
</div>
