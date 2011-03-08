<?php if (!$_FILES): ?>
 <form action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post" name="builder">
    <label>real: <input type='file' name='real'></label><br/>
    <label>fake: <input type='file' name='fake'></label><br/>
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
  }
  
  function testConstruction() {
    $good = new ImageUpload($this->real);
    $this->assertTrue($good instanceof ImageUpload);
    $this->assertTrue($good->valid());
    
    $bad = new ImageUpload($this->fake);
    $this->assertTrue($bad instanceof ImageUpload);
    $this->assertFalse($bad->valid());
  }
}
?>

<?php endif; ?>

