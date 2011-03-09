<?php
class Utilities {
  public static function redirect($where, $immediately = TRUE) {
    header(sprintf('Location: %s', $where),  TRUE, 301);
    if ($immediately) { exit(); }
  }
}
