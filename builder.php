<?php
require_once "imageupload.php";
require_once "badgescript.php";

$image = new ImageUpload($_FILES['image']);
if (!$image->valid()) {
  print_r($image->error() . PHP_EOL);
} else {
  $image->move();
  
  $path = $image->webpath();
  $name = htmlspecialchars($_POST['name']);
  $description = htmlspecialchars($_POST['description']);
  $evidence = $_POST['evidence'];
  
  $script = new BadgeScript($image, $name, $description, $evidence);
  $script->writefile();
  
  $complete = $script->badgeHTML();
  require_once "index.php";
}
