<?php
/**
 * @file
 * Contains \Drupal\jmws_hello_world_d8\Controller\JmwsHelloWorldD8Controller.
 * Reference: https://www.drupal.org/node/2464199
 */

namespace Drupal\jmws_hello_world_d8\Controller;

use Drupal\Core\Controller\ControllerBase;

class JmwsHelloWorldD8Controller extends ControllerBase {
  public function content() {
    return array(
        '#type' => 'markup',
        '#markup' => $this->t('Hello, World!'),
    );
  }
}
