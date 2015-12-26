<?php
namespace Jmws\myservice;

class JmwsServiceDrupal extends JmwsService {
	public function __construct( $createdBy='' ) {
		error_log( 'This JmwsServiceDrupal object was created by ' . $createdBy . '.' );
	}

	public function logToday() {
		error_log( 'JmwsServiceDrupal class is logging today.' );
	}
}
