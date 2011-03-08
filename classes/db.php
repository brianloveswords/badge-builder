<?php
require_once('../settings.php');
class Db {
  public $handle;
  public function __construct($settings = null) {
    if (empty($settings)) global $settings;
    $this->settings = $settings['db'];
    $this->connect();
  }
  public function connect() {
    $_db = $this->settings;
    // surpress errors
    $h = @mysql_connect($_db['host'], $_db['user'], $_db['pass']);
    // invalidate handle if can't switch to schema
    if (!empty($h) && !mysql_select_db($_db['schema'], $h)) $h = null;
    // store error if handle is invalid
    if (empty($h)) $this->error = mysql_error();
    return ($this->handle = $h);
  }
  public function connectionValid() {
    if (empty($this->handle)) return false;
    else return true;
  }
}