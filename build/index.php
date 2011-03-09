<?php
require('../settings.php');
if (empty($_POST) || empty($_FILES)) {
  require_once('build.tpl.php');
} else {
  require_once('build.proc.php');
}
