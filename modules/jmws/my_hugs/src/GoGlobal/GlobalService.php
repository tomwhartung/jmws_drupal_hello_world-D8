<?php
namespace {

  class GlobalService {
    public function __construct( $createdBy='' ) {
      error_log( 'This GlobalService object was created by ' . $createdBy . '.' );
    }

    /**
     * Unused (so far) function for our trivial class
     */
    public function logToday( $message='' ) {
      if ( $message == '' ) {
        error_log( 'GlobalService class is logging today.' );
      } else {
        error_log( 'GlobalService message is: ' . $message );
      }
    }
  }
}
