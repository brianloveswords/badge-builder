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
  /**
   * Assumes structure for `testing` table:
   *    id INT PRIMARY KEY AUTO_INCREMENT
   *    mandatory VARCHAR(255) NOT NULL
   *    optional VARCHAR(255) NULL
   */
  function testDatabaseInsertIntoTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $values = array(
      'mandatory' => NULL,
      'optional' => 'lol',
    );
    // invalid types should throw error
    try {
      $table->insert('should fail');
      $this->asserTrue(FALSE); // fail
    } catch (DbTableError $e) {
      $this->assertTrue(TRUE);
    }
    // invalid values should return false and store error
    $this->assertFalse($table->insert($values));
    $error = $table->error();
    $this->assertTrue(!empty($error));
    // valid valuese should return true
    $values['mandatory'] = 'wut';
    $this->assertTrue(is_numeric($table->insert($values)));
  }
  
  function testDatabaseSelectOneFromTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $id = $table->insert(array('mandatory' => 'wut','optional' => 'lol',));
    $obj = $table->findOne(array('id' => $id));
    $this->assertTrue(is_object($obj));
    $this->assertEqual($obj->mandatory, 'wut');
    $this->assertEqual($obj->optional, 'lol');
  }
}
