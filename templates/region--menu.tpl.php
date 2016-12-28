<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <?php print $content; ?>

    <?php if ($main_menu_smartmenu): ?>
    <nav id="main-menu-nav" class="navigation" role="navigation">

      <h2 class="element-invisible">Main menu</h2>

      <!-- Mobile menu toggle button (hamburger/x icon) -->
      <input id="main-menu-state" class="sm-menu-state" type="checkbox" />
      <label class="sm-menu-btn" for="main-menu-state">
         <span class="sm-menu-btn-icon"></span> Main Menu
      </label>
      <?php print render($main_menu_smartmenu); ?>

    </nav>
    <?php endif; ?>
  </div>
</div>
