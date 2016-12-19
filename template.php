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

/* Menu List Theme Functions */

/*
 * Clone of theme_links that also adds the active classes for absolute url
 * matches (including query string). This does not handle the case, which might
 * be considered a core bug, where multiple menu items that link to the same
 * page and differ only in query strings will both highlight upon visiting
 * either of them.
 */
function suitcase_interim_menu_links($variables)  {

  $links = $variables['links'];
  $attributes = $variables['attributes'];
  $heading = $variables['heading'];
  global $language_url;
  $output = '';

  if (count($links) > 0) {
    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,
          // Set the default level of the heading.
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = array($key);

      // Add first, last and active classes to the list of links to help out
      // themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }
      if (isset($link['href']) && (($link['href'] == $_GET['q'] || $link['href'] == ($GLOBALS['base_root'] . request_uri())) || ($link['href'] == '<front>' && drupal_is_front_page()))
        && (empty($link['language']) || $link['language']->language == $language_url->language)) {
        $class[] = 'active';
        $class[] = 'active-trail';
        $link['attributes']['class'][] = 'active';
        $link['attributes']['class'][] = 'active-trail';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      elseif (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for
        // adding title and class attributes.
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;

}

/*
 * Implements theme_links__system_main_menu()
 */
function suitcase_interim_links__system_main_menu($variables) {
  return suitcase_interim_menu_links($variables);
}

/*
 * Implements theme_links__system_secondary_menu()
 */
function suitcase_interim_links__system_secondary_menu($variables) {
  return suitcase_interim_menu_links($variables);
}