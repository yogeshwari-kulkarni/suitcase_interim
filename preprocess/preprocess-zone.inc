<?php

/*
 * Implements THEMENAME_alpha_preprocess_zone
 */
function suitcase_interim_alpha_preprocess_zone(&$vars) {
  if (strpos($vars['elements']['#zone'], 'hero') === 0) {
    unset($vars['elements']['#grid']);
    unset($vars['elements']['#grid_container']);
  }
}
