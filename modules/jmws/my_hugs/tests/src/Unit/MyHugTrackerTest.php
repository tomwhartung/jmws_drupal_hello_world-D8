<?php
/**
 * @contains Drupal\Test\my_hugs\Unit\MyHugTrackerTest.
 */

namespace Drupal\Tests\my_hugs\Unit;

use Drupal\my_hugs\MyHugTracker;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\State\StateInterface;

/**
 * Tests the MyHug Tracker service.
 *
 * @group MyHug
 */
class MyHugTrackerTest extends UnitTestCase {

  public function testAddMyHug() {
    // Note: The ::class syntax is PHP 5.5. You can also specify the full class
    // name as a string literal.
    $state = $this->prophesize(StateInterface::class);
    $state->set('my_hugs.last_recipient', 'Dries')->shouldBeCalled();

    $tracker = new MyHugTracker($state->reveal());
    $tracker->addMyHug('Dries');
  }

  public function testGetLastRecipient() {
    $state = $this->prophesize(StateInterface::class);
    $state->get('my_hugs.last_recipient')->willReturn('Dries');

    $tracker = new MyHugTracker($state->reveal());
    $this->assertEquals('Dries', $tracker->getLastRecipient());
  }

}
