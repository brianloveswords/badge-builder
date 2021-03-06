<?php
require_once('simpletest/autorun.php');
require_once('../settings.php');
require_once('../classes/db.php');

class TestOfDb extends UnitTestCase {
  /**
   * Assumes valid settings.php file!
   */
  function testDatabaseConnection() {
    $db = new Db();
    $this->assertTrue($db->connectionValid());
    
    try {
      $db2 = new Db(array('db'=>array()));
      $this->assertTrue(FALSE); // fail, should not connect with bad data
    } catch(DbError $e) {
      $this->assertTrue(TRUE);
    }
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
  
  function testDatabaseGetFieldsFromTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $fields = $table->fields();
    $this->assertTrue(is_array($fields));
    $this->assertTrue(!empty($fields['id']));
  }
  
  function testDatabaseSelectOneFromTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $id = $table->insert(array('mandatory' => 'wut','optional' => 'lol',));
    $obj = $table->findOne(array('id' => $id));
    $this->assertTrue(is_object($obj));
    $this->assertEqual($obj->mandatory, 'wut');
    $this->assertEqual($obj->optional, 'lol');
    
    try {
      $failobj = $table->findOne(array('bird' => $id));
      $this->assertTrue(FALSE); // fail, should throw error
    } catch (DbTableError $e) {
      $this->assertTrue(TRUE); // succeed
    }
  }

  function testDatabaseSelectAllFromTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $table->insert(array('mandatory' => ';(','optional' => 'wah',));
    $table->insert(array('mandatory' => ':|','optional' => 'meh',));
    $table->insert(array('mandatory' => ':D'));
    
    $rows = $table->findAll();
    $this->assertTrue(count($rows) >= 3);
    $this->assertTrue(is_string($rows[0]->mandatory));
  }

  function testDatabaseDeleteFromTable() {
    $db = new Db();
    $table = $db->useTable('testing');
    $id = $table->insert(array('mandatory' => ':D'));
    $this->assertTrue($table->deleteOne(array('id' => $id)));
    $old_thing = $table->findOne(array('id' => $id));
    $this->assertTrue(empty($old_thing));
  }

}
