<?php
namespace Drupal\my_hugs\LearningMore;

class LearningMore {
	public function __construct( $createdBy='' ) {
		error_log( 'This LearningMore object was created by ' . $createdBy . '.' );
	}

	public function learningMore() {
		error_log( 'LearningMore in learningMore() today.' );
	}
}
