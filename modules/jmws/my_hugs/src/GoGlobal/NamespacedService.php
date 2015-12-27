<?php
namespace Drupal\my_hugs\GoGlobal {

  class NamespacedService {
    public function __construct( $createdBy='' ) {
      error_log( 'This NamespacedService object was created by ' . $createdBy . '.' );
    }

    /**
     * Unused (so far) function for our trivial class
     */
    public function logToday() {
      error_log( 'NamespacedService is logging today.' );
    }
  }
}
//
// THis code is in the global namespace
//
namespace {
  // require_once 'GlobalService.php';
  // $globalServiceObject = new GlobalService( 'non-namespaced area in NamespacedService.php' );

  global $globalServiceObject;
  require_once 'GlobalServiceDrupal.php';
  $globalServiceObject = new GlobalServiceDrupal( 'non-namespaced area in NamespacedService.php' );
}
