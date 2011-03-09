<?php
require_once('../settings.php');
require_once('../classes/badge.php');
require_once('../classes/badgescript.php');
function make_script_object($badge) {
  return new BadgeScript($badge);
}
$badges = array_map('make_script_object', Badge::findAll());
require_once('view.tpl.php');
?>