<?php
// Make sure the .htaccess file is redirecting.
require('../settings.php');
require('../classes/badge.php');
require_once('../classes/badgescript.php');

$search = array('uuid' => $_GET['id']);
if ( !($badge = Badge::find($search)) ) {
  header('HTTP/1.1 404 Not Found');
  print "<h1>Badge Not Found</h1>";
  exit();
}
$script = new BadgeScript($badge);

