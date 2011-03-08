<?php
/* created with:
  
  CREATE TABLE badge (
      id INT PRIMARY KEY AUTO_INCREMENT,
      uuid VARCHAR(255) NOT NULL UNIQUE,
      name VARCHAR(255) NOT NULL,
      description VARCHAR(255) NOT NULL,
      image VARCHAR(255) NOT NULL,
      validation VARCHAR(255) NOT NULL,
      created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      ipaddr VARCHAR(255) NOT NULL
    );
 */
require_once('db.php');
class BadgeError extends Exception {}
class Badge {
  private $data;
  private $dirty = TRUE;
  private function __construct($data, $new = TRUE){
    $this->data = $data;
  }
  
  public function __get($name) {
    return $this->data[$name];
  }
  public function isSaved() {
    return !($this->dirty);
  }
  public function save() {
    $table = self::db()->useTable('badge');
    
    $this->data['ipaddr'] = $_SERVER['HTTP_HOST'];
    $this->data['uuid'] = $this->uuid();
    if (($id = $table->insert($this->data)) != FALSE) {
      $this->data['id'] = $id;
      $this->dirty = FALSE;
      return TRUE;
    } else {
      return FALSE;
    }
  }
  private function uuid() {
    // hash by name, ipaddress, and image
    $d = $this->data;
    return hash('sha1', $d['name'] . $d['ipaddr'] . $d['image']);
  }
  public function __set($name, $value) {
    $this->dirty = TRUE;
    return $this->data[$name] = $value;
  }
  
  private static $db;
  private static function db() {
    if (empty(self::$db)) self::$db = new Db();
    return self::$db;
  }
  public static function create($data = NULL) {
    if (!is_array($data)) {
      throw new BadgeError('Badge::create(): parameter must be an associative array');
    }
    $c = __CLASS__;
    return new $c($data);
  }
}