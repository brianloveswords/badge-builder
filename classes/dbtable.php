<?php

class DbTableError extends Exception {}
class DbTable {
  public $db;
  public function __construct($db, $name) {
    if (empty($name) || !is_string($name)) {
      throw new DbTableError('Constructor: Invalid name');
    }
    if (empty($db) || empty($db->handle)) {
      throw new DbTableError('Constructor: Invalid Db class instance');
    }
    $escaped_name = mysql_real_escape_string($name);
    // make sure table exists
    if (!mysql_query(sprintf('SELECT 1 FROM `%s`', $escaped_name))) {
      $db->error = mysql_error();
      throw new DbTableError('Constructor: Invalid table: table could not be accessed (doesn\'t exist?)');
    }
    $this->db = $db;
    $this->name = $escaped_name;
  }
  public function name() {
    if (empty($this->db)) {
      throw new DbTableError('name(): Invalid Db class instance');
    }
    return $this->name;
  }
}