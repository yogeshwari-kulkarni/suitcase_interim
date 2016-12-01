<?php

/**
 * Implements hook_form_system_theme_settings_alter()
 */
function suitcase_interim_form_system_theme_settings_alter(&$form, &$form_state) {

  if ($GLOBALS['theme_key'] == $form_state['build_info']['args'][0]) {

    $form['logo']['#access'] = FALSE;
    $form['logo']['settings']['logo_path']['#access'] = FALSE;
    $form['logo']['settings']['logo_upload']['#access'] = FALSE;
    $form['theme_settings']['toggle_logo']['#access'] = FALSE;

    //drupal_add_css(drupal_get_path('theme', 'alpha') . '/css/grid/alpha_fluid/normal/alpha-fluid-normal-12.css', array('group' => CSS_THEME, 'weight' => 100));
    drupal_add_css(drupal_get_path('theme', 'suitcase_interim') . '/css/suitcase-interim-header-preview.css', array('group' => CSS_THEME, 'weight' => 100));

    $form['suitcase_interim_config'] = array(
      '#type' => 'fieldset',
      '#title' => t('Suitcase Interim Config'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      '#description' => '',
      '#pre_render' => array(
        'suitcase_interim_config_form_pre_render',
      ),
      '#weight' => -100,
    );

    $form['suitcase_interim_config']['suitcase_interim_config_site_info'] = array(
      '#type' => 'fieldset',
      '#title' => t('Site Information'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      '#description' => '',
    );
    
    $form['suitcase_interim_config']['suitcase_interim_config_site_info']['suitcase_interim_config_level_1_url'] = array(
      '#type' => 'textfield',
      '#title' => t('Wordmark URL'),
      '#description' => t('Full URL the Iowa State University wordmark should link to. Defaults to \'http://www.iastate.edu/\''),
      '#default_value' => variable_get('suitcase_interim_config_level_1_url', 'http://www.iastate.edu/'),
      '#weight' => 2,
    );

    $form['suitcase_interim_config']['suitcase_interim_config_site_info']['suitcase_interim_config_level_2_url'] = array(
      '#type' => 'hidden',
      '#attributes' => array(
        'id' => 'edit-dept-url',
      ),
      '#title' => t('Level 2 URL'),
      '#description' => t('Full URL to the Department site'),
      '#default_value' => variable_get('suitcase_interim_config_level_2_url', NULL),
    );

    $form['suitcase_interim_config']['suitcase_interim_config_site_info']['suitcase_interim_config_level_2'] = array(
      '#type' => 'hidden',
      '#attributes' => array(
        'id' => 'edit-site-name',
      ),
      '#title' => t('Level 2 (Department, College, or Consortium)'),
      '#description' => t('Displays under the wordmark & defaults to "Iowa State University"'),
      '#default_value' => variable_get('suitcase_interim_config_level_2', NULL),
    );

    $form['suitcase_interim_config']['suitcase_interim_config_site_info']['suitcase_interim_config_level_3'] = array(
      '#type' => 'hidden',
      '#attributes' => array(
        'id' => 'edit-site-slogan',
      ),
      '#title' => t('Level 3 (Lab or Entity name)'),
      '#description' => t('Displays under the Level 2 text'),
      '#default_value' => variable_get('suitcase_interim_config_level_3', NULL),
    );

    $form['suitcase_interim_config']['suitcase_interim_config_site_info']['suitcase_interim_config_header_type']= array(
      '#type' => 'hidden',
      '#attributes' => array(
        'id' => 'edit-header-type',
      ),
      '#title' => t('Header type'),
      '#description' => t('The type of header to display'),
      '#default_value' => variable_get('suitcase_interim_config_header_type', 1),
    );

    $form['suitcase_interim_config']['suitcase_interim_config_layout'] = array(
      '#type' => 'fieldset',
      '#title' => t('Layout'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      '#description' => '',
    );

    $form['suitcase_interim_config']['suitcase_interim_config_layout']['suitcase_interim_config_blackbar_display'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show black bar'),
      '#description' => t('The black bar contains the Iowa State University links to ISU Sign-ons, Directory, Maps, ISU Contact Us, and the index.'),
      '#default_value' => variable_get('suitcase_interim_config_blackbar_display', 1),
    );

    $form['suitcase_interim_config']['suitcase_interim_config_layout']['suitcase_interim_config_isu_nameplate_display'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show ISU nameplate'),
      '#description' => t('The ISU nameplate identifies Iowa State University above the site name and department title.'),
      '#default_value' => variable_get('suitcase_interim_config_isu_nameplate_display', 1),
    );

    array_unshift($form['#submit'], 'suitcase_interim_config_form_submit');

  }

}

function suitcase_interim_config_form_pre_render($element) {

  $element['#prefix'] = theme_render_template(drupal_get_path('theme', 'suitcase_interim') . '/templates/form--system-theme-settings.tpl.php', array('form' => $element));

  return $element;

}

function suitcase_interim_config_form_submit($form, &$form_state) {

  variable_set('suitcase_interim_config_level_1_url', $form_state['values']['suitcase_interim_config_level_1_url']);

  variable_set('suitcase_interim_config_level_2_url', $form_state['values']['suitcase_interim_config_level_2_url']);

  // Level 2
  $suitcase_interim_config_level_2 = $form_state['values']['suitcase_interim_config_level_2'];
  variable_set('suitcase_interim_config_level_2', $suitcase_interim_config_level_2);

  // Level 3
  $suitcase_interim_config_level_3 = $form_state['values']['suitcase_interim_config_level_3'];
  variable_set('suitcase_interim_config_level_3', $suitcase_interim_config_level_3);

  // Type of header
  $header_type = $form_state['values']['suitcase_interim_config_header_type'];
  variable_set('suitcase_interim_config_header_type', $header_type);

  variable_set('suitcase_interim_config_blackbar_display', $form_state['values']['suitcase_interim_config_blackbar_display']);

  variable_set('suitcase_interim_config_isu_nameplate_display', $form_state['values']['suitcase_interim_config_isu_nameplate_display']);

  // Decide which level the site name should be set to
  $site_name = NULL;
  if (_suitcase_interim_config_is_showing_this_header_level(3, $header_type)) {
    $site_name = $suitcase_interim_config_level_3;
  }
  elseif (_suitcase_interim_config_is_showing_this_header_level(2, $header_type)) {
    $site_name = $suitcase_interim_config_level_2;
  }

  if (!$site_name) {
    $site_name = 'Iowa State University';
  }

  variable_set('site_name', $site_name);

}


/**
 * Determine if we are showing the level 2 (sometimes referred to the "department name")
 */
function _suitcase_interim_config_is_showing_this_header_level($level, $header_type=NULL) {
  if (!$header_type)
    $header_type = variable_get('suitcase_interim_config_header_type', NULL);

  if (!$header_type) {
    // Fail gracefully or raise an error?
    return FALSE;
  }
  elseif ($level == 2) {
    return in_array($header_type, array(1, 2));
  }
  elseif ($level == 3) {
    return in_array($header_type, array(1, 3));
  }
  else {
    return FALSE;
  }
}
