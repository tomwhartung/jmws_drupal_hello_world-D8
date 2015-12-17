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
      '#title' => $this->t('Default my_hug count'),
      '#default_value' => $config->get('default_count'),
    ];

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
