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
    $config = $this->config('my_hugs.settings');

    $form['default_count'] = [
      '#type' => 'number',
      '#title' => $this->t('Default my_hug counttttt'),
      '#default_value' => $config->get('default_count'),
    ];

    $form['exp_string'] = [
      '#type' => 'string',
      '#title' => $this->t('Experimental string defined in ConfigForm class'),
      '#default_value' => 'default string value',
    ];

    $form['exp_textfield'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Experimental textfield input defined in ConfigForm class'),
      '#default_value' => 'default value for experimental textfield',
    ];

    $form['exp_number'] = [
      '#type' => 'number',
      '#title' => $this->t('Experimental number input field defined in ConfigForm class'),
      '#default_value' => '0',
    ];

    $form['exp_radio'] = [
      '#type' => 'radio',
      '#title' => $this->t('Experimental radio defined in ConfigForm class'),
      '#default_value' => 'default radio value',
    ];

    $form['exp_input'] = [
      '#type' => 'input',
      '#title' => $this->t('Experimental input defined in ConfigForm class'),
      '#default_value' => 'default input value',
    ];

    $form['exp_textarea'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Experimental textarea input defined in ConfigForm class'),
      '#default_value' => 'Here is a default value for the experimental textarea',
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
      '#default_value' => $supported_gadget_detectors[0],
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
      '#default_value' => $radio_choices[1],
      '#options' => $radio_choices,
      '#description' => $this->t( 'Select whether the jQuery Header and Footer Nav Menu should appear on phones.' ),
      '#required' => FALSE,
   );

   $validElements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );

   $jqueryMobileThemeChoices = array( 'a', 'b', 'c', 'd', 'e', 'f' );
   
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('my_hugs.settings');
    $config->set('default_count', $form_state->getValue('default_count'));
    $config->save();
  }

  public function getEditableConfigNames() {
    return ['my_hugs.settings'];
  }
}
