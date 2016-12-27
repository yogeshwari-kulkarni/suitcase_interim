<?php

/*
 * Implements THEMENAME_alpha_preprocess_content
 */
function suitcase_interim_alpha_preprocess_content(&$vars) {
  $vars['categories'] = variable_get('field_people_category');
}
