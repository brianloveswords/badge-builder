<?php
require_once('_findbadge.php');
require_once('../classes/badgescript.php');
header('Content-type: text/javascript');
$script = new BadgeScript($badge);
?>
<?php print($script->script()) ?>
