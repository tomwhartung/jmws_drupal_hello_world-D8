<?php
namespace Jmws\myservice;

class JmwsService {
	public function __construct( $createdBy='' ) {
		error_log( 'This JmwsService object was created by ' . $createdBy . '.' );
	}

	public function logToday() {
		error_log( 'JmwsService is logging today.' );
	}
}
