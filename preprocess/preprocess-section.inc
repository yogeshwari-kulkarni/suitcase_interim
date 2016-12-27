<?php

/*
 * Implements THEMENAME_alpha_preprocess_section
 */
function suitcase_interim_alpha_preprocess_section(&$vars) {
  if ($vars['section'] == 'header') {
    $vars['show_blackbar'] = variable_get('suitcase_interim_config_blackbar_display', 1);
  }
  if ($vars['elements']['#section'] == 'header') {
    $vars['attributes_array']['role'] = 'banner';
  }
  if ($vars['elements']['#section'] == 'footer') {
    $vars['attributes_array']['role'] = 'contentinfo';
  }
}