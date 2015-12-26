<?php
namespace Drupal\my_hugs\Heirarchy;

/**
 * Trivial subclass for testing using namespaces with inheritance
 */
class SubClass extends TheBase {

  /**
   * Constructor in trivial class does something trivial yet very important 
   */
  public function __construct( $createdBy='' ) {
    error_log( 'This SubClass object was created by ' . $createdBy . '.' );
  }

  /**
   * Unused (so far) function for our trivial class
   */
  public function logToday() {
    error_log( 'SubClass class is logging today.' );
  }
}
