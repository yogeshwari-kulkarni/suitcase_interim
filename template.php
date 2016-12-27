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

/**
 * Implements hook_theme().
 */
function suitcase_interim_theme($existing, $type, $theme, $path) {
  return array(
    'smartmenu_tree' => array(
      'render element' => 'tree',
    ),
  );
}

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
    $main_menu_attributes = array(
      'id' => 'main-menu',
      'class' => array('sm'),
      'data-sm-options' => '{ subIndicatorsPos: "append", subMenusMinWidth: "300px" }'
    );
    $vars['main_menu_smartmenu'] = suitcase_interim_smartmenu_tree_output(menu_tree_page_data('main-menu'), $main_menu_attributes);
  } 
  elseif ($vars['region'] == 'search') {
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

/*
 * Implements theme_smartmenu_tree().
 */
function suitcase_interim_smartmenu_tree($variables) {
  if (!empty($variables['tree']['#attributes'])) {
    return '<ul' . drupal_attributes($variables['tree']['#attributes']) . '>' . $variables['tree']['#children'] . '</ul>';
  } else {
    return '<ul>' . $variables['tree']['#children'] . '</ul>';
  }
}

/*
 *
 * Modified version of menu_tree_output
 * 
 * -------------------------------------------------------------------------
 *
 * Returns an output structure for rendering a menu tree.
 *
 * The menu item's LI element is given one of the following classes:
 * - expanded: The menu item is showing its submenu.
 * - collapsed: The menu item has a submenu which is not shown.
 * - leaf: The menu item has no submenu.
 *
 * @param $tree
 *   A data structure representing the tree as returned from menu_tree_data.
 *
 * @return
 *   A structured array to be rendered by drupal_render().
 *
 * -------------------------------------------------------------------------
 *
 * Modifications:
 *
 * - Uses theme_smartmenu_tree as a theme_wrapper rather than theme_menu_tree
 *   This is important because template_preprocess_menu_tree removes depth
 *   information from from the tree and working around this requires altering the
 *   theme registry. See https://www.drupal.org/node/767404
 *
 * - Adds the active classes for absolute url matches (including query string).
 *   This does not handle the case, which might be considered a core bug, where
 *   multiple menu items that link to the same page and differ only in query strings
 *   will both highlight upon visiting either of them.
 *
 * - Accepts an array of attributes to apply to the generated list
 *
 */
function suitcase_interim_smartmenu_tree_output($tree, $attributes = NULL) {
  $build = array();
  $items = array();

  // Pull out just the menu links we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if ($data['link']['access'] && !$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $router_item = menu_get_item();
  $num_items = count($items);
  foreach ($items as $i => $data) {
    $class = array();
    if ($i == 0) {
      $class[] = 'first';
    }
    if ($i == $num_items - 1) {
      $class[] = 'last';
    }
    // Set a class for the <li>-tag. Since $data['below'] may contain local
    // tasks, only set 'expanded' class if the link also has children within
    // the current menu.
    if ($data['link']['has_children'] && $data['below']) {
      $class[] = 'expanded';
    }
    elseif ($data['link']['has_children']) {
      $class[] = 'collapsed';
    }
    else {
      $class[] = 'leaf';
    }
    // Set a class if the link is in the active trail.
    if ($data['link']['in_active_trail']) {
      $class[] = 'active-trail';
      $data['link']['localized_options']['attributes']['class'][] = 'active-trail';
    }
    // Normally, l() compares the href of every link with $_GET['q'] and sets
    // the active class accordingly. But local tasks do not appear in menu
    // trees, so if the current path is a local task, and this link is its
    // tab root, then we have to set the class manually.
    if ($data['link']['href'] == $router_item['tab_root_href'] && $data['link']['href'] != $_GET['q']) {
      $data['link']['localized_options']['attributes']['class'][] = 'active';
    }

    if (($data['link']['href'] == $_GET['q'] || $data['link']['href'] == ($GLOBALS['base_root'] . request_uri())) || ($data['link']['href'] == '<front>' && drupal_is_front_page())) {
      $class[] = 'active';
      $class[] = 'active-trail';
      $data['link']['localized_options']['attributes']['class'][] = 'active';
      $data['link']['localized_options']['attributes']['class'][] = 'active-trail';
    }

    // Allow menu-specific theme overrides.
    $element['#theme'] = 'menu_link__' . strtr($data['link']['menu_name'], '-', '_');
    $element['#attributes']['class'] = $class;
    $element['#title'] = $data['link']['title'];
    $element['#href'] = $data['link']['href'];
    $element['#localized_options'] = !empty($data['link']['localized_options']) ? $data['link']['localized_options'] : array();
    $element['#below'] = $data['below'] ? suitcase_interim_smartmenu_tree_output($data['below']) : $data['below'];
    $element['#original_link'] = $data['link'];
    // Index using the link's unique mlid.
    $build[$data['link']['mlid']] = $element;
  }
  if ($build) {
    // Make sure drupal_render() does not re-order the links.
    $build['#sorted'] = TRUE;
    $build['#attributes'] = $attributes;
    $build['#tree'] = $build;
    $build['#theme_wrappers'][] = 'smartmenu_tree';
  }

  return $build;
}