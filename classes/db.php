<?php
require_once('dbtable.php');

class DbError extends Exception { }
class Db {
  public $handle;
  private $error;
  
  public function __construct($settings = NULL) {
    if (empty($settings)) global $settings;
    $this->settings = $settings['db'];
    $this->connect();
  }
  
  public function connect() {
    $_db = $this->settings;
    // surpress errors
    $h = @mysql_connect($_db['host'], $_db['user'], $_db['pass']);
    if (empty($h)) {
      $this->error = mysql_error();
      throw new DbError("connect(): Could not connect to database");
    }
    // invalidate handle if can't switch to schema
    if (!mysql_select_db($_db['schema'], $h)){
      $this->error = mysql_error();
      throw new DbError("connect(): Could not switch to schema");
    }
    // store error if handle is invalid
    return ($this->handle = $h);
  }
  public function connectionValid() {
    if (empty($this->handle)) return FALSE;
    else return TRUE;
  }
  public function error() {
    return $this->error;
  }
  public function query($string) {
    $this->last_query = $string;
    return mysql_query($string);
  }
  public function useTable($name) {
    return new DbTable($this, $name);
  }
}