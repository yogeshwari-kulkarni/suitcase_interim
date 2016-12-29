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

function suitcase_interim_facetapi_deactivate_widget($variables) {
  return '&nbsp;&times;';
}

/*
 * Implements hook_form_FORMID_alter()
 */
function suitcase_interim_form_search_block_form_alter(&$form, &$form_state, $form_id) {
  $form['actions']['submit']['#value'] = '  ';
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