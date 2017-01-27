<div class="panel-display omega-grid suitcase_megapanels" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
		
	<?php if (!empty($content['top_full'])): ?>
		<div class="clearfix front-panel-full front-panel-full_top">
			<div class="panel">
				<?php print $content['top_full']; ?>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="clearfix front-panel-row front-panel-row_top">
		<?php if (!empty($content['top_1'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['top_1']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['top_2'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['top_2']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['top_3'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['top_3']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['top_4'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['top_4']; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="clearfix front-panel-row front-panel-row_middle">
		<?php if (!empty($content['middle_1'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['middle_1']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['middle_2'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['middle_2']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['middle_3'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['middle_3']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['middle_4'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['middle_4']; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="clearfix front-panel-row front-panel-row_bottom">
		<?php if (!empty($content['bottom_1'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['bottom_1']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['bottom_2'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['bottom_2']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['bottom_3'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['bottom_3']; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($content['bottom_4'])): ?>
			<div class="panel-panel grid-3">
				<?php print $content['bottom_4']; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if (!empty($content['bottom_full'])): ?>
		<div class="clearfix front-panel-full front-panel-full_top">
			<div class="panel">
				<?php print $content['bottom_full']; ?>
			</div>
		</div>
	<?php endif; ?>
		
</div>
