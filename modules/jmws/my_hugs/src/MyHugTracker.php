<?php

namespace Drupal\my_hugs;

// use Drupal\my_hugs\TeachMe;                  // (0) source in same directory and namespace
use Drupal\my_hugs\LearningMore\LearningMore;   // (1a) source in sub dir and different namespace
// use Drupal\my_hugs\LearningMore;             // (1b) source in sub dir and different namespace

// use Drupal\my_hugs\Heirarchy\SubClass;   // (2a) trivial inheritance example - subclass
// use Drupal\my_hugs\Heirarchy\TheBase;    // (2a) trivial inheritance example - base class
use Drupal\my_hugs\Heirarchy;               // (2b) trivial inheritance example - namespace 

use Jmws\myservice\JmwsService;         // (3) we should really put the IdMyGadget code in vendor
use Jmws\myservice\JmwsServiceDrupal;   // (3) we should really put the IdMyGadget code in vendor
// use Jmws\myservice;         // (3) we should really put the IdMyGadget code in vendor

use Drupal\my_hugs\GoGlobal;            // (4) for now just create a global object, like we do for WP and Joomla

use Drupal\Core\State\StateInterface;


class MyHugTracker {

  /**
   * The state is/was used for the hugs functionality, we are not really using it anymore, but
   * it is here for possible future reference
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * For now, we are using global (non-namespaced) code to create our service
   * All Drupal code should use this class and the getService method to get this service
   *   rather !han access the global service object globally.
   * @var type
   */
  protected $service = null;

  /**
   * Try out ways of defining namespaces and external classes so we can have a service that
   * is created in global non-namespaced code.
   * This service is not really a hugtracker but more a stub of the global jmwsIdMyGadget object
   * we are using in WP and Joomla.
   * Yes the service should be in vendor (see case (3)),
   * but I tried that and couldn't get it to work (quickly)
   * 
   * @param StateInterface $state
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
    //
    // --------------------------------------
    // (0) We do NOT need the use statement here, but it doesn't hurt
    //    because TeachMe is in this same namespace, so it is autoloaded
    //
    // $teachMe = new TeachMe( 'MyHugTracker constructor' );
    //
    // --------------------------------------
    // (1a) works with (1a) only
    // $learningMore = new LearningMore( 'MyHugTracker constructor' );
    //
    // (1) Does NOT work with either (1a) or (1b), it looks for the class inside of this namespace
    // $learningMore = new Drupal\idmygadget\LearningMore\LearningMore( 'MyHugTracker constructor' );
    //
    // works with either (1a) OR (1b) but NOT BOTH
    // $learningMore = new \Drupal\idmygadget\LearningMore\LearningMore( 'MyHugTracker constructor' );
    //
    // --------------------------------------
    // (2a) Autoloading with inheritance can be a little tricky
    // (2b) Using just the one "use" works just as well as using both (2a) use statements
    // Interesting: I am not seeing this after adding this code to the MyHugStatus class?!?
    // // If we do not pull in TheBase class by creating the baseObject we get an error
    // // Ie. "Class 'Drupal\\idMyGadget\\Heirarchy\\TheBase' not found"
    // // This happens even though we have a use statement explicitly for TheBase
    // // (And it seems kinda fucked up to me....)
    //
    // $baseObject = new \Drupal\my_hugs\Heirarchy\TheBase( 'MyHugTracker constructor' );
    // $subObject = new \Drupal\my_hugs\Heirarchy\SubClass( 'MyHugTracker constructor' );

    // --------------------------------------
    // (3) the idmygadget code should really be in the vendor directory
    //
    // Based on my understanding of these pages:
    // https://www.drupal.org/node/2156625 and especially
    // https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md - Symfony Example
    // What I have should work.  Fuuuuuck ok I will try another technique
    //
    // This gives a "Class 'Jmws\\myservice\\JmwsService" error
    // $jmwsService = new \Jmws\myservice\JmwsService( 'MyHugStatus::build()' );
    //
    // This gives a "Class 'Drupal\\my_hugs\\Jmws\\myservice\\JmwsService' not found" error
    // $jmwsService = new Jmws\myservice\JmwsService( 'MyHugStatus::build()' );
    //
    //  This gives a "Class 'Jmws\\myservice\\JmwsService' not found" error
    // $jmwsService = new JmwsService( 'MyHugStatus::build()' );
    //
    // $jmwsServiceDrupal = new \Jmws\myservice\JmwsServiceDrupal( 'MyHugTracker constructor' );

    // --------------------------------------
    // This is the pattern we will use - for the time being
    // --------------------------------------
    // (4) for now just create a global idmygadget object, like we do for WP and Joomla
    // I.e., Create a namespaced and global object using the non-namespaced (global) idmygadget code in a separate directory
    //
    /*
    $namespacedObject = new \Drupal\my_hugs\GoGlobal\NamespacedService( 'MyHugTracker constructor' );
    $serviceObject = $namespacedObject->getGlobalServiceObject();
    $this->service = $serviceObject;
    $this->service->logToday( 'Hi hello how are you - from the MyHugTracker constructor!!' );
     */
  }

  /**
   * Returns the global service object that we have saved as a data member
   * Because the plan is to not rely on the global service object forever
   * @return type
   */
  public function getService() {
    return $this->service;
  }

  /**
   * We are not doing hugs much anymore so this method is pretty much obsolete
   * @param type $target_name
   * @return \Drupal\my_hugs\MyHugTracker
   */
  public function addMyHug($target_name) {
    $this->state->set('my_hugs.last_recipient', $target_name);
    return $this;
  }

  /**
   * We are not doing hugs much anymore so this method is pretty much obsolete
   *
   * @return type
   */
  public function getLastRecipient() {
    return $this->state->get('my_hugs.last_recipient');
  }
}
