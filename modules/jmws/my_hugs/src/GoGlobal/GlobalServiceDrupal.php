<?php
namespace;

class GlobalServiceDrupal extends GlobalService {
	public function __construct( $createdBy='' ) {
		error_log( 'This GlobalServiceDrupal object was created by ' . $createdBy . '.' );
	}

	public function logToday() {
		error_log( 'GlobalServiceDrupal class is logging today.' );
	}
}
