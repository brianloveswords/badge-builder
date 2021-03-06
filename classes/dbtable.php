<?php

class DbTableError extends Exception {}
class DbTable {
  private $db;
  private $error = '';
  private $last_query;
  
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
  public function insert($input_values) {
    if (empty($input_values)) return FALSE;
    if (!is_array($input_values)) {
      throw new DbTableError('insert(): parameter must be an associative array');
    }
    foreach ($this->fields() as $key => $value) {
      $in_fields[] = sprintf('`%s`', mysql_real_escape_string($key));
      if ($input_values[$key] !== NULL) {
        $in_values[] = sprintf('"%s"', mysql_real_escape_string($input_values[$key]));
      } else {
        $in_values[] = 'NULL';
      }
    }
    $q_string = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $this->name(),
                        implode($in_fields, ','), implode($in_values, ','));
    if (!$this->query($q_string)) return FALSE;
    return mysql_insert_id();
  }
  public function findOne($search) {
    if (empty($search)) return FALSE;
    if (!is_array($search)) {
      throw new DbTableError('findOne(): parameter must be an associative array');
    }
    if ($result = $this->singularAction('SELECT *', $search)) {
      return mysql_fetch_object($result);
    } else {
      return FALSE;
    }
  }
  
  public function findAll() {
    $query = $this->query(sprintf('SELECT * FROM `%s`', $this->name()));
    while ($row = mysql_fetch_object($query)) $rows[] = $row;
    return $rows;
  }
  
  public function deleteOne($search) {
    if (empty($search)) return FALSE;
    if (!is_array($search)) {
      throw new DbTableError('deleteOne(): parameter must be an associative array');
    }
    return $this->singularAction('DELETE', $search);
  }
  
  private function singularAction($prefix, $terms) {
    // currently we only take the first one.
    $valid_fields = $this->fields();
    $field = mysql_real_escape_string(array_pop(array_keys($terms)));
    $value = mysql_real_escape_string(array_pop(array_values($terms)));
    if (empty($valid_fields[$field])) {
      throw new DbTableError('findOne(): trying to find against a field that does not exist');
    }
    $where = sprintf('`%s` = "%s"', $field, $value);
    $q_string = sprintf('%s FROM `%s` WHERE %s LIMIT 1', $prefix, $this->name(), $where);
    if (!($query = $this->query($q_string))) return FALSE;
    return $query;
  }
  
  public function fields() {
    $query = $this->query(sprintf('SHOW COLUMNS FROM `%s`', $this->name()));
    while ($row = mysql_fetch_object($query)) $rows[$row->Field] = $row;
    return $rows;
  }
  public function name() {
    if (empty($this->db)) {
      throw new DbTableError('name(): Invalid Db class instance');
    }
    return $this->name;
  }
  public function error() {
    return $this->error;
  }
  public function last_query() {
    return $this->last_query;
  }
  private function query($string) {
    $this->last_query = $string;
    if (!($result = $this->db->query($string))) $this->error = mysql_error(); 
    return $result;
  }
}