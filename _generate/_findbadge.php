<?php
// Make sure the .htaccess file is redirecting.
require('../settings.php');
require('../classes/badge.php');
require_once('../classes/badgescript.php');

function bail() {
    header('HTTP/1.1 404 Not Found');
    print "<h1>Badge Not Found</h1>";
    exit();
}

$search = array('uuid' => $_GET['id']);
if ( strpos($search['uuid'], '-') === FALSE ) {
  if ( !($badge = Badge::find($search)) ) bail();
} else {
  if ( !($badge = Badge::findByShortId($search['uuid'])) ) bail();
}
$script = new BadgeScript($badge);

