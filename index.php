<!doctype html>
<html>
  <head>
    <title>Badge Builder</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
  <body>
    <div role='container'>
      <h1>Badge Builder</h1>
      <form action="builder.php" enctype="multipart/form-data" method="post" name="builder">
        <div>
          <label>
            <span role='label'>Name</span>
            <input type='text' name='name'>
          </label>
          <p role='description'>Name your badge. This will be displayed alongside your badge image.<p>
        </div>

        <div>
          <label>
            <span role='label'>Description</span>
            <input type='text' name='description'>
          </label>
          <p role='description'>Describe your badge. This may or may not be displayed on the badge depending on the size.<p>
        </div>

        <div>
          <label>
            <span role='label'>Image</span>
            <input type='file' name='image'>
          </label>
          <p role='description'>Upload an image for your badge. Make sure it's reasonably sized, and that it's relatively square.<p>
        </div>

        <div>
          <label>
            <span role='label'>Proof URL</span>
            <input type='text' name='proof'>
          </label>
          <p role='description'>The URL that demonstrates the proof that you deserve this badge. Elaborate here.<p>
        </div>

        <div>
          <input type='submit' value='Create Badge'>
        </div>
      </form>
    </div>
  </body>
</html>




