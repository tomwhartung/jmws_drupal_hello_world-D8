<?php

namespace Drupal\my_hugs\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\my_hugs\MyHugTracker;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on myHugability status.
 *
 * @Block(
 *   id = "my_hugs_status",
 *   admin_label = @Translation("MyHug status"),
 *   category = @Translation("System")
 * )
 */
class MyHugStatus extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\my_hugs\MyHugTracker
   */
  protected $myHugTracker;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, MyHugTracker $myHugTracker) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->myHugTracker = $myHugTracker;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('my_hugs.my_hug_tracker')
    );
  }

  public function defaultConfiguration() {
    return ['enabled' => 1];
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('MyHugging enabled'),
      '#default_value' => $this->configuration['enabled'],
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = (bool)$form_state->getValue('enabled');
  }

  public function build() {
    if ($this->configuration['enabled']) {
      $message = $this->t('@to was the last person my_hugged', [
        '@to' => $this->myHugTracker->getLastRecipient()
      ]);
    }
    else {
      $message = $this->t('Srsly wtf, no my_hugs :-(');
    }
    return [
      '#markup' => $message,
    ];
  }
}
