<?php

/*
 * Implements THEMENAME_alpha_preprocess_html
 */
function suitcase_interim_alpha_preprocess_html(&$vars) {
  drupal_add_http_header('X-UA-Compatible', 'IE=edge');
}