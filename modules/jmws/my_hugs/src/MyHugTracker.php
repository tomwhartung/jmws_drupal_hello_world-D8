<?php

namespace Drupal\my_hugs;

// use Drupal\my_hugs\TeachMe;         // (0)
use Drupal\my_hugs\LearningMore;
use Drupal\my_hugs\Heirarchy\SubClass;
use Drupal\my_hugs\Heirarchy\TheBase;

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
    $teachMe = new TeachMe( 'MyHugTracker constructor' );
	// $learningMore = new LearningMore();
	// $learningMore = new Drupal\idmygadget\LearningMore\LearningMore();
	// $learningMore = new \Drupal\idmygadget\LearningMore\LearningMore( 'GadgetDetector constructor' );
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
