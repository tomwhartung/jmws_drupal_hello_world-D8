<?php
namespace;

class GlobalService {
	public function __construct( $createdBy='' ) {
		error_log( 'This GlobalService object was created by ' . $createdBy . '.' );
	}

	public function logToday() {
		error_log( 'GlobalService is logging today.' );
	}
}
