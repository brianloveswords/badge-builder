<?php
require_once('../settings.php');
class Db {
  public $handle;
  public function __construct($settings = null) {
    if (empty($settings)) global $settings;
    $this->settings = $settings['db'];
    $this->connect();
  }
  public function connectionValid() {
    if (empty($this->handle)) return false;
    else return true;
  }
  public function connect() {
    $_db = $this->settings;
    $h = @mysql_connect($_db['host'], $_db['user'], $_db['pass']);
    if (!empty($h)) {
      // invalidate handle if we can't select the proper schema
      if (!mysql_select_db($_db['schema'], $h)) $h = false;
    }
    if (empty($h)) {
      $this->error = mysql_error();
      print_r($this->error);
    }
    return ($this->handle = $h);
  }
}