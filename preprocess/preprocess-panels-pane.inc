<?php

/*
 * Implements THEMENAME_alpha_preprocess_panels_pane
 */
function suitcase_interim_alpha_preprocess_panels_pane(&$variables) {
  if (isset($variables['classes_array']) && isset($variables['attributes_array']['class']) && !empty($variables['classes_array']) && !empty($variables['attributes_array']['class'])) {
    $merge = array_unique(array_merge($variables['classes_array'], $variables['attributes_array']['class']));
    $variables['classes_array'] = $merge;
    unset($variables['attributes_array']['class']);
  }
}