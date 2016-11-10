<?php

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 * 
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */

// theme_preprocess_html
function suitcase_interim_preprocess_html(&$vars) {
//  ISU Bar responsive classes added to body
  $vars['attributes_array']['class'][] = 'responsive';
  $vars['attributes_array']['class'][] = 'wd-show-sidebar';
  // Drupal 7 in hook_preprocess_html()
  drupal_add_http_header('X-UA-Compatible', 'IE=edge,chrome=1');
}

// template_preprocess_region
function suitcase_interim_preprocess_region(&$vars) {
  if ($vars['region'] == 'content' && arg(0) == 'node' && is_numeric(arg(1)) && arg(2) !== 'edit') {
    $node = node_load(arg(1));
    if ($node->type == 'people' && !empty($node->field_people_category)) {
      $vars['categories'] = array();
      foreach ($node->field_people_category[LANGUAGE_NONE] as $category) {
        $tax = taxonomy_term_load($category['tid']);
        array_push($vars['categories'], $tax->name);
      }
    }
  } 
  elseif ($vars['region'] == 'branding') {
    // Prepare Logo
    $vars['suitcase_interim_config_logo'] = FALSE;
    $logo = variable_get('suitcase_interim_config_logo');
    if ($logo) {
      $logo_url = file_create_url($logo['uri']);
      $vars['suitcase_interim_config_logo'] = '<div class="logo-img"><a href="' . $GLOBALS['base_url'] . '" rel="home" title="' . $vars['site_name'] . '" class="active"><img src="' . $logo_url . '" alt="Go to ' . $vars['site_name'] . ' home" id="logo" /></a></div>';
    }

    // Get the level 1 url
    $vars['level_1_url'] = variable_get('suitcase_interim_config_level_1_url', $default = NULL);

    $vars['suitcase_interim_config_level_2_url'] = variable_get('suitcase_interim_config_level_2_url', $default = NULL);

    $vars['site_name_level_2'] = variable_get('suitcase_interim_config_level_2');
    $vars['linked_site_name_level_2'] = l($vars['site_name_level_2'], $vars['suitcase_interim_config_level_2_url'], array('html' => TRUE));

    $vars['site_name_level_3'] = variable_get('suitcase_interim_config_level_3');
    $vars['linked_site_name_level_3'] = l($vars['site_name_level_3'], '<front>', array('attributes' => array('title' => t('Home')), 'html' => TRUE));

    $vars['show_isu_nameplate'] = variable_get('suitcase_interim_config_isu_nameplate_display', 1);

    // Levels to show
    $vars['levels_to_show'] = variable_get('suitcase_interim_config_levels_to_show', NULL);

    // Level that is site name
    $vars['level_that_is_site_name'] = variable_get('suitcase_interim_config_level_that_is_site_name', NULL);

    // The type of header that we need to output, default to show all
    $vars['suitcase_interim_config_header_type'] = variable_get('suitcase_interim_config_header_type', 1);

    // Get the uploaded wordmark if is exists and the header type allows
    $vars['site_wordmark'] = variable_get('suitcase_interim_config_site_wordmark', $default = NULL);

    if (!$vars['site_wordmark'] || ($vars['suitcase_interim_config_header_type'] != '4' && $vars['suitcase_interim_config_header_type'] != '5')) {
      // If a wordmark hasn't been uploaded, create a var for the default wordmark
      $vars['default_wordmark'] = file_create_url(path_to_theme() . '/images/sprite.png');
      $vars['site_wordmark'] = NULL;
    } 
    else {
      $vars['site_wordmark'] = file_create_url($vars['site_wordmark']);
    }
  } 
  elseif ($vars['region'] == 'menu') {
    $vars['site_name'] = variable_get('site_name');
    $vars['linked_site_name'] = l($vars['site_name'], '<front>', array('attributes' => array('title' => t('Home')), 'html' => TRUE));
  } 
  elseif ($vars['region'] == 'search') {
    if (module_exists('taxonomy')) {
      $vars['categories'] = taxonomy_get_tree(1);
    }
    $vars['site_name_level_2'] = variable_get('site_name');
    $vars['site_name_level_3'] = variable_get('site_slogan');

    // Levels to show
    $vars['levels_to_show'] = variable_get('suitcase_interim_config_levels_to_show');

    // The type of header that we need to output, default to show all
    $vars['suitcase_interim_config_header_type'] = variable_get('suitcase_interim_config_header_type', 1);


  } 
  elseif ($vars['region'] == 'secondary_menu') {
    $theme = alpha_get_theme();
    $vars['secondary_menu'] = $theme->page['secondary_menu'];
  }
}

function suitcase_interim_preprocess_section(&$vars) {
  if ($vars['section'] == 'header') {
    $vars['show_blackbar'] = variable_get('suitcase_interim_config_blackbar_display', 1);
  }
}

function suitcase_interim_preprocess_content(&$vars) {
  $vars['categories'] = variable_get('field_people_category', $default = NULL);
}

function suitcase_interim_facetapi_deactivate_widget($variables) {
  return '&nbsp;&times;';
}

function suitcase_interim_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['actions']['submit']['#value'] = '  ';
  }
}

function suitcase_interim_preprocess_panels_pane(&$variables) {
  if (isset($variables['classes_array']) && isset($variables['attributes_array']['class']) && !empty($variables['classes_array']) && !empty($variables['attributes_array']['class'])) {
    $merge = array_unique(array_merge($variables['classes_array'], $variables['attributes_array']['class']));
    $variables['classes_array'] = $merge;
    unset($variables['attributes_array']['class']);
  }
}
