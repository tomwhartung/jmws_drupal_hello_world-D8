<?php

namespace Drupal\my_hugs\Plugin\Block;

//
// Using this code to help understand how the namespaces, use statements, and autoloading all work together
// For details, see the comments in the build method.
//
use Drupal\my_hugs\TeachMe;                     // (0) source in same directory and namespace
use Drupal\my_hugs\LearningMore\LearningMore;   // (1a) source in sub dir and different namespace
// use Drupal\my_hugs\LearningMore;             // (1b) source in sub dir and different namespace

// use Drupal\my_hugs\Heirarchy\SubClass;   // (2a) trivial inheritance example - subclass
// use Drupal\my_hugs\Heirarchy\TheBase;    // (2a) trivial inheritance example - base class
use Drupal\my_hugs\Heirarchy;               // (2b) trivial inheritance example - namespace 

use Jmws\myservice\JmwsService;         // (3) we should really put the IdMyGadget code in vendor
use Jmws\myservice\JmwsServiceDrupal;   // (3) we should really put the IdMyGadget code in vendor
// use Jmws\myservice;                  // (3) we should really put the IdMyGadget code in vendor

use Drupal\my_hugs\GoGlobal;            // (4) for now just create a global object, like we do for WP and Joomla

use Drupal\my_hugs\JmwsIdMyGadget;

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
   * When it comes to hugs, MyHugTracker is a service
   * In this case, having experimented with a few different ways of doing this,
   * we are mainly using it to get a global service, rather than worry about doing it the
   * right way right now, which I presume would entail putting the IdMyGadget code into vendor
   * (was unable to do this based on current documentation, links provided below) and
   * making it all namespaced (not sure whether that would be necessary).
   * @var \Drupal\my_hugs\MyHugTracker
   */
  protected $myHugTracker;
  /**
   * This is our service, which in this case is trivial (writes to the error log)
   * The important thing is it is a global service object, that we can reference in the
   * new style drupal nanespaced code, via the MyHugTracker class (myHugTracker object)
   * @var type
   */
  protected $service;

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
    // --------------------------------------
    // (0) We need the "use Drupal\my_hugs\TeachMe;" statement, else we get this error:
    //   "Class 'Drupal\\my_hugs\\Plugin\\Block\\TeachMe' not found"
    // $teachMe = new TeachMe( 'MyHugStatus::build()' );

    // --------------------------------------
    // (1a) works with (1a) only
    // $learningMore = new LearningMore( 'MyHugStatus::build()' );
    //
    // (1) Does NOT work with either (1a) or (1b), it looks for the class inside of this namespace
    // ie: "Class 'Drupal\\my_hugs\\Plugin\\Block\\Drupal\\my_hugs\\LearningMore\\LearningMore' not found"
    // $learningMore = new Drupal\my_hugs\LearningMore\LearningMore( 'MyHugStatus::build()' );
    //
    // (1) works with either (1a) OR (1b) but NOT BOTH
    // $learningMore_1 = new \Drupal\my_hugs\LearningMore\LearningMore( 'MyHugStatus::build() - 1' );

    // --------------------------------------
    // (2a) Autoloading with inheritance can be a little tricky
    // (2b) Using just the one "use" works just as well as using both (2a) use statements
    // // (See comment in the MyHugTracker class....)
    // $baseObject = new \Drupal\my_hugs\Heirarchy\TheBase( 'MyHugStatus::build()' );
    // $subObject = new \Drupal\my_hugs\Heirarchy\SubClass( 'MyHugStatus::build()' );

    // --------------------------------------
    // (3) the idmygadget code should really be in the vendor directory
    //
    // Based on my understanding of these pages:
    // https://www.drupal.org/node/2156625 and especially
    // https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md - Symfony Example
    // What I have should work.  Fuuuuuck ok I will try another technique
    //
    // $jmwsService = new \Jmws\myservice\JmwsService( 'MyHugStatus::build()' );
    // $jmwsServiceDrupal = new \Jmws\myservice\JmwsServiceDrupal( 'MyHugStatus::build()' );

    // --------------------------------------
    // (4) Create a namespaced and global object using the non-namespaced (global) idmygadget code in a separate directory
    //
    // $namespacedObject = new \Drupal\my_hugs\GoGlobal\NamespacedService( 'MyHugStatus::build()' );
    // $serviceObject = new \Drupal\my_hugs\GoGlobal\GlobalService( 'MyHugStatus::build()' );
    // $serviceSubclassObject = new \Drupal\my_hugs\GoGlobal\GlobalServiceDrupal( 'MyHugStatus::build()' );

    // $jmwsIdMyGadget = new \Drupal\my_hugs\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
    // $jmwsIdMyGadget = new Drupal\my_hugs\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
    // $jmwsIdMyGadget = new JmwsIdMyGadgetDrupal();

    // $message .= '<br />Want to use our service to log messages so we know it can do that....';
    $message .= '<br />Using our service to log messages so we know it can do that.';
    $this->service = $this->myHugTracker->getService();
    $this->service->logToday( 'Hi from MyHugStatus::build()!!' );

    return [
      '#markup' => $message,
    ];
  }
}
