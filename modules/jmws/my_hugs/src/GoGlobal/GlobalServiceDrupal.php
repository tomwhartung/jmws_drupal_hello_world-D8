<?php
namespace {
  require 'GlobalService.php';

  class GlobalServiceDrupal extends GlobalService {
    public function __construct( $createdBy='' ) {
      error_log( 'This GlobalServiceDrupal object was created by ' . $createdBy . '.' );
    }

    /**
     * Trivial function for our trivial class
     * I think we will actually use this one to verify everything works!
     */
    public function logToday( $message='' ) {
      if ( $message == '' ) {
        error_log( 'GlobalServiceDrupal class is logging today.' );
      } else {
        error_log( 'GlobalServiceDrupal message is: ' . $message );
      }
      parent::logToday( $message );
    }
  }
}
