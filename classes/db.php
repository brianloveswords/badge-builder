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
    $h = @mysql_connect($_db['host'], $_db['user'], $_db['password']);
    return ($this->handle = $h);
  }
}