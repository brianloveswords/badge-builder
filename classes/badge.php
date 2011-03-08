<?php
require_once('db.php');
class Badge {
  private $data;
  private function __construct($data){
    $this->data = $data;
  }
  public function __get($name) {
    return $this->data[$name];
  }
  public static function create($data) {
    $c = __CLASS__;
    return new $c($data);
  }
}