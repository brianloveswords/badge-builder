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
  
  /**
   * Assumes an existing `testing` table!
   */
  function testDatabaseUseTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $this->assertTrue(is_object($table));
    $this->assertTrue($table->name() == 'testing');
  }
  
  function testDatabaseUpdateTable() { }
  function testDatabaseInsertIntoTable() { }
  function testDatabaseSelectFromTable() { }
}
