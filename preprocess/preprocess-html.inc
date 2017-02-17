<?php

/*
 * Implements THEMENAME_alpha_preprocess_html
 */
function suitcase_interim_alpha_preprocess_html(&$vars) {
  drupal_add_http_header('X-UA-Compatible', 'IE=edge');
  drupal_add_css('//cdn.theme.iastate.edu/nimbus-sans/css/nimbus-sans.css', array('type' => 'external', 'weight' => 10));
}
