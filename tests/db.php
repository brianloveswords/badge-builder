<?php
require_once('simpletest/autorun.php');
require_once('../classes/db.php');

class TestOfDb extends UnitTestCase {
  /**
   * Assumes valid settings.php file!
   */
  function testDatabaseConnection() {
    $db = new Db();
    $this->assertTrue($db->connectionValid());
    $db2 = new Db(array('db'=>array()));
    $this->assertFalse($db2->connectionValid());
  }
}
