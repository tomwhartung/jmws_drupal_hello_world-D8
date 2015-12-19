<?php

namespace Drupal\my_hugs\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {
  public function getFormId() {
    return 'my_hug_config';
  }

  /**
   * This form is entirely experimental, being used to see what works and what doesn't
   * @param array $form
   * @param FormStateInterface $form_state
   * @return type
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = $this->idMyGadget_admin_heading_phones();

    $config = $this->config('my_hugs.settings');

    $form['default_count'] = [
      '#type' => 'number',
      '#title' => $this->t('Default my_hug counttttt'),
      '#default_value' => $config->get('default_count'),
    ];

    $form['exp_string'] = [
      '#type' => 'string',
      '#title' => $this->t('Experimental string defined in ConfigForm class'),
	  '#default_value' => $config->get('default_count'),
    ];

    $form['exp_textfield'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Experimental textfield input defined in ConfigForm class'),
      '#default_value' => $config->get('exp_textfield'),
    ];

    $form['exp_number'] = [
      '#type' => 'number',
      '#title' => $this->t('Experimental number input field defined in ConfigForm class'),
      '#default_value' => $config->get('exp_number'),
    ];

    $form['exp_radio'] = [
      '#type' => 'radio',
      '#title' => $this->t('Experimental radio defined in ConfigForm class'),
      '#default_value' => $config->get('exp_radio'),
    ];

    $form['exp_input'] = [
      '#type' => 'input',
      '#title' => $this->t('Experimental input defined in ConfigForm class'),
      '#default_value' => $config->get('exp_input'),
    ];

    $form['exp_textarea'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Experimental textarea input defined in ConfigForm class'),
      '#default_value' => $config->get('exp_textarea'),
    ];

   $supported_gadget_detectors = array(
      'detect_mobile_browsers',   // note that this is used as the default throughout
      'mobile_detect',
      'tera_wurfl',
      'no_detection'      // defaults to desktop (allows for isolating responsive behavior)
   );
   //
   // Add a section to the module's Settings screen that contains
   // radio buttons allowing the admin to set the device detector.
   // This shows up under Configuration -> IdMyGadget -> Gadget Detector
   //
   $form['idmg_gadget_detector'] = array(
      '#type' => 'radios',
      '#title' => t('Gadget Detector (ConfigForm)'),
      // '#default_value' => $supported_gadget_detectors[0],
	  '#default_value' => $config->get('idmg_gadget_detector'),
      '#options' => $supported_gadget_detectors,
      '#description' => $this->t('Select the 3rd party device detector to use for this site.'),
      '#required' => TRUE,
   );

   $radio_choices = array(
      'No',   // note that this is used as the default throughout
      'Yes',
   );
   $form['idmg_phone_nav_on_phones'] = array(
      '#type' => 'radios',
      '#title' => t( 'Show Header/Footer Nav on phones?' ),
      // '#default_value' => $radio_choices[1],
	  '#default_value' => $config->get('idmg_phone_nav_on_phones'),
      '#options' => $radio_choices,
      '#description' => $this->t( 'Select whether the jQuery Header and Footer Nav Menu should appear on phones.' ),
      '#required' => FALSE,
   );

   $jqueryMobileThemeChoices = array( 'a', 'b', 'c', 'd', 'e', 'f' );
   
    return parent::buildForm($form, $form_state);
  }
/**
 * Admin config function to allow customization of the site heading on phones
 */
public function idMyGadget_admin_heading_phones()
{
   $form = $this->idMyGadget_admin_heading( 'phone' );
   return $form;
}

/**
 * Admin config function to allow customization of the site heading on phones
 */
public function idMyGadget_admin_heading( $gadget_type )
{
   global $jmwsIdMyGadget;
   // checkJmwsIdMyGadgetObject();

   // $radio_choices = $jmwsIdMyGadget->translatedRadioChoices;
   $radio_choices = array(
      'No',   // note that this is used as the default throughout
      'Yes',
   );
   $default_radio_choice = $radio_choices[0];
   // $validElements = JmwsIdMyGadgetDrupal::$validElements;
   $validElements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );
   $default_valid_element = $validElements[0];

   $gadget_type_plural = $gadget_type . 's';
   $gadget_type_ucfirst = ucfirst( $gadget_type );
   $gadget_type_plural_ucfirst = ucfirst( $gadget_type_plural );
   $form = array();

   $setting_name = 'idmg_logo_file_' . $gadget_type;     // e.g., 'idmg_logo_file_phone'
   $form[$setting_name] = array(
      '#type' => 'textfield',
      '#title' => t( 'Logo for ' . $gadget_type_plural_ucfirst ),
      // '#default_value' => variable_get( $setting_name, '' ),
      '#size' => 100,
      '#maxlength' => 200,
      '#description' => t( 'The logo image to display on ' . $gadget_type_plural . '.' ),
      '#required' => FALSE,
   );
   //
   // FIXME: This logo file field doesn't seem to work, but it's a step in the right direction
   //
   $setting_name = 'idmg_logo_file_upload_' . $gadget_type;   // e.g., 'idmg_logo_file_upload_phone'
   $form[$setting_name] = array(
      '#type' => 'file',
   // '#title' => t( 'Upload logo image for ' . $gadget_type_plural_ucfirst . '?' ),
      '#title' => t( 'WTF is wrong with this title thingie?' ),
      // '#default_value' => variable_get( $setting_name, '' ),
      '#description' => t( 'Upload an image to display in the heading of this site on ' . $gadget_type_plural . '.' ),
   // '#title_display' => 'invisible',
   // '#title_display' => 'before',
      '#title_display' => 'after',
      '#size' => 22,
      '#theme_wrappers' => array(),
      '#required' => FALSE,
   );

   $setting_name = 'idmg_show_site_name_' . $gadget_type;   // e.g., 'idmg_show_site_name_phone'
   $form[$setting_name] = array(
      '#type' => 'radios',
      '#title' => t( 'Show Site Name on ' . $gadget_type_plural_ucfirst . '?' ),
      // '#default_value' => variable_get( $setting_name, $default_radio_choice ),
      '#options' => $radio_choices,
      '#description' => t( 'Select whether you want the name of this site to display in the header on ' . $gadget_type_plural . '.' ),
      '#required' => TRUE,
   );

   $setting_name = 'idmg_site_name_element_' . $gadget_type;     // e.g., 'idmg_site_name_element_phone'
   $form[$setting_name] = array(
      '#type' => 'select',
      '#title' => t( 'Site Name Element ' . $gadget_type_ucfirst ),
      // '#default_value' => variable_get( $setting_name, $default_valid_element ),
      '#options' => $validElements,
      '#description' => t( 'Select the html element in which you want to display the name of this site in the header on ' . $gadget_type_plural . '.' ),
      '#required' => FALSE,
   );

   $setting_name = 'idmg_site_title_' . $gadget_type;     // e.g., 'idmg_site_title_phone'
   $form[$setting_name] = array(
      '#type' => 'textfield',
      '#title' => t( 'Site Title on ' . $gadget_type_plural_ucfirst ),
      // '#default_value' => variable_get( $setting_name, '' ),
      '#size' => 60,
      '#maxlength' => 100,
      '#description' => t( 'The site title to display on ' . $gadget_type_plural . '.' ),
      '#required' => FALSE,
   );

   $setting_name = 'idmg_site_title_element_' . $gadget_type;     // e.g., 'idmg_site_title_element_phone'
   $form[$setting_name] = array(
      '#type' => 'select',
      '#title' => t( 'Site Title Element ' . $gadget_type_ucfirst ),
      // '#default_value' => variable_get( $setting_name, $default_valid_element ),
      '#options' => $validElements,
      '#description' => t( 'Select the html element in which you want to display the site title in the header on ' . $gadget_type_plural . '.' ),
      '#required' => FALSE,
   );

   $setting_name = 'idmg_site_description_' . $gadget_type;     // e.g., 'idmg_site_description_phone'
   $form[$setting_name] = array(
      '#type' => 'textfield',
      '#title' => t( 'Site Slogan on ' . $gadget_type_plural_ucfirst ),
      // '#default_value' => variable_get( $setting_name, '' ),
      '#size' => 60,
      '#maxlength' => 100,
      '#description' => t('The site slogan to display on ' . $gadget_type_plural . '.'),
      '#required' => FALSE,
   );

   $setting_name = 'idmg_site_description_element_' . $gadget_type;     // e.g., 'idmg_site_description_element_phone'
   $form[$setting_name] = array(
      '#type' => 'select',
      '#title' => t( 'Site Slogan Element ' . $gadget_type_ucfirst ),
      // '#default_value' => variable_get( $setting_name, $default_valid_element ),
      '#options' => $validElements,
      '#description' => t( 'Select the html element in which you want to display the site slogan in the header on ' . $gadget_type_plural . '.' ),
      '#required' => FALSE,
   );

// return system_settings_form( $form );
   return $form;   // NOTE: calling fcn runs system_settings_form !!!
}

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('my_hugs.settings');
    $config->set('default_count', $form_state->getValue('default_count'));
    $config->set('exp_textfield', $form_state->getValue('exp_textfield'));
    $config->set('exp_number', $form_state->getValue('exp_number'));
    $config->set('exp_radio', $form_state->getValue('exp_radio'));
    $config->set('exp_textarea', $form_state->getValue('exp_textarea'));
    $config->set('idmg_gadget_detector', $form_state->getValue('idmg_gadget_detector'));
    $config->set('idmg_phone_nav_on_phones', $form_state->getValue('idmg_phone_nav_on_phones'));
    // $config->set('xyz', $form_state->getValue('xyz'));

	$config->save();
  }

  public function getEditableConfigNames() {
    return ['my_hugs.settings'];
  }
}
