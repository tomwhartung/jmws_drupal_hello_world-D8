<?php
namespace Drupal\my_hugs\Heirarchy;

/**
 * Trivial base class for testing using namespaces with inheritance
 */
class TheBase {

  /**
   * Constructor in trivial class does something trivial yet very important 
   */
  public function __construct( $createdBy='' ) {
    error_log( 'This TheBase object was created by ' . $createdBy . '.' );
  }

  /**
   * Unused (so far) function for our trivial class
   */
  public function logToday() {
    error_log( 'TheBase is logging today.' );
  }
}
