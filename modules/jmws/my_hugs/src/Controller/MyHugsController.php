<?php

namespace Drupal\my_hugs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\my_hugs\MyHugTracker;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\NodeInterface;

class MyHugsController extends ControllerBase {

  /**
   * @var \Drupal\my_hugs\MyHugTracker
   */
  protected $myHugTracker;

  public function __construct(MyHugTracker $tracker) {
    $this->myHugTracker = $tracker;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('my_hugs.my_hug_tracker'));
  }

  public function nodeMyHug(NodeInterface $node) {
    if ($node->isPublished()) {
      // These are the same!
      $body = $node->body->value;
      $body = $node->body[0]->value;

      // But we really want...
      $formatted = $node->body->processed;

      $terms = [];
      foreach ($node->field_tags as $tag) {
        $terms[] = $tag->entity->label();
      }

      $message = $this->t('Everyone give @name a my_hug because @reasons!', [
        '@name' => $node->getOwner()->label(),
        '@reasons' => implode(', ', $terms),
      ]);

      return [
        '#title' => $node->label() . ' (' . $node->bundle() . ')',
        '#markup' => $message . $formatted,
      ];
    }
    return $this->t('Not published');
  }

  /**
   *  To run this method, use an url such as this:
   *    http://jane.tomhartung.com/my_hug/jane/tom/2
   */
  public function myHug($to, $from, $count) {
    $this->myHugTracker->addMyHug($to);
    if (!$count) {
      $count = $this->config('my_hugs.settings')->get('default_count');
    }
    return [
      '#theme' => 'my_hug_page',
      '#from' => $from,
      '#to' => $to,
      '#count' => $count
    ];
  }

  public function myHug3($to, $from, $count) {
    if (!$count) {
      $count = $this->config('my_hugs.settings')->get('default_count');
    }
    return [
      '#theme' => 'my_hug_page',
      '#from' => $from,
      '#to' => $to,
      '#count' => $count
    ];
  }

  public function myHug2($to, $from) {
    return [
      '#theme' => 'my_hug_page',
      '#from' => $from,
      '#to' => $to,
    ];
  }

  /**
   *  Original version, from about 18:00 in the video
   *  Returns render array with markup (simplest version)
   */
  public function myHug1($to, $from) {
    $message = $this->t('%from sends my_hugs to %to', [
      '%from' => $from,
      '%to' => $to,
    ]);

    return $message;
  }
}
