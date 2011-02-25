<?php
require_once "imageupload.php";
require_once "scriptwriter.php";

header('Content-Type: text/plain');

$image = new ImageUpload($_FILES['image']);
if (!$image->valid()) {
  print_r($image->error() . PHP_EOL);
} else {
  $image->move();
  
  $path = $image->webpath();
  $name = htmlspecialchars($_POST['name']);
  $description = htmlspecialchars($_POST['description']);
  
  $writer = new BadgeScriptWriter($path, $name, $description);
  $writer->writefile();
}

print_r($_SERVER);
print_r($_POST);
print_r($_FILES);