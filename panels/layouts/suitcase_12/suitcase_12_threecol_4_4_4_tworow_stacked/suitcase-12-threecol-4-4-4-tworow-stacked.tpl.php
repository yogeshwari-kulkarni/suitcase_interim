<div class="panel-display omega-grid suitcase-12-threecol-4-4-4-tworow-stacked" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="panel-panel grid-12">
    <?php print $content['top']; ?>
  </div>
  <div class="clearfix">
    <div class="panel-panel grid-4">
      <?php print $content['upper_left']; ?>
    </div>
    <div class="panel-panel grid-4">
      <?php print $content['upper_middle']; ?>
    </div>
    <div class="panel-panel grid-4">
      <?php print $content['upper_right']; ?>
    </div>
  </div>
  <div class="clearfix">
    <div class="panel-panel grid-4">
      <?php print $content['lower_left']; ?>
    </div>
    <div class="panel-panel grid-4">
      <?php print $content['lower_middle']; ?>
    </div>
    <div class="panel-panel grid-4">
      <?php print $content['lower_right']; ?>
    </div>
  </div>
  <div class="panel-panel grid-12">
    <?php print $content['bottom']; ?>
  </div>
</div>