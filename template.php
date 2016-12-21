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
  drupal_add_http_header('X-UA-Compatible', 'IE=edge');
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

    // Get the level 1 url
    $vars['level_1_url'] = variable_get('suitcase_interim_config_level_1_url');

    $vars['suitcase_interim_config_level_2_url'] = variable_get('suitcase_interim_config_level_2_url');

    $vars['site_name_level_2'] = variable_get('suitcase_interim_config_level_2');
    $vars['linked_site_name_level_2'] = l($vars['site_name_level_2'], $vars['suitcase_interim_config_level_2_url'], array('html' => TRUE));

    $vars['site_name_level_3'] = variable_get('suitcase_interim_config_level_3');
    $vars['linked_site_name_level_3'] = l($vars['site_name_level_3'], '<front>', array('attributes' => array('title' => t('Home')), 'html' => TRUE));

    $vars['show_isu_nameplate'] = variable_get('suitcase_interim_config_isu_nameplate_display', 1);

    // The type of header that we need to output, default to show all
    $vars['suitcase_interim_config_header_type'] = variable_get('suitcase_interim_config_header_type', 1);

    // Get the uploaded wordmark if is exists and the header type allows
    $vars['wordmark_image'] = (theme_get_setting('default_logo', 'suitcase_interim')) ? file_create_url(drupal_get_path('theme', 'suitcase_interim') . '/images/isu.svg') : file_create_url(theme_get_setting('logo_path', 'suitcase_interim'));

  }
  elseif ($vars['region'] == 'menu') {
    $vars['site_name'] = variable_get('site_name');
    $vars['linked_site_name'] = l($vars['site_name'], '<front>', array('attributes' => array('title' => t('Home')), 'html' => TRUE));
    $vars['main_menu_smartmenu'] = menu_tree_output(menu_tree_page_data('main-menu'));
  } 
  elseif ($vars['region'] == 'search') {
    $vars['site_name_level_2'] = variable_get('site_name');
    $vars['site_name_level_3'] = variable_get('site_slogan');
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
  $vars['categories'] = variable_get('field_people_category');
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

/* Hero */

function suitcase_interim_alpha_preprocess_zone(&$vars) {
  if (strpos($vars['elements']['#zone'], 'hero') === 0) {
    unset($vars['elements']['#grid']);
    unset($vars['elements']['#grid_container']);
  }
}

function suitcase_interim_alpha_preprocess_region(&$vars) {
  if (strpos($vars['elements']['#region'], 'hero') === 0) {
    $vars['content_attributes_array']['class'][] = 'region-hero-inner';
    unset($vars['elements']['#grid']);
    unset($vars['elements']['#grid_container']);
  }
  if (strpos($vars['elements']['#region'], 'sidebar') === 0) {
    $vars['attributes_array']['role'] = 'complementary';
  }
}

function suitcase_interim_alpha_preprocess_section(&$vars) {
  if ($vars['elements']['#section'] == 'header') {
    $vars['attributes_array']['role'] = 'banner';
  }
  if ($vars['elements']['#section'] == 'footer') {
    $vars['attributes_array']['role'] = 'contentinfo';
  }
}

/*
 * Implements hook_form_FORMID_alter()
 */
function suitcase_interim_form_search_block_form_alter(&$form, &$form_state, $form_id) {
  $form['#attributes']['role'] = 'search';
}

/* Menu Theme Functions */

# https://www.drupal.org/node/767404

/**
 * Implements hook_theme_registry_alter().
 */
function suitcase_interim_theme_registry_alter(&$theme_registry) {
  $theme_registry['menu_tree']['preprocess functions'] = array_diff($theme_registry['menu_tree']['preprocess functions'], array('template_preprocess_menu_tree'));
}

/**
 * Implements theme_preprocess_HOOK() for theme_menu_tree().
 */
function suitcase_interim_preprocess_menu_tree(&$variables) {
  $variables['#tree'] = $variables['tree'];
  $variables['tree'] = $variables['tree']['#children'];
}

/*
 * Implements theme_menu_tree__main_menu().
 */
function suitcase_interim_menu_tree__main_menu($variables) {
  $pop = array_slice($variables['#tree'], 0, 1);
  $menu_item = array_pop($pop);
  if (isset($menu_item['#original_link']['depth']) && $menu_item['#original_link']['depth'] == 1) {
    return '<ul id="main-menu" class="links inline clearfix main-menu">' . $variables['tree'] . '</ul>';
  } else {
    return '<ul class="menu">' . $variables['tree'] . '</ul>';
  }
}