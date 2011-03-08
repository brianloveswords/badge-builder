<?php
require_once('simpletest/autorun.php');
require_once('../classes/badge.php');

class TestOfBadge extends UnitTestCase {
  function testCreatingNewBadge() {
    $data = $this->generateBadgeData();
    $badge = Badge::create($data);
    $this->assertTrue($badge instanceof Badge);
    $this->assertEqual($badge->name, 'Badge of Awesome');
    
    // don't create badge without data
    try {
      $badge2 = Badge::create();
      $this->assertTrue(FALSE); // fail, should not create badge;
    } catch (BadgeError $e) {
      $this->assertTrue(TRUE); // success;
    }
  }

  function testSavingNewBadge() {
    $data = $this->generateBadgeData();
    $badge = Badge::create($data);
    $this->assertFalse($badge->isSaved());
    $badge->save();
    $this->assertTrue($badge->isSaved());
    $id = $badge->id;
    $this->assertFalse(empty($id));
  }

  
  /**
   * Assumes testing from localhost! The uuid gets generated with ip
   */
  function testFindingBadge() {
    $uuid = '3ce1874ffa0e2fba328fe4ec94acd7e65db56291';
    $badge = Badge::find(array('uuid' => $uuid));
    $this->assertTrue($badge instanceof Badge);
    $this->assertTrue($badge->isSaved());
    $this->assertEqual($badge->name, 'Badge of Awesome');
  }

  /**
   * Assumes testing from localhost! The uuid gets generated with ip
   */
  function testDeletingBadges() {
    $uuid = '3ce1874ffa0e2fba328fe4ec94acd7e65db56291';
    $badge = Badge::find(array('uuid' => $uuid));
    $this->assertTrue($badge->delete());
    $this->assertFalse($badge->isSaved());
    $id = $badge->id;
    $this->assertTrue(empty($id));
    $old_badge = Badge::find(array('uuid' => $uuid));
    
    print "<pre>";
    print_r($old_badge);
    print "</pre>";
    $this->assertTrue(empty($old_badge));
  }


  private function generateBadgeData() {
    return array(
      'name' => 'Badge of Awesome',
      'description' => 'For being totally rad',
      'validation' => 'http://google.com',
      'image' => 'now this one is tricky...'
    );
  }
}