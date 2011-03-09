<?php
// TODO: more elegant error reporting
require_once('settings.php');
function __autoload($classname) { require_once "classes/" . $classname . ".php"; }

$errors = array();

$image = new ImageUpload($_FILES['image']);

$valid_regex = "@^(https?)://[^\s/$.?#].[^\s]*$@iS";
$validation_url = trim($_POST['evidence'], '!"#$%&\'()*+,-./@:;<=>[\\]^_`{|}~');
$name = trim(htmlspecialchars($_POST['name']));
$description = trim(htmlspecialchars($_POST['description']));

if (!preg_match($valid_regex, $validation_url)) {
  $errors['validation'] = array('invalid url', $validation_url);
}
if (empty($name)) {
  $errors['name'] = array('invalid name', $name);
}
if (empty($description)) {
  $errors['description'] = array('invalid description', $description);
}
if (!$image->valid()) {
  $errors['image'] = array('invalid image: '.$image->error());
}
if (count($errors)) {
  print "<pre>";
  print_r($errors);
  print "</pre>";
}

else {
  $image->move();
  $data = array(
    'name' => $name,
    'description' => $description,
    'image' => $image->finalpath(),
    'validation' => $validation_url,
  );
  $badge = Badge::create($data);
  if ($badge->save()) {
    Utilities::redirect(sprintf('badge/%s', $badge->uuid()));
  } else {
    print_r('error saving: ' . $badge->error());
  }
  //require_once "index.php";
}
