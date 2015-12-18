<?php

namespace Drupal\my_hugs\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {
  public function getFormId() {
    return 'my_hug_config';
  }

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

    $form['exp_text'] = [
      '#type' => 'text',
      '#title' => $this->t('Experimental text input defined in ConfigForm class'),
      '#default_value' => 'default value for experimental text',
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

   $radio_choices = array(
      'detect_mobile_browsers',   // note that this is used as the default throughout
      'mobile_detect',
      'tera_wurfl',
      'no_detection'      // defaults to desktop (allows for isolating responsive behavior)
   );

   $form['idmg_phone_nav_on_phones'] = array(
      '#type' => 'radios',
      '#title' => t( 'Show Header/Footer Nav on phones?' ),
      '#default_value' => $radio_choices[1],
      '#options' => $radio_choices,
      '#description' => $this->t( 'Select whether the jQuery Header and Footer Nav Menu should appear on phones.' ),
      '#required' => FALSE,
   );

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
