<!doctype html>
<html>
  <head>
    <title>Badge Builder</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
  <body>
    <div role='container'>
      <h1>Badge Builder</h1>
      <?php if (!$complete): ?>
      <p role='description'>
        Badges can be used to signal achievements, skills, qualities or
        affiliations. The Badge Builder allows you to experiment with badges
        and make one of your own for your own website or to give to someone
        else.
      </p>
      <form action="builder.php" enctype="multipart/form-data" method="post" name="builder">
        <div>
          <label>
            <span role='label'>Name</span>
            <input type='text' name='name'>
          </label>
          <p role='description'>
            Name your badge. This will be displayed alongside your badge image.
          <p>
        </div>

        <div>
          <label>
            <span role='label'>Description</span>
            <input type='text' name='description'>
          </label>
          <p role='description'>
            Describe your badge - be as specific as possible to explain the
            badge, including any rubrics or requirements behind the
            badge. Note: this may or may not be displayed on the badge
            depending on the size.
          <p>
        </div>

        <div>
          <label>
            <span role='label'>Image</span>
            <input type='file' name='image'>
          </label>
          <p role='description'>
            Upload an image for your badge. Make sure it's reasonably sized,
            and that it's relatively square.
          <p>
        </div>

        <div>
          <label>
            <span role='label'>Evidence URL</span>
            <input type='text' name='evidence'>
          </label>
          <p role='description'>
            Badges are more than just images on a web page. The true value
            comes from the evidence that the badge is linked to. This might be
            a link to original work, your personal blog or website, a Flickr
            stream, etc. Thus the Evidence URL demonstrates that you deserve
            this badge.
          <p>
        </div>

        <div>
          <input type='submit' value='Create Badge'>
        </div>
      </form>
    </div>
  </body>
</html>




