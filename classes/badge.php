<?php
require_once('db.php');
class BadgeError extends Exception {}
class Badge {
  private $data;
  private $dirty = FALSE;
  private function __construct($data){
    $this->data = $data;
  }
  public function __get($name) {
    return $this->data[$name];
  }
  /*
  public function __set($name, $value) {
    $this->dirty = TRUE;
    return $this->data[$name] = $value;
  }
  */
  public static function create($data) {
    if (!is_array($data)) {
      throw new BadgeError('Badge::create(): parameter must be an associative array');
    }
    $c = __CLASS__;
    return new $c($data);
  }
}