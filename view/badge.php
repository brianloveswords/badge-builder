<?php require_once('_findbadge.php'); ?>
<!doctype html>
<html>
  <head>
    <title>Badge Builder</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet.css">
  </head>
  <body>
    <div role='container'>
      <h1>Badge Builder</h1>
      <p role='description'>
        Here is your badge, as well as code to put it on any personal website,
        or send to someone else to put on their website. Once added to a site,
        the badge will contain all of the information that you included when
        you created the badge, including the link back to the evidence you
        provided. You can point people to your badge to communicate and
        demonstrate that particular skill, achievement, quality or
        affiliation.
      </p>
      <pre>
        <?php print_r($badge) ?>
      </pre>
    </div>
  </body>
</html>