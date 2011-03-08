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
    $this->dirty = $new;
  }
  
  public function __get($name) {
    return $this->data[$name];
  }
  public function isSaved() {
    return !($this->dirty);
  }
  public function save() {
    $table = self::dbTable();
    
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
  public function delete() {
    if (!$this->isSaved()) return FALSE;
    $table = self::dbTable();
    if ($table->deleteOne(array('id' => $this->data['id']))) {
      $this->dirty = TRUE;
      $this->data['id'] = NULL;
      return TRUE;
    } else {
      return FALSE;
    }
  }
  
  public function uuid() {
    // hash by name, ipaddress, and image
    $d = $this->data;
    return hash('sha1', $d['name'] . $d['ipaddr'] . $d['image']);
  }
  public function __set($name, $value) {
    $this->dirty = TRUE;
    return $this->data[$name] = $value;
  }
  
  private static $table;
  private static function dbTable() {
    if (empty(self::$table)) {
      $db = new Db();
      self::$table = $db->useTable('badge');
    }
    return self::$table;
  }
  public static function create($data = NULL) {
    if (!is_array($data)) {
      throw new BadgeError('Badge::create(): parameter must be an associative array');
    }
    $class = __CLASS__;
    return new $class($data);
  }
  public static function find($fields = NULL) {
    if (!is_array($fields)) {
      throw new BadgeError('Badge::find(): parameter must be an associative array');
    }
    $table = self::dbTable();
    if (($badge_data = $table->findOne($fields)) == FALSE) {
      return FALSE;
    };
    $class = __CLASS__;
    return new $class((array)$badge_data, FALSE);
  }
  public static function findAll() {
    $rows = self::dbTable()->findAll();
    for($i = 0; $rows[$i]; $i++) {
      $badges[] = self::create((array)$rows[$i]);
    }
    return $badges;
  }
}