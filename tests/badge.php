<?php
require_once('simpletest/autorun.php');
require_once('../classes/badge.php');

class TestOfBadge extends UnitTestCase {
  function testCreatingNewBadge() {
    $data = array(
      'name' => 'Badge of Awesome',
      'description' => 'For being totally rad',
      'validation' => 'http://google.com',
      'image' => 'now this one is tricky...'
    );
    
    $badge = Badge::create($data);
    $this->assertTrue($badge instanceof Badge);
    $this->assertEqual($badge->name, 'Badge of Awesome');
    
    // don't create badge without data
    try {
      $badge2 = Badge::create('nahh');
      $this->assertTrue(FALSE); // fail, should not create badge;
    } catch (BadgeError $e) {
      $this->assertTrue(TRUE); // success;
    }
  }
}