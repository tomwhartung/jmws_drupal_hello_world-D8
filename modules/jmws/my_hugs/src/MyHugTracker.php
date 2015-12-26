<?php

namespace Drupal\my_hugs;

// use Drupal\my_hugs\TeachMe;                  // (0) source in same directory and namespace
use Drupal\my_hugs\LearningMore\LearningMore;   // (1a) source in sub dir and different namespace
// use Drupal\my_hugs\LearningMore;             // (1b) source in sub dir and different namespace

use Drupal\my_hugs\Heirarchy\SubClass;    // (2)
use Drupal\my_hugs\Heirarchy\TheBase;     // (2)

use Drupal\Core\State\StateInterface;


class MyHugTracker {

  /**
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
    //
    // (0) We do NOT need the use statement here, but it doesn't hurt
    //    because TeachMe is in this same namespace, so it is autoloaded
    //
    // $teachMe = new TeachMe( 'MyHugTracker constructor' );
    //
    // (1a) works with (1a) only
    // $learningMore = new LearningMore( 'MyHugTracker constructor' );
    //
    // (1) Does NOT work with either (1a) or (1b), it looks for the class inside of this namespace
    // $learningMore = new Drupal\idmygadget\LearningMore\LearningMore( 'MyHugTracker constructor' );
    //
    // works with either (1a) OR (1b) but NOT BOTH
    $learningMore = new \Drupal\idmygadget\LearningMore\LearningMore( 'MyHugTracker constructor' );
  //
	// This demonstrates that autoloading with inheritance can be a little tricky
	// If we do not pull in TheBase class by creating the baseObject we get an error
	// Ie. "Class 'Drupal\\idMyGadget\\Heirarchy\\TheBase' not found"
	// This happens even though we have a use statement explicitly for TheBase
	//
	// $baseObject = new \Drupal\idmygadget\Heirarchy\TheBase( 'MyHugTracker constructor' );
	// $subObject = new \Drupal\idmygadget\Heirarchy\SubClass( 'MyHugTracker constructor' );

  }

  public function addMyHug($target_name) {
    $this->state->set('my_hugs.last_recipient', $target_name);
    return $this;
  }

  public function getLastRecipient() {
    return $this->state->get('my_hugs.last_recipient');
  }
}
