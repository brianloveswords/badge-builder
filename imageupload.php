<?php

class ImageUpload {
  public $maxsize = 1073741824; /* 1mb */
  public $destination = 'images/';
  public $validtypes = array('png', 'gif', 'jpg', 'jpeg');
  public $error = '';
  
  public function __construct($form_file) {
    $this->name = $form_file['name'];
    $this->mimetype = $form_file['type'];
    $this->uploaderr = $form_file['error'];
    $this->size = $form_file['size'];
    $this->pathinfo = pathinfo($this->name);
    $this->tmppath = $form_file['tmp_name'];
    $this->imginfo = @getimagesize($this->tmppath);
  }
  
  public function valid() {
    /* trivial checks */
    if ($this->uploaderr > 0) {
      $this->error = 'generic error';
      return FALSE;
    }
    if ($this->size > $this->maxsize) {
      $this->error = 'too big';
      return FALSE;
    }
    if (!preg_match('/^image/', $this->mimetype)) {
      $this->error = 'not an image';
      return FALSE;
    }
    if (!in_array($this->pathinfo['extension'], $this->validtypes)) {
      $this->error = 'invalid extension';
      return FALSE;
    }

    /* more in depth check */
    if (empty($this->imginfo)) {
      $this->error = 'not a real image';
      return FALSE;
    }
    return TRUE;
  }
  
  public function error() {
    if (strlen($this->error) == 0) return FALSE;
    return $this->error;
  }

  public function move($path = NULL) {
    $dest = $path ? $path : $this->destination;
    $source = $this->tmppath;
    if (!self::destination_exists($dest)) {
      if (!self::make_destination($dest)) {
        throw new Exception('Could not make destination directory');
      }
    } else if (!self::destination_writable($dest)) {
      throw new Exception('Destination is not writable and chmod() was ineffective.');
    }
    $ext = image_type_to_extension($this->imginfo[2]);
    $imghash = self::imagehash($source);
    $destname = str_replace('//', '/', sprintf("%s/%s%s", $dest, $imghash, $ext));
    if (!file_exists($destname) && !move_uploaded_file($source, $destname)) {
      throw new Exception('Could not move uploaded file');
    }
    return ($this->finalpath = $destname);
  }
  public function webpath() {
    if (empty($this->finalpath)) {
      throw new Exception('Cannot get webpath without first moving upload.');
    }
    return sprintf('http://%s/%s', $_SERVER['SERVER_NAME'], $this->finalpath);
  }
  
  /* static methods */
  public static function imagehash($path) {
    if (!is_readable($path)) {
      throw new Exception('Source path is not readable');
    }
    return hash('sha1', file_get_contents($path));
  }
  public static function make_destination($path) {
    return mkdir($path);
  }
  public static function destination_exists($path) {
    return realpath($path);
  }
  public static function destination_writable($path) {
    $abspath = realpath($path);
    return is_writable($abspath);
  }
  public static function chmod_destination($path) {
    $abspath = realpath($path);
    return chmod($abspath, 0777);
  }
}
