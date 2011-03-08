<?php if (!$_FILES): ?>
 <form action="#" enctype="multipart/form-data" method="post" name="builder">
    <label>real: <input type='file' name='real'></label><br/>
    <label>fake: <input type='file' name='fake'></label><br/>
    <label>huge: <input type='file' name='huge'></label><br/>
    <input type='submit' value='start test'>
 </form>

<?php else: ?>

<?php
require_once('simpletest/autorun.php');
require_once('../classes/imageupload.php');

class TestOfImageUpload extends UnitTestCase {
  function setUp() {
    $this->fake = $_FILES['fake'];
    $this->real = $_FILES['real'];
    $this->huge = $_FILES['huge'];
  }
  
  function testConstruction() {
    $good = new ImageUpload($this->real);
    $this->assertTrue($good instanceof ImageUpload);
    $this->assertTrue($good->valid());
    
    $bad = new ImageUpload($this->fake);
    $this->assertTrue($bad instanceof ImageUpload);
    $this->assertFalse($bad->valid());
    
    $huge = new ImageUpload($this->huge);
    $this->assertTrue($huge instanceof ImageUpload);
    $this->assertFalse($huge->valid());
    $this->assertEqual($huge->error(), 'too big');
  }
}
?>

<?php endif; ?>

