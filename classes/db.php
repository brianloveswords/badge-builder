<?php
require_once('../settings.php');
require_once('dbtable.php');

class Db {
  public $handle;
  public function __construct($settings = NULL) {
    if (empty($settings)) global $settings;
    $this->settings = $settings['db'];
    $this->connect();
  }
  
  public function connect() {
    $_db = $this->settings;
    // surpress errors
    $h = @mysql_connect($_db['host'], $_db['user'], $_db['pass']);
    // invalidate handle if can't switch to schema
    if (!empty($h) && !mysql_select_db($_db['schema'], $h)) $h = NULL;
    // store error if handle is invalid
    if (empty($h)) $this->error = mysql_error();
    return ($this->handle = $h);
  }
  public function connectionValid() {
    if (empty($this->handle)) return FALSE;
    else return TRUE;
  }

  public function query($string) {
    $this->last_query = $string;
    return mysql_query($string);
  }
  public function useTable($name) {
    return new DbTable($this, $name);
  }
}