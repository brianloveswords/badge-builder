<?php
require_once "imageupload.php";
require_once "badgescript.php";

header('Content-Type: text/plain');

$image = new ImageUpload($_FILES['image']);
if (!$image->valid()) {
  print_r($image->error() . PHP_EOL);
} else {
  $image->move();
  
  $path = $image->webpath();
  $name = htmlspecialchars($_POST['name']);
  $description = htmlspecialchars($_POST['description']);
  
  $script = new BadgeScript($image, $name, $description);
  $script->writefile();
  print $script->badgeHTML() . PHP_EOL;
  
}
